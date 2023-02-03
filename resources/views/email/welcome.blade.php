@extends('email.layouts.master')
@section('title', 'Registration is complete')
@section('content')
    <h2 style="font-weight: 600"> Registration is complete </h2>
    <p> Thank you for creating your account.</p>
    <p><strong>Your Username : </strong> {{ $user->username }}</p>
@endsection
