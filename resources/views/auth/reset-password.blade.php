@extends('auth.layouts.auth')
@section('title', 'RESET PASSWORD')
@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form"> 
                            <div class="text-center mb-3">
                                <a href="{{ route('/') }}"><img src="{{ asset('assets/backend/images/logo/logo-full.png') }}"
                                        alt=""></a>
                            </div>
                            <h4 class="text-center mb-4">Reset Password</h4>

                          
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="email"><strong class="main-register-form-text">{{ __('Email') }}<sup
                                                class="main-required">*</sup></strong></label>
                                    <x-jet-input id="email" class="block mt-1 w-full form-control" type="email"
                                        name="email" :value="old('email')" required autofocus />
                                </div>
                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="Password"><strong class="main-register-form-text">{{ __('Password') }}<sup class="main-required">*</sup></strong></label>
                                    <x-jet-input  id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="new-password"  />
                                </div>
                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="Confirm Password"><strong class="main-register-form-text">{{ __('Confirm Password') }}<sup
                                                class="main-required">*</sup></strong></label>
                                    <x-jet-input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password"  />
                                </div>
                                
                                <div class="col-lg-12  mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
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
