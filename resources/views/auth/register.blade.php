@extends('auth.layouts.auth')
@section('title', 'LOGIN')
@section('contents')

    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-10">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="index.html"><img src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt=""></a>
                            </div>
                            <h4 class="text-center mb-4">Sign up your account</h4>
                            <livewire:auth.register-steps />
                            <div class="new-account mt-3">
                                <p>Already have an account? <a class="text-primary" href="page-login.html">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
