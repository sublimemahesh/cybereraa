@extends('email.layouts.master')
@section('title', 'One Time Password (OTP)')
@section('content')
    <h2 style="font-weight: 600"> Hello {{ $user->username }} </h2>
    <p>
        <b>{{ $otp }}</b> is your One-Time Password (OTP) for username: {{ $user->username }} for amount USDT {{ $data['amount'] }}.<br>
        Same has been sent to your registered mobile number.
        {{--<br>Please note: OTP is only valid for next 5 minutes.--}}
    </p>
    <p>
        For security purpose, kindly do not share this OTP with anyone. SafestTrades.com shall not be responsible for any misuse.
        In case you have not initiated this transaction please contact us immediately.
    </p>
    <p>
        Should you have any further clarifications, please contact us.
    </p>
    <p>
        Regards, <br>
        SafestTrades.com
    </p>
@endsection
