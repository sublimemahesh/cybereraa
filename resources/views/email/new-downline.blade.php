@extends('email.layouts.master')
@section('title', 'New downline placement')
@section('content')
    <p>
        Dear {{ $registeredUser->sponsor->username }},
    </p>

    <p>
        We are pleased to inform you that a new member, {{ $registeredUser->username }}, has registered under your account as your downline.
    </p>

    <div>
        <h4>New User</h4> <br>
        <strong>Name: </strong> {{ $registeredUser->name }}<br>
        <strong>Username: </strong> {{ $registeredUser->username }}<br>
        <strong>Email Address: </strong> {{ $registeredUser->email }} <br>
        <strong>Phone Number: </strong> {{ $registeredUser->phone }}
    </div>

    <p>
        Please log in to your account to view your new downline placement and to track their progress.
        You may also reach out to them and provide guidance as they start their journey with us.
    </p>

    <p>
        Thank you for your continued support, and we look forward to your success with our platform.
    </p>

    <p>
        Best regards, <br>
        cybereraa.com
    </p>
@endsection
