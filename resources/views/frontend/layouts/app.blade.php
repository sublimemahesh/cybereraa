<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">
    <!-- Template CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/skins/orange.css') }}">
    <link href="{{ asset('assets/frontend/css/magnific-popup.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/main.css') }}" />
    <!-- partial:index.partial.html -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- net background link -->
    <link href="{{ asset('assets/frontend/css/net.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body>
    @include('frontend.layouts.header')


    {{ $slot }}






    @include('frontend.layouts.footer')
    <!-- Template JS Files -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>

    <!-- Live Style Switcher JS File - only demo -->

    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>


    <!-- Wrapper Ends -->
    @yield('scripts')
    @stack('scripts')

</body>

</html>
