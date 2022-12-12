<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use CryptoPay\Binancepay\BinancePay;
use Illuminate\Http\Request;

class BinancePayController extends Controller
{
    public function initiateBinancePay()
    {
//        dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
        $binancePay = new BinancePay("binancepay/openapi/v2/order");
        $data['passcode_id'] = '4';
        $data['order_amount'] = '100';
        $data['package_id'] = '10';
        $data['goods_name'] = 'package 10';
        $data['goods_detail'] = 'package 10 details';
        $result = $binancePay->createOrder($data);
        dd($result);

        //Redirect user to the payment page

    }

    public function callback(Request $request)
    {
        header("Content-Type: application/json");
        //This line gets all your json response from binance when a customer makes payment
        try {
            $webhookResponse = $request->all();
            file_put_contents(base_path() . '/public/storage/binancePayWebhookCallbackFile.json', json_encode($webhookResponse, JSON_THROW_ON_ERROR), FILE_APPEND);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        //Now get success object directly from the response eg.
        //Warning: This is just example, and you should not use it for your implementation. Get the exact responses from your webhook callback file!

        $returnCode = $webhookResponse['returnCode'];
        if ($returnCode === "SUCCESS") {
            $returnMessage = $webhookResponse['returnMessage'];
        }
        return $webhookResponse;
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
