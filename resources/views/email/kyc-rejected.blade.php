@extends('email.layouts.master')
@section('title', 'KYC Verification Approved')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>
        We regret to inform you that your KYC application has been rejected. After reviewing your submission, we have found that it does not meet our KYC requirements.
    </p>

    <p>
        <b>Reason:</b> {{ $document->repudiate_note }}
    </p>

    <p>
        Please note that we take KYC compliance very seriously, and we cannot allow accounts with incomplete or inaccurate information.
        To use our services, we require that all users pass our KYC process.
    </p>

    <p>
        If you wish to reapply for KYC, please make sure to submit all the necessary documents and information according to our requirements.
        If you need any assistance or have any questions, please do not hesitate to contact our support team.
    </p>

    <p>
        Thank you for your understanding.
    </p>

    <p>
        Best regards, <br>
        coin1m.com
    </p>
@endsection
