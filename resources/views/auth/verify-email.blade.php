@extends('auth.layouts.auth')
@section('title', 'VERIFY EMAIL')
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
                            <h4 class="text-center mb-4">Verify email</h4>

                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <div class="font-medium mb-4 text-green-600 text-sm text-success">
                                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                                </div>
                            @endif
                            @if (session()->has('error') )
                                <div class="font-medium mb-4 text-danger-600 text-sm text-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <x-jet-validation-errors class="mb-4 text-danger"/>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf

                                <div class="col-lg-12  mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Resend Verification Email') }}</button>
                                </div>

                            </form>

                            <div class="d-flex row new-account mt-3">
                                <div class="col-lg-12">
                                    @auth
                                        <b>Email:</b> {{ auth()->user()->email }} <br>
                                    @endauth
                                </div>
                                <div class="col-lg-6  mt-4">
                                    <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                                        {{ __('Change the email') }}
                                    </a>
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <form method="POST" action="{{ route('logout') }}" class="float-end">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="underline text-sm text-gray-600 hover:text-gray-900">
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
