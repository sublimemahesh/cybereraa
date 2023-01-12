<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="trade ,safesttrades ,crypto ,crypto wallet,crypto currency, Blockchain Crypto Exchange, Cryptocurrency Exchange, Bitcoin Trading, Ethereum price trend, BNB, CZ, BTC price, ETH wallet registration, LTC price, Binance, Poloniex, Bittrex ">
    <meta name="author" content="safesttrades">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="At SAFEST TRADING, we see the concept of “investments” in a pretty different way.">
    <meta property="og:title" content="SAFEST TRADING EVERYONE CAN MAKE INVESTMENTS!">
    <meta property="og:description" content="At SAFEST TRADING, we see the concept of “investments” in a pretty different way.">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet">
    {{-- add my css file link Lochana --}}
    <link href="{{ asset('assets/backend/css/auth/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
    @livewireStyles
    @livewireScripts
</head>

<body class="vh-100">
    <div id="loader"></div>

    <div class=" h-100">
        <div class="container h-100">
            @yield('contents')
        </div>
    </div>

    <script src="{{ asset('assets/backend//vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom.js') }}"></script>
    <script src="{{ asset('assets/backend/js/deznav-init.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}"></script>
    @stack('scripts')
</body>

</html>
