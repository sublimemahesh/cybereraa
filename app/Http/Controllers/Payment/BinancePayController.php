<?php

namespace App\Http\Controllers\Payment;

use App\Actions\ActivateTransaction;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Strategy;
use App\Models\Transaction;
use App\Models\User;
use Arr;
use Auth;
use CryptoPay\Binancepay\BinancePay;
use DB;
use Exception;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use URL;
use Validator;

class BinancePayController extends Controller
{

    public function initiateBinancePay(Request $request, ActivateTransaction $activateTransaction)
    {
        $validated = Validator::make($request->all(), [
            'package' => [
                'required',
                $request->get('package') !== 'custom' ? 'exists:packages,slug' : 'in:custom',
            ],
            'amount' => ['nullable', 'required_if:package,custom'],
            'method' => ['required', 'in:binance,main,topup,manual'],/**/
            'proof_document' => ['required_if:method,manual', 'nullable', 'image' /*'file:pdf,jpg,jpeg,png'*/],
            'transaction_id' => ['required_if:method,manual', 'nullable', 'string', 'max:255'],
            'purchase_for' => [
                'nullable',
                Rule::exists('users', 'id'),
                function ($attribute, $value, $fail) {
                    $exists = User::where('id', $value)->where('id', '<>', Auth::user()->id)
                        ->whereRelation('roles', 'name', 'user')
                        ->exists();
                    if (!$exists) {
                        $fail('Selected user invalid or does not allowed to be purchased a package!.');
                    }
                }
            ],
        ])->validate();

        if (!empty($validated['purchase_for'])) {
            $user = User::findOrFail($validated['purchase_for']);
            $purchased_by = Auth::user();
        } else {
            $user = Auth::user();
            $purchased_by = $user;
        }

        $user->loadMax('purchasedPackages', 'invested_amount');

        if ($validated['package'] === 'custom') {
            $strategies = Strategy::whereIn('name', ['min_custom_investment', 'max_custom_investment', 'custom_investment_gas_fee'])->get();
            $min_custom_investment = $strategies->where('name', 'min_custom_investment')->first(null, fn() => new Strategy(['value' => 10]));
            $max_custom_investment = $strategies->where('name', 'max_custom_investment')->first(null, fn() => new Strategy(['value' => 5000]));
            $custom_investment_gas_fee = $strategies->where('name', 'custom_investment_gas_fee')->first(null, fn() => new Strategy(['value' => 1]));

            if ($validated['amount'] < $min_custom_investment?->value || $validated['amount'] > $max_custom_investment?->value) {
                $json['status'] = false;
                $json['message'] = "Please select a package amount between USDT: {$min_custom_investment?->value} - {$max_custom_investment?->value}";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $package = new Package([
                'name' => 'Custom',
                'slug' => 'custom',
                'currency' => 'USDT',
                'amount' => $validated['amount'],
                'gas_fee' => ($validated['amount'] * $custom_investment_gas_fee?->value) / 100,
                'month_of_period' => 30,
                'daily_leverage' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $package = Package::whereSlug($validated['package'])->firstOrFail();
        }

        $max_amount = $user->purchased_packages_max_invested_amount;
        if (Gate::inspect('purchase', [$package, $max_amount])->denied()) {
            $json['status'] = false;
            $json['message'] = "Please select a package amount is higher than or equal to USDT " . $max_amount;
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            return DB::transaction(function () use ($user, $purchased_by, $package, $validated, $activateTransaction) {

                //$amount = $package->amount;
                //$gas_fee = $user->purchasedPackages()->count() <= 0 ? $package->gas_fee : 0;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'purchaser_id' => $purchased_by->id,
                    'package_id' => $package->id,
                    'package_info' => $package->toJson(),
                    'currency' => "USDT",
                    'amount' => $package->amount,
                    'gas_fee' => $package->gas_fee,
                    'type' => in_array(strtolower($validated['method']), ['main', 'topup', 'manual']) ? 'wallet' : 'crypto',
                    'pay_method' => $validated['method'],
                    'status' => "INITIAL",
                ]);

                $transaction_amount = $transaction->amount + $transaction->gas_fee;

                // Order Data
                $data['order_amount'] = $transaction_amount;
                $data['package_id'] = $package->id;
                $data['goods_name'] = $package->name;
                $data['goods_detail'] = null;
                $data['buyer'] = [
                    "referenceBuyerId" => $user->id,
                    "buyerEmail" => $user->email,
                    "buyerName" => [
                        "firstName" => Arr::first(explode(" ", $user->name)),
                        "lastName" => Arr::last(explode(" ", $user->name))
                    ]
                ];

                if ($transaction->type === 'wallet') { // 'main', 'topup', 'manual'

                    $req_data = [
                        "orderAmount" => $data['order_amount'],
                        "currency" => 'USDT',
                        "goods" => [
                            "referenceGoodsId" => $data['package_id'],
                            "goodsName" => $data['goods_name'],
                            "goodsDetail" => $data['goods_detail'] ?? null
                        ],
                        "buyer" => $data['buyer']
                    ];

                    $res_data = [
                        'bizType' => 'PAY',
                        'data' => '{"productName":"' . $package->name . '","transactTime":' . (time() * 1000) . ',"totalFee":' . $transaction_amount . ',"currency":"' . $transaction->currency . '"}',
                    ];

                    $transaction->create_order_request = json_encode($req_data, JSON_THROW_ON_ERROR);

                    if (strtolower($transaction->pay_method) === 'main') {
                        $wallet_balance_check = $purchased_by->wallet->balance < $transaction_amount;
                        $withdraw_limit_check = $purchased_by->wallet->withdraw_limit < $transaction_amount;
                        if ($wallet_balance_check || $withdraw_limit_check) {
                            $res_data['bizStatus'] = 'PAY_CLOSED';

                            $transaction->status = 'CANCELED';
                            $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                            $transaction->save();

                            $json['status'] = false;
                            $json['message'] = $wallet_balance_check ? "Not enough funds in wallet to proceed!" : "Withdraw Limit exceeded!";
                            $json['icon'] = 'error'; // warning | info | question | success | error
                            return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                        }
                    }

                    if ($purchased_by->wallet->topup_balance < $transaction_amount && (strtolower($transaction->pay_method) === 'topup')) {
                        $res_data['bizStatus'] = 'PAY_CLOSED';

                        $transaction->status = 'CANCELED';
                        $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = false;
                        $json['message'] = "Not enough funds in topup wallet to proceed!";
                        $json['icon'] = 'error'; // warning | info | question | success | error
                        return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                    }

                    if (strtolower($transaction->pay_method) === 'manual') {
                        $validated_file = Validator::make(
                            [
                                'proof_document' => request()->file('proof_document'),
                                'transaction_id' => request()->input('transaction_id')
                            ],
                            [
                                'proof_document' => 'required|file:pdf,jpg,jpeg,png',
                                'transaction_id' => 'required|unique:transactions,transaction_id',
                            ]
                        )->validate();
                        $file = $validated_file['proof_document'];
                        $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                        $file->storeAs('user/manual-purchase', $proof_documentation);

                        $res_data['bizStatus'] = 'PAY_PENDING';

                        $transaction->status = 'PENDING';
                        $transaction->transaction_id = $validated_file['transaction_id'];
                        $transaction->proof_document = $proof_documentation;
                        $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = true;
                        $json['message'] = 'Request successful';
                        $json['icon'] = 'success'; // warning | info | question | success | error
                        $json['data'] = ['checkoutUrl' => URL::signedRoute('user.transactions.invoice', $transaction)];
                        return response()->json($json);
                    }

                    DB::transaction(function () use ($activateTransaction, $transaction, $purchased_by, $transaction_amount) {

                        $res = $activateTransaction->execute($transaction);

                        $wallet = $purchased_by->wallet;

                        if (strtolower($transaction->pay_method) === 'main') {
                            $wallet->decrement('balance', $transaction_amount);
                            $wallet->decrement('withdraw_limit', $transaction_amount);
                        }

                        if (strtolower($transaction->pay_method) === 'topup') {
                            $wallet->decrement('topup_balance', $transaction_amount);
                        }

                        $res_data['bizStatus'] = 'PAY_SUCCESS';

                        $transaction->update([
                            'status' => 'PAID',
                            'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                        ]);
                    });

                    $json['status'] = true;
                    $json['message'] = 'Request successful';
                    $json['icon'] = 'success'; // warning | info | question | success | error
                    $json['data'] = ['checkoutUrl' => URL::signedRoute('user.transactions.invoice', $transaction)];
                    return response()->json($json);
                }

                if (strtolower($transaction->pay_method) === 'binance') { // crypto
                    // dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
                    $binancePay = new BinancePay("binancepay/openapi/v2/order");

                    $data['trx_id'] = $transaction->id;
                    $data['merchant_trade_no'] = $this->generateUniqueCode();

                    $result = $binancePay->createOrder($data);

                    $transaction->merchant_trade_no = $data['merchant_trade_no'];
                    $transaction->create_order_request = json_encode($binancePay->getRequest(), JSON_THROW_ON_ERROR);

                    if ($result['status'] === 'SUCCESS') {
                        $transaction->create_order_response = json_encode($result['data'], JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = true;
                        $json['message'] = 'Request successful';
                        $json['icon'] = 'success'; // warning | info | question | success | error
                        $json['data'] = $result['data'];
                        return response()->json($json);
                    }

                    $transaction->save();
                    throw new \RuntimeException($result['errorMessage'], $result['code']);
                }

                throw new \RuntimeException("Something wrong with your payment method!");
            });
        } catch (Throwable $e) {
            throw $e;
            $json['status'] = false;
            $json['message'] = $e->getMessage();
            $json['code'] = $e->getCode();
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_FORBIDDEN);
        }
    }

    public function retryPayment(Transaction $transaction): RedirectResponse
    {
        if ($transaction->type === 'crypto') {
            $order_status = (new BinancePay("binancepay/openapi/v2/order/query"))->query(['merchantTradeNo' => $transaction->merchant_trade_no]);

            $transaction->status = $order_status['data']['status'];
            $transaction->save();

            if ($transaction->status === 'INITIAL') {
                return redirect()->to($transaction->create_order_response_info->checkoutUrl);
            }
            return redirect()->signedRoute('user.transactions.invoice', $transaction);
        }

        return redirect()->route('user.packages.active')->with('warning', 'Wallet transaction cannot be retry when canceled. Please select a package and purchase!'); // show success invoice
    }

    public function callback(Request $request, ActivateTransaction $activateTransaction): JsonResponse
    {
        //This line gets all your json response from binance when a customer makes payment
        header("Content-Type: application/json");
        try {
            $webhookResponse = $request->all();
            $publicKey = (new BinancePay("binancepay/openapi/certificates"))->query($webhookResponse);

            if ($publicKey['status'] === "SUCCESS") {
                $payload = $request->header('Binancepay-Timestamp') . "\n" . $request->header('Binancepay-Nonce') . "\n" . json_encode($webhookResponse, JSON_THROW_ON_ERROR) . "\n";
                $decodedSignature = base64_decode($request->header('Binancepay-Signature'));

                if (openssl_verify($payload, $decodedSignature, $publicKey['data'][0]['certPublic'], OPENSSL_ALGO_SHA256)) {
                    try {
                        $merchantTradeNo = json_decode($webhookResponse['data'], true, 512, JSON_THROW_ON_ERROR)['merchantTradeNo'];
                        $transaction = Transaction::where('merchant_trade_no', $merchantTradeNo)->firstOr(function () use ($merchantTradeNo) {
                            throw new \RuntimeException("Order could not be found!: " . $merchantTradeNo);
                        });
                        $transaction->transaction_id = $webhookResponse['bizId'];
                        switch ($webhookResponse['bizStatus']) {
                            // TODO: check payment success callback response and consider this success code segment is needed or can be removed
                            case "PAY_SUCCESS":
                                $order_status = (new BinancePay("binancepay/openapi/v2/order/query"))->query(compact('merchantTradeNo'));

                                $activateTransaction->execute($transaction);

                                $transaction->status = $order_status['data']['status'];
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();

                                break;
                            case "PAY_CLOSED":
                                $transaction->status = "CANCELED";
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();
                                break;
                        }
                    } catch (\Exception $e) {
                    } catch (Throwable $e) {
                        $data = date('Y-m-d H:i:s') . " | [Note] line:139 | BinancePayController: " . $e->getMessage() . "\n";
                        file_put_contents(public_path() . "/storage/binance-pay/error-log.log", $data, FILE_APPEND);
                    }

                    $file = "binance-pay/webhook/" . date('Y-m-d') . "/binance-pay-webhook-callback.json";
                    $webhookResponse['ip'] = $_SERVER['REMOTE_ADDR'];

                    $response = [];
                    if (Storage::exists($file)) {
                        $response = json_decode(file_get_contents(storage($file)), true, 512, JSON_THROW_ON_ERROR);
                    }
                    $key = $webhookResponse['bizId'] ?? (microtime() . "-" . random_int(1000, 9999));
                    $response[$key] = $webhookResponse;
                    Storage::put($file, json_encode($response, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
                } else {
                    throw new \RuntimeException("Signature invalid");
                }

            } else {
                throw new \RuntimeException($publicKey["errorMessage"]);
            }
        } catch (Exception $e) {
            $data = date('Y-m-d H:i:s') . " | [Note] line:161 | BinancePayController: " . $e->getMessage() . "\n";
            file_put_contents(public_path() . "/storage/binance-pay/error-log.log", $data, FILE_APPEND);
            return response()->json(['returnCode' => 'FAIL', 'returnMessage' => $e->getMessage()], 200);
        }

        return response()->json(['returnCode' => 'SUCCESS', 'returnMessage' => null], 200);
    }

    public function response(Request $request): RedirectResponse
    {
        return $this->checkOrderStatus($request);
    }

    public function fallback(Request $request): RedirectResponse
    {
        return $this->checkOrderStatus($request);
    }

    private function generateUniqueCode(): int
    {
        try {
            do {
                $code = time() . random_int(10000000, 99999999);
            } while (Transaction::where("merchant_trade_no", $code)->exists());

            return $code;
        } catch (Exception $e) {
            return (int)str_pad(time(), 18, 0);
        }
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    private function checkOrderStatus(Request $request): RedirectResponse
    {
        $transaction = Transaction::findOr($request->get('trx-id'), function () {
            return redirect()->route('user.packages.active')->with('warning', 'Something went wrong'); // show success invoice
        });

        $order_status = (new BinancePay("binancepay/openapi/v2/order/query"))->query(['merchantTradeNo' => $transaction->merchant_trade_no]);

        $transaction->status = $order_status['data']['status'];
        $transaction->save();

        if ($transaction->status === 'INITIAL') {
            return redirect()->route('user.transactions.index', ['status' => 'initial']);
        }

        return redirect()->signedRoute('user.transactions.invoice', $transaction);
    }
}
