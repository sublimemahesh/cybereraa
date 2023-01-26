@extends('auth.layouts.auth')
@section('title', 'Verify Mobile')
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
                            <h4 class="text-center mb-4">Verify Your Phone Number</h4>

                            <div class="mb-4 text-sm text-gray-600">
                                {{ __('Before continuing, could you verify your mobile number by entering code we just send to you? If you didn\'t receive the sms, we will gladly send you another.') }}
                            </div>
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <x-jet-validation-errors class="mb-4 text-danger"/>
                            <form onSubmit="return false" id="mobile-verify-form" class="register-form outer-top-xs" role="form">
                                @csrf
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismiss">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="info-title" for="phone">Mobile Number <span>*</span></label>
                                    <input type="text" value="{{ Auth::user()->phone }}" name="phone" class="form-control unicase-form-control text-input" id="phone">
                                </div>
                                <div class="radio outer-xs mt-4">
                                    <div class="d-flex items-center justify-end mt-4">
                                        <button type="submit" id="send-verify-phone" class="btn-upper btn btn-primary checkout-page-button">{{ __('Send SMS') }}</button>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex row new-account mt-3">
                                <div class="col-lg-6  mt-4">
                                    <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                                        {{ __('Edit Profile') }}
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

@push('scripts')
    <script src="{{ asset('assets/backend/js/auth/verify-mobile-for-social-logins.js') }}" defer></script>
@endpush
