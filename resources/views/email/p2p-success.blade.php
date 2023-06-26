@extends('email.layouts.master')
@section('title', 'Registration is complete')
@section('content')
    <p>
        @if($isSender)
            Dear {{ $sender->username }},
        @else
            Dear {{ $receiver->username }},
        @endif
    </p>

    <p>
        We are writing to inform you that a P2P transaction has been successfully completed.
    </p>

    <p>
        Transaction details are as follows: <br><br>

        <b>Amount transferred:</b> USDT {{ $withdraw->amount }} <br>
        @if($isSender)
            <b>Transaction Fee:</b> USDT {{ $withdraw->transaction_fee }} <br>
            <b>Receiver:</b> {{ $receiver->username }}<br>
        @else
            <b>Sender:</b> {{ $sender->username }}<br>
        @endif
        <b>Date:</b> {{ $withdraw->created_at }}<br><br>

        If you have any queries or concerns, please don't hesitate to contact our customer support team.
    </p>

    <p>
        Thank you for using our service.
    </p>

    <p>
        Best regards, <br>
        owara3m.com
    </p>

@endsection
