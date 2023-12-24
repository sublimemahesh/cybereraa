@extends('auth.layouts.auth')
@section('title', 'SIGN UP YOUR ACCOUNT')
@section('contents')

    <div class="row justify-content-center main-register-form-style login-bg-img-col">

        <div class="col-md-4 reg-bg-image" data-dxs="dis:none">
            <div class="reg-bg-txt">
                <h2>Create Your Account at Tycoon1m  Trading Hub</h2>
                <p> Start your cryptocurrency trading journey by registering at Tycoon1m  – your gateway to a world of financial possibilities. Sign up for a free account and gain access to a secure and user-friendly platform. Join a community of savvy investors and begin your exploration of the exciting realm of digital assets. Don't miss out on the future of finance – register now at Tycoon1m  Trading Hub.</p>
            </div>
        </div>


        <div class="col-md-8 login-bg-img-col">
            <div class="authincation-content">
                <div class="row no-gutters">

                    <livewire:auth.register-steps :sponsor="$sponsor"/>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    @endpush
@endsection
