@extends('auth.layouts.auth')
@section('title', 'SIGN UP YOUR ACCOUNT')
@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-10">
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
