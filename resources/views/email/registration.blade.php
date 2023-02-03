@extends('email.layouts.master')
@section('title', 'Regsitration is complete')
@section('content')
   <h2 style="font-weight: 600"> Registration is complete </h2>
   <p> Thank you for creating your account.</p>
   <p><strong>Your Email : </strong> {{ $user->email }}</p>
   <p><strong>Your Username : </strong> {{ $user->username }}</p>
   <p><strong>Your Password : </strong> {{ $password }}</p>
@endsection
