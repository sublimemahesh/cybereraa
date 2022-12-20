<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">

    <!-- Template CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/skins/orange.css') }}">

    <!-- Live Style Switcher - demo only -->
    <link rel="alternate stylesheet" type="text/css" title="orange" href="{{ asset('assets/frontend/css/skins/orange.css') }}" />
    <link rel="alternate stylesheet" type="text/css" title="green" href="{{ asset('assets/frontend/css/skins/green.css') }}" />
    <link rel="alternate stylesheet" type="text/css" title="blue" href="{{ asset('assets/frontend/css/skins/blue.css') }}" />
    <link rel="stylesheet" type="text/css" href="css/styleswitcher.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/main.css') }}" />

    <!-- Template JS Files -->
    <script src="js/modernizr.js"></script>
    <!-- add me CSS Files -->
    <!-- partial:index.partial.html -->
    <link href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css"
        rel="stylesheet">
    <link href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css"
        rel="stylesheet">
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script>
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
    <!-- net background link -->
    <link rel="stylesheet" href="css/net.css">
    @yield('styles')
</head>
<body>
@include('frontend.layouts.header')


{{ $slot }}






@include('frontend.layouts.footer')
 <!-- Template JS Files -->

 <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
 <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
 <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>

 <!-- Live Style Switcher JS File - only demo -->
 <script src="{{ asset('assets/frontend/js/styleswitcher.js') }}"></script>
 <script src="{{ asset('assets/frontend/js/simple.nav.js') }}"></script>
 <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
 <!-- Wrapper Ends -->
 @yield('scripts')
 @stack('scripts')

</body>
</html>
