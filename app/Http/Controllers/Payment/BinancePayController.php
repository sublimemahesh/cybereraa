<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Transaction;
use Arr;
use Auth;
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

        try {
            return DB::transaction(function () use ($validated) {
                $user = Auth::user();
                $package = Package::whereSlug($validated['package'])->first();
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'currency' => "USDT",
                    'amount' => $package->amount,
                    'type' => ($validated['method'] === 'wallet') ? 'wallet' : 'crypto',
                    'status' => "INITIAL",
                ]);
                if ($transaction->type === 'wallet') {
                    $json['status'] = false;
                    $json['message'] = "Something wrong with your payment method!";
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($transaction->type === 'crypto') {
                    // dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
                    $binancePay = new BinancePay("binancepay/openapi/v2/order");
                    $data['merchant_trade_no'] = $this->generateUniqueCode();
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
                        $transaction = Transaction::where('merchant_trade_no', $merchantTradeNo)->firstOrNew();

                        switch ($webhookResponse['bizStatus']) {
                            // TODO: check payment success callback response and consider this success code segment is needed or can be removed
                            case "PAY_SUCCESS":
                                $order_status = (new BinancePay("binancepay/openapi/v2/order/query"))
                                    ->query(["merchantTradeNo" => $merchantTradeNo]);
                                $transaction->status = $order_status['data']['status'];
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();

                                // TODO: ASSIGN OTHER PRIVILEGES IF THEIR ANY
                                break;
                            case "PAY_CLOSED":
                                $transaction->status = "CANCELED";
                                $transaction->status_response = json_encode($webhookResponse, JSON_THROW_ON_ERROR);
                                $transaction->save();
                                break;
                        }
                    } catch (\Exception $e) {
                        $data = date('Y-m-d H:i:s') . " | [Note] line:129 BinancePayController: " . $e->getMessage() . "\n";
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
            $data = date('Y-m-d H:i:s') . " | [Note] line:150 BinancePayController: " . $e->getMessage() . "\n";
            file_put_contents(public_path() . "/storage/binance-pay/error-log.log", $data, FILE_APPEND);
            return response()->json(['returnCode' => 'FAIL', 'returnMessage' => $e->getMessage()], 200);
        }

        return response()->json(['returnCode' => 'SUCCESS', 'returnMessage' => null], 200);
    }

    public function response(Request $request)
    {
        header("Content-Type: application/json");
        $response = $request;
        return [$request, $request->all()];
        dd($response, $response->all());
    }

    public function fallback(Request $request)
    {
        header("Content-Type: application/json");
        $response = $request;
        return [$request, $request->all()];
        dd($response, $response->all());
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
}
