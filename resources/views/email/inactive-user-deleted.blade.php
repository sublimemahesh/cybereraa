@extends('email.layouts.master')
@section('title', 'Account Suspended')
@section('content')
    <p>
        Hello {{ $user['username'] }},
    </p>

    <p>
        We regret to inform you that your account with the email ({{ $user['email'] }}) and username ({{ $user['username'] }}) created on {{ \Carbon\Carbon::parse($user['created_at'])->toFormattedDateString() }} has been removed due to inactivity.
    </p>

    <p>
        If you have any questions or concerns, please feel free to contact our support team.
    </p>

    <p>
        Thank you,<br>
        Best regards, <br>
        coin1m.com Team
    </p>

@endsection
