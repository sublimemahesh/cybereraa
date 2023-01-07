<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CryptoZone : Crypto Trading Admin Bootstrap 5 Template">
    <meta property="og:title" content="CryptoZone  :Crypto Trading Admin Bootstrap 5 Template">
    <meta property="og:description" content="CryptoZone  :Crypto Trading Admin  Admin Bootstrap 5 Template">
    <meta property="og:image" content="https://cryptozone.dexignzone.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        const _TOKEN = "{!! csrf_token() !!}"
    </script>
    <!-- PAGE TITLE HERE -->
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ asset('assets/backend/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">

    @yield('plugin-styles')
    <!-- Style css -->
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        img:not(.nav-header .brand-logo, .nav-header .logo-color, .color-title, .swal2-image),
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: unset !important;
        }

        .collapse {
            visibility: unset !important;
        }
    </style>

    <!-- Styles -->
    @yield('styles')

    @livewireStyles
    @powerGridStyles
    @livewireScripts
</head>

<body class="font-sans antialiased dark" style="background: #15073a;">
    <!--******************* Preloader start ********************-->
    <div id="loader"></div>
    <!--******************* Preloader end ********************-->

    <!--**********************************  Main wrapper start ***********************************-->
    <div id="main-wrapper">

        @include('backend.layouts.header')

        @include('backend.' .Auth::user()->getRoleNames()->first() .'.sidebar')

        <!--********************************** Content body start ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">

                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('/') }}"><i class="material-icons">home</i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ !request()->is('*/dashboard') ? route(Auth::user()->getRoleNames()->first() . '.dashboard') : 'javascript:void(0)' }}">Dashboard</a>
                        </li>
                        @yield('breadcrumb-items')
                    </ol>
                </div>
                <div id="alert-container">
                    <x-jet-validation-errors class="alert alert-danger mb-4"/>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                </div>

                {{ $slot }}

            </div>


        </div>
        <!--**********************************  Footer start   ***********************************-->
        <div class="footer out-footer">
            <div class="copyright">
                <p>Copyright © Developed by
                    <a href="https://www.synotec.lk" target="_blank">Synotec</a>
                    {{ date('Y') }}
                </p>
            </div>
        </div>
        <!--********************************** Footer end  ***********************************-->
        <!--********************************** Content body end ***********************************-->
    </div>
    <!--********************************** Main wrapper end ***********************************-->


    @stack('modals')
    <!--**********************************  Scripts ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/backend/vendor/global/global.min.js') }}"></script>

    @powerGridScripts

    <script src="{{ asset('assets/backend/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/swiper/js/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard 1 -->
    <script src="{{ asset('assets/backend/js/custom.js') }}"></script>
    <script src="{{ asset('assets/backend/js/deznav-init.js') }}"></script>
    {{--    <script src="{{ asset('assets/backend/js/dashboard/tradingview-2.js') }}"></script> --}}

    @yield('scripts')
    @stack('scripts')

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                dzSettingsOptions.version = 'dark';
                new dzSettings(dzSettingsOptions);
            }, 1500)
        });
    </script>
</body>

</html>
