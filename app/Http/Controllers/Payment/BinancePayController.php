<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use CryptoPay\Binancepay\BinancePay;

class BinancePayController extends Controller
{
    public function initiateBinancePay()
    {
        $binancePay = new BinancePay("binancepay/openapi/v2/order");
        $data['passcode_id'] = '1';
        $data['order_amount'] = '100';
        $data['package_id'] = '10';
        $data['goods_name'] = 'package 10';
        $data['goods_detail'] = 'package 10 details';
        $result = $binancePay->createOrder($data);
        dd($result);

        //Redirect user to the payment page

    }
}
