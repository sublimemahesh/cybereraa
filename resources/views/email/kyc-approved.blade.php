@extends('email.layouts.master')
@section('title', 'KYC Verification Approved')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>
        We are writing to inform you that your KYC verification has been approved! Thank you for providing us with the necessary documents to verify your identity.
    </p>

    <p>
        If you have any questions or concerns, please do not hesitate to reach out to our customer support team.
    </p>

    <p>
        Thank you for choosing our platform.
    </p>

    <p>
        Best regards, <br>
        owara3m.com
    </p>
@endsection
