@extends('email.layouts.master')
@section('title', 'Your purchase is complete!')
@section('content')
    <p>Hello {{ $user->username }}, </p>

    <p>
        Congratulations, your purchase of <b>{{ $transaction->create_order_request_info->goods->goodsName  }}</b> has been completed successfully!
        We're excited to have you on board as a customer, and we look forward to serving you again in the future.
    </p>
    <p>
        Transaction ID: #{{ str_pad($transaction->id, 4, 0, STR_PAD_LEFT) }} <br>
        Transaction Amount: USDT {{ number_format($transaction->amount,2) }} <br>
        Transaction Date: {{ Carbon\Carbon::parse($transaction->updated_at)->format('Y-m-d H:i:s') }}
    </p>
    <p>
        Thank you for using our service! If you have any questions or concerns, please don't hesitate to contact us.
    </p>
    <p>
        Best regards, <br>
        SafestTrades.com

    </p>

@endsection

