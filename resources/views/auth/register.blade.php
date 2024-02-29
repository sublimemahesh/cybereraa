@extends('auth.layouts.auth')
@section('title', 'SIGN UP YOUR ACCOUNT')
@section('styles')
    <style>
        .loader {
            transform: rotateZ(45deg);
            perspective: 1000px;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            color: #fff;
        }

        .loader:before,
        .loader:after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: inherit;
            height: inherit;
            border-radius: 50%;
            transform: rotateX(70deg);
            animation: 1s spin linear infinite;
        }

        .loader:after {
            color: #FF3D00;
            transform: rotateY(70deg);
            animation-delay: .4s;
        }

        @keyframes rotate {
            0% {
                transform: translate(-50%, -50%) rotateZ(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotateZ(360deg);
            }
        }

        @keyframes rotateccw {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }

        @keyframes spin {
            0%,
            100% {
                box-shadow: .2em 0 0 0 currentcolor;
            }
            12% {
                box-shadow: .2em .2em 0 0 currentcolor;
            }
            25% {
                box-shadow: 0 .2em 0 0 currentcolor;
            }
            37% {
                box-shadow: -.2em .2em 0 0 currentcolor;
            }
            50% {
                box-shadow: -.2em 0 0 0 currentcolor;
            }
            62% {
                box-shadow: -.2em -.2em 0 0 currentcolor;
            }
            75% {
                box-shadow: 0 -.2em 0 0 currentcolor;
            }
            87% {
                box-shadow: .2em -.2em 0 0 currentcolor;
            }
        }

    </style>
@endsection
@section('contents')

    <div class="row justify-content-center main-register-form-style login-bg-img-col">

        <div class="col-md-4 reg-bg-image" data-dxs="dis:none">
            <div class="reg-bg-txt">
                <h2>Create Your Account at Cyber Eraa Trading Hub</h2>
                <p> At Cyber Eraa, we believe in empowering your financial journey through strategic investments and cutting-edge trading solutions. Join our community of savvy investors and unlock the potential for higher returns.</p>
            </div>
        </div>


        <div class="col-md-8 ">
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
