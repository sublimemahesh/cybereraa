@extends('auth.layouts.auth')
@section('title', 'Login')
@section('contents')

<div class="row justify-content-center main-register-form-style">
    <div class="col-md-6  login-bg-img-col" data-dxs="dis:none">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form login-bg-image " >
                        <div class="login-bg-txt">
                            <h2>Tycoon1m  Trading Hub <br> Secure Login</h2>
                            <p>Welcome to Tycoon1m , your premier destination for seamless and secure cryptocurrency trading. Unlock the door to a world of financial opportunities with our trusted login page. Safeguarding your assets while providing a user-friendly experience is our priority. Join us on the journey to financial success – log in with confidence at Tycoon1m  Trading Hub.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 login-bg-img-col">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form mob-vh-100-login">
                        <div class="text-center mb-3">
                            <a href="{{ route('/') }}">
                                <img class="m-auto" src="{{ asset('assets/backend/images/logo/logo-full.png') }}"
                                    alt="">
                            </a>
                        </div>
                        <h4 class="text-center mb-4">Login to Your Account</h4>

                        @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-success text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif

                        <x-jet-validation-errors class="mb-4 text-danger" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="col-lg-12  mt-4">
                                <label class="mb-1" for="email">
                                    <strong class="main-register-form-text">{{ __('Username') }}
                                        <sup class="main-required">*</sup>
                                    </strong>
                                </label>
                                <x-jet-input id="username" class="block mt-1 w-full form-control" type="text"
                                    name="username" :value="old('username')" required autofocus />
                            </div>

                            <div class="col-lg-12  mt-4">
                                <label class="mb-1" for="password">
                                    <strong class="main-register-form-text">{{ __('Password') }}
                                        <sup class="main-required">*</sup>
                                    </strong>
                                </label>
                                <x-jet-input id="password" class="block mt-1 w-full form-control" type="password"
                                    name="password" required autocomplete="current-password" />
                            </div>

                            <div class="col-lg-12  mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-jet-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="col-lg-12  mt-4">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                            </div>
                            <div class="col-lg-12  mt-4">
                                <div class="flex  mt-4">
                                    @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="col-lg-12  mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('register') }}">
                                    {{ __('Create Your Account ?') }}
                                </a>
                            </div> --}}

                            <div class="col-lg-12  mt-4">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('register') }}"> <button type="button" class="btn  btn-block"  data-devil="bgc:#19a298 c:#fff">{{ __('Create Your Account ?') }}</button></a>
                            </div>



                        </form>

                        <div class="new-account mt-3">
                            {{-- <p>Already have an account? <a class="text-primary" href="page-login.html">Sign in</a>
                            </p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
