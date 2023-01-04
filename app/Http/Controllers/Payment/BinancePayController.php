<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\NewUserGenealogyAutoPlacement;
use App\Jobs\SaleLevelCommissionJob;
use App\Models\Package;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\Transaction;
use App\Models\Wallet;
use Arr;
use Auth;
use Carbon\Carbon;
use CryptoPay\Binancepay\BinancePay;
use DB;
use Exception;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

class BinancePayController extends Controller
{

    public function initiateBinancePay(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'package' => ['required', 'exists:packages,slug'],
            'method' => ['required', 'in:binance-pay,wallet'] /**/
        ])->validate();

        $user = Auth::user();
        $user->loadMax('purchasedPackages', 'invested_amount');

        $package = Package::whereSlug($validated['package'])->firstOrFail();

        if ($user->purchased_packages_max_invested_amount > $package->amount) {
            $json['status'] = false;
            $json['message'] = "Please select a package amount is higher than or equal to USDT " . $user->purchased_packages_max_invested_amount;
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            return DB::transaction(function () use ($user, $package, $validated) {


                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'currency' => "USDT",
                    'amount' => $package->amount,
                    'type' => ($validated['method'] === 'wallet') ? 'wallet' : 'crypto',
                    'status' => "INITIAL",
                ]);

                // Order Data
                $data['order_amount'] = $transaction->amount;
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


                if ($transaction->type === 'wallet') {

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
                        'data' => '{"productName":"' . $package->name . '","transactTime":' . (time() * 1000) . ',"totalFee":' . $transaction->amount . ',"currency":"' . $transaction->currency . '"}',
                    ];

                    $transaction->create_order_request = json_encode($req_data, JSON_THROW_ON_ERROR);

                    if ($user->wallet->balance < $transaction->amount) {
                        $res_data['bizStatus'] = 'PAY_CLOSED';

                        $transaction->status = 'CANCELED';
                        $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = false;
                        $json['message'] = "Not enough funds in wallet to proceed!";
                        $json['icon'] = 'error'; // warning | info | question | success | error
                        return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                    }

                    $res_data['bizStatus'] = 'PAY_SUCCESS';

                    $transaction->status = 'PAID';
                    $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                    $transaction->save();

                    DB::transaction(function () use ($transaction) {
                        $res = $this->grantCommissionsToUsers($transaction);

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $transaction->user_id],
                            ['balance' => 0]
                        );

                        $wallet->decrement('balance', $transaction->amount);
                    });

                    $json['status'] = true;
                    $json['message'] = 'Request successful';
                    $json['icon'] = 'success'; // warning | info | question | success | error
                    $json['data'] = ['checkoutUrl' => route('user.packages.active')];
                    return response()->json($json);
                }

                if ($transaction->type === 'crypto') {
                    // dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
                    $binancePay = new BinancePay("binancepay/openapi/v2/order");

                    $data['trx_id'] = $transaction->id;
                    $data['merchant_trade_no'] = $this->generateUniqueCode();

                    $result = $binancePay->createOrder($data);

                    if ($result['status'] === 'SUCCESS') {
                        $transaction->merchant_trade_no = $data['merchant_trade_no'];
                        $transaction->create_order_request = json_encode($binancePay->getRequest(), JSON_THROW_ON_ERROR);
                        $transaction->create_order_response = json_encode($result['data'], JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = true;
                        $json['message'] = 'Request successful';
                        $json['icon'] = 'success'; // warning | info | question | success | error
                        $json['data'] = $result['data'];
                        return response()->json($json);
                    }
                    throw new \RuntimeException($result['errorMessage'], $result['code']);
                }
                throw new \RuntimeException("Something wrong with your payment method!");
            });
        } catch (Throwable $e) {
            $json['status'] = false;
            $json['message'] = $e->getMessage();
            $json['code'] = $e->getCode();
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_FORBIDDEN);
        }
    }

    public function callback(Request $request): \Illuminate\Http\JsonResponse
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

                                $transaction->status = $order_status['data']['status'];
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();

                                $this->grantCommissionsToUsers($transaction);

                                break;
                            case "PAY_CLOSED":
                                $transaction->status = "CANCELED";
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();
                                break;
                        }
                    } catch (\Exception $e) {
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

    public function response(Request $request)
    {
        // The URL to redirect to when the payment is successful.
        // check order status
        $transaction = Transaction::find($request->get('trx-id'));
        // check order exists / pay status / redirect ti success page or error page
        return redirect()->route('user.packages.active', ['trx-id' => $request->get('trx-id')])->with('success', 'Payment successful'); // show success invoice
    }

    public function fallback(Request $request)
    {
        // The URL to redirect to when payment is failed.
        // check order status
        $transaction = Transaction::find($request->get('trx-id'));
        // check order exists / pay status / redirect ti success page or error page
        return redirect()->route('user.packages.active', ['trx-id' => $request->get('trx-id')])->with('error', 'Payment unsuccessful'); // show failure invoice
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
     * @throws Throwable
     */
    private function grantCommissionsToUsers(Transaction $transaction): bool
    {
        return DB::transaction(static function () use ($transaction) {
            PurchasedPackage::updateOrCreate(['transaction_id' => $transaction->id], [
                'user_id' => $transaction->user_id,
                'package_id' => $transaction->package_id,
                'invested_amount' => $transaction->package->amount,
                'payable_percentage' => $transaction->package->daily_leverage,
                'status' => 'ACTIVE',
                'expired_at' => Carbon::now()->addMonths($transaction->package->month_of_period)->format('Y-m-d H:i:s'),
                'package_info' => $transaction->package->toJson(),
            ]);

            $package = $transaction->purchasedPackage;
            $purchasedUser = $package->user;

            $strategies = Strategy::whereIn('name', ['commissions', 'commission_level_count', 'max_withdraw_limit'])->get();

            $max_withdraw_limit = $strategies->where('name', 'max_withdraw_limit')->first(null, new Strategy(['value' => 400]));
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $purchasedUser->id],
                ['balance' => 0, 'withdraw_limit' => 0]
            );

            $withdraw_limit = ($package->invested_amount * $max_withdraw_limit->value) / 100;
            $wallet->increment('withdraw_limit', $withdraw_limit);

            if ($purchasedUser->position === null) {
                if ($purchasedUser->super_parent_id === config('fortify.super_parent_id')) {
                    logger()->notice("NewUserGenealogyAutoPlacement::class via BinancePayController");
                    NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
                }
                return true;
            }

            SaleLevelCommissionJob::dispatch($purchasedUser, $package)->afterCommit();

            return true;
        });
    }
}
