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
                                <a href="{{ route('/') }}"><img
                                        src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt=""></a>
                            </div>
                            <h4 class="text-center mb-4">Verify email</h4>

                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </div>
                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf

                                <div class="col-lg-12  mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                                </div>

                            </form>

                            <div class="new-account mt-3">
                                <div>
                                    <a href="{{ route('profile.show') }}"
                                        class="underline text-sm text-gray-600 hover:text-gray-900">
                                        {{ __('Edit Profile') }}</a>

                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf

                                        <button type="submit"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                                            {{ __('Log Out') }}
                                        </button>
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
