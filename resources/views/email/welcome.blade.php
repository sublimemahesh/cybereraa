@extends('email.layouts.master')
@section('title', 'Registration is complete')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>

    <p>
        We're thrilled to welcome you to owara3m.com! Thank you for registering with us.
    </p>

    <p>
        At owara3m.com, we're committed to providing you with the best possible experience.
        Whether you're here to invest, staking, or deposit with us, we're here to help.
    </p>

    <p>
        If you have any questions or concerns, don't hesitate to reach out to our support team. We're here to help you every step of the way.
    </p>

    <p>
        Thanks again for joining us, and we look forward to seeing you around!
    </p>

    <p>
        Best regards, <br>
        owara3m.com
    </p>
@endsection
