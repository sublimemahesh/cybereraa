@extends('email.layouts.master')
@section('title', 'Account Suspended')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>
        We regret to inform you that your account on our platform has been suspended due to a violation of our terms and conditions.
        Our team has thoroughly reviewed your account and found that you have engaged in activities that are not permitted on our platform.
    </p>

    <p>
        <b>Reason:</b> {{ $user->suspend_reason }}
    </p>

    <p>
        As a result, we have temporarily suspended your account. During this suspension period,
        you will not be able to access your account, and any ongoing transactions will be paused until further notice.
    </p>

    <p>
        We take the safety and security of our community seriously, and we have strict policies in place to ensure that everyone is following our guidelines.
        We kindly request that you review our terms and conditions to understand the nature of the violation and prevent it from happening again.
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
        cybereraa.com Team
    </p>
@endsection
