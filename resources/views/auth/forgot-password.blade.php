@extends('auth.layouts.auth')
@section('title', 'FORGOT YOUR PASSWORD')
@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="{{ route('/') }}">
                                    <img class="m-auto" src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt="">
                                </a>
                            </div>
                            <h4 class="text-center mb-4">Forgot Your Password</h4>

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="col-lg-12  mt-4">
                                    <p> {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                                </div>

                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="email"><strong class="main-register-form-text">{{ __('Email') }}
                                            <sup
                                                    class="main-required">*</sup></strong></label>
                                    <x-jet-input id="email" class="block mt-1 w-full form-control" type="email"
                                            name="email" :value="old('email')" required autofocus/>
                                </div>


                                <div class="col-lg-12  mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Email Password Reset Link') }}</button>
                                </div>

                            </form>

                            <div class="new-account mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
