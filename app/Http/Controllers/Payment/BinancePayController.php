<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use CryptoPay\Binancepay\BinancePay;
use Illuminate\Http\Request;
use Storage;

class BinancePayController extends Controller
{
    public function initiateBinancePay()
    {
//        dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
        $binancePay = new BinancePay("binancepay/openapi/v2/order");
        $data['passcode_id'] = '10';
        $data['order_amount'] = '100';
        $data['package_id'] = '10';
        $data['goods_name'] = 'package 10';
        $data['goods_detail'] = 'package 10 details';
        $result = $binancePay->createOrder($data);
        dd($result);

        //Redirect user to the payment page

    }

    public function callback(Request $request): \Illuminate\Http\JsonResponse
    {
        //This line gets all your json response from binance when a customer makes payment
        header("Content-Type: application/json");
        try {
            $webhookResponse = $request->all();

            $publicKey = (new BinancePay("binancepay/openapi/certificates"))->querySignature($webhookResponse);

            if ($publicKey['status'] === "SUCCESS") {
                $payload = $request->header('Binancepay-Timestamp') . "\n" . $request->header('Binancepay-Nonce') . "\n" . json_encode($webhookResponse, JSON_THROW_ON_ERROR) . "\n";
                $decodedSignature = base64_decode($request->header('Binancepay-Signature'));

                if (openssl_verify($payload, $decodedSignature, $publicKey['data'][0]['certPublic'], OPENSSL_ALGO_SHA256)) {
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
        } catch (\Exception $e) {
            return response()->json(['returnCode' => 'FAIL', 'returnMessage' => $e->getMessage()], 200);
        }

        return response()->json(['returnCode' => 'SUCCESS', 'returnMessage' => null], 200);
    }

    public function response(Request $request)
    {
        $response = $request->all();
        dd($response);
    }

    public function fallback(Request $request)
    {
        $fallback = $request->all();
        dd($fallback);
    }
}
