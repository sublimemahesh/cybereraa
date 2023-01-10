@extends('auth.layouts.auth')
@section('title', 'Complete 2FA Challenge')
@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12" x-data="{ recovery: false }">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="{{ route('/') }}">
                                    <img src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt="">
                                </a>
                            </div>

                            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                                <p>{{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}</p>
                            </div>
                            <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                                <p>{{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}</p>
                            </div>

                            <h4 class="text-center mb-4">Two factor challenge</h4>

                            <x-jet-validation-errors class="mb-4"/> 

                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf

                                <div class="col-lg-12  mt-4" x-show="! recovery">
                                    <label class="mb-1" for="code">
                                        <strong class="main-register-form-text">{{ __('Code') }}
                                            <sup class="main-required">*</sup>
                                        </strong>
                                    </label>
                                    <x-jet-input id="code" class="block mt-1 w-full form-control" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code"/>
                                </div>

                                <div class="col-lg-12  mt-4" x-show="recovery">
                                    <label class="mb-1" for="recovery_code">
                                        <strong class="main-register-form-text">{{ __('Recovery Code') }}
                                            <sup class="main-required">*</sup>
                                        </strong>
                                    </label>
                                    <x-jet-input id="recovery_code" class="block mt-1 w-full form-control" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code"/>
                                </div>

                                <div class="col-lg-12  mt-4">
                                    <button x-show="! recovery" x-on:click="recovery = true;$nextTick(() => { $refs.recovery_code.focus() })" type="button" class="btn btn-block btn-dark cursor-pointer hover:text-gray-900 mb-2 text-gray-600 text-sm underline">
                                        {{ __('Use a recovery code') }}
                                    </button>

                                    <button x-show="recovery" x-on:click="recovery = false;$nextTick(() => { $refs.code.focus() })" type="button" class="btn btn-block btn-dark cursor-pointer hover:text-gray-900 mb-2 text-gray-600 text-sm underline">
                                        {{ __('Use an authentication code') }}
                                    </button>

                                    <button class="btn btn-outline-warning btn-block "> {{ __('Log in') }}</button>
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
