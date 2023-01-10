@extends('auth.layouts.auth')
@section('title', 'SIGN UP YOUR ACCOUNT')
@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-10">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="{{ route('/') }}">
                                    <img src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt="">
                                </a>
                            </div>
                            <h4 class="text-center mb-4">Create Your Account</h4>
                            <livewire:auth.register-steps :sponsor="$sponsor"/>
                            <div class="new-account mt-3">
                                <p>{{ __('Already registered?') }}
                                    <a class="text-primary" href="{{ route('login') }}">Sign in</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="col-xl-12 col-xxl-12 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form step</h4>
            </div>
            <div class="card-body">
                <livewire:auth.register-steps />
            </div>
        </div>
    </div> --}}

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    @endpush
@endsection
