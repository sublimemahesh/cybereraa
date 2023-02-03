@extends('email.layouts.master')
@section('title', $details['subject'])
@section('content')
    <h2 style="font-weight: 600">{{ $details['subject'] }}</h2>
    <p><strong>Name : </strong> {{ $details['name'] }}</p>
    <p><strong>Email : </strong> {{ $details['email'] }}</p>
    <p><strong>Phone : </strong> {{ $details['phone'] }}</p>
    <p><strong>Message : </strong> {{ $details['message'] }}</p>
@endsection
