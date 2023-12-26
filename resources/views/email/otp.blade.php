@extends('email.layouts.master')
@section('title', 'One Time Password (OTP)')
@section('content')
    <h2 style="font-weight: 600"> Hello {{ $user->username }} </h2>
    <p>
        Your One-Time Password (OTP) for username: {{ $user->username }} is
        <br><br><br>
        <b><center><span style="font-size:60px">{{ $otp }}</span></center></b>
        <br><br>
        @if(!empty($data['amount']))
            for amount USDT {{ $data['amount'] }}
        @endif
        <br>
        {{-- Same has been sent to your registered mobile number. --}}
        {{--<br>Please note: OTP is only valid for next 5 minutes.--}}
    </p>
    <p>
        For security reasons, don't share this OTP with anyone.
        tycoon1m.com shall not be responsible for any misuse.
        In case you have not initiated this transaction be sure to get
        in touch with us immediately.
    </p>
    <p>
        Should you have any further clarifications, please contact us.
    </p>
    <p>
        Regards, <br>
        tycoon1m.com
    </p>
@endsection
