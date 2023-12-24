@extends('email.layouts.master')
@section('title', 'Your account has been reactivated')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>
        We are happy to inform you that your account has been reactivated.
    </p>

    <p>
        As a valued member of our community, we want to make sure you are able to continue enjoying our services without interruption.
        We apologize for any inconvenience caused during the suspension period.
    </p>

    <p>
        Please note that any outstanding balances or pending transactions that were affected by the suspension have been processed and resolved.
        You can now log in to your account and resume using our services.
    </p>

    <p>
        Thank you for your understanding and support. If you have any questions or concerns, please do not hesitate to reach out to our customer support team.
    </p>

    <p>
        Best regards, <br>
        tycoon1m.com
    </p>
@endsection
