@extends('email.layouts.master')
@section('title', 'Transaction Rejected')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>We regret to inform you that your purchase has been rejected for the following reason:</p>

    <p>
        <b>Reason:</b> {{ $transaction->repudiate_note }}
    </p>
    <p>
        Transaction ID: #{{ str_pad($transaction->id, 4, 0, STR_PAD_LEFT) }} <br>
        Transaction Amount: USDT {{ number_format($transaction->amount,2) }} <br>
        Transaction Date: {{ Carbon\Carbon::parse($transaction->updated_at)->format('Y-m-d H:i:s') }}
    </p>
    <p>
        If you believe this action was taken in error, or if you have any questions or concerns,
        please feel free to contact our customer support team, who will be happy to assist you.
    </p>

    <p>
        Thank you for your understanding.
    </p>

    <p>
        Best regards, <br>
        tycoon1m.com Team
    </p>
@endsection
