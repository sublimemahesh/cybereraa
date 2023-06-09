<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>

    <!-- FAVICONS ICON -->
    <link rel="icon" href="images/favicon.html" type="image/x-icon" />
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/backend/images/favicon.png') }}">
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <!-- BOOTSTRAP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/bootstrap.min.css') }}">
    <!-- FONTAWESOME STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/fontawesome/css/font-awesome.min.css') }}" />
    <!-- FLATICON STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/flaticon.min.css') }}">
    <!-- ANIMATE STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/animate.min.css') }}">
    <!-- OWL CAROUSEL STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/owl.carousel.min.css') }}">
    <!-- BOOTSTRAP SELECT BOX STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/bootstrap-select.min.css')}}">
    <!-- MAGNIFIC POPUP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/magnific-popup.min.css')}}">
    <!-- LOADER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/loader.min.css')}}">
    <!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/style.css')}}">
    <!-- THEME COLOR CHANGE STYLE SHEET -->
    <link rel="stylesheet" class="skin" type="text/css" href="{{asset('assets/frontend/css/skin/skin-1.css')}}">
    <!-- CUSTOM  STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/custom.css')}}">
    <!-- SIDE SWITCHER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/switcher.css')}}">
    <!-- REVOLUTION SLIDER CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/plugins/revolution/revolution/css/settings.css')}}">
    <!-- REVOLUTION NAVIGATION STYLE -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/plugins/revolution/revolution/css/navigation.css')}}">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,800italic,800,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Crete+Round:400,400i&amp;subset=latin-ext" rel="stylesheet">


    @yield('styles')
</head>

<body>
    @include('frontend.layouts.header')


    {{ $slot }}

    @include('frontend.layouts.footer')
    <!-- Template JS Files -->

    <!-- JAVASCRIPT  FILES ========================================= -->
    <script src="{{ asset('assets/frontend/js/jquery-1.12.4.min.js') }}"></script><!-- JQUERY.MIN JS -->
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->

    <script src="{{ asset('assets/frontend/js/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
    <script src="{{ asset('assets/frontend/js/jquery.bootstrap-touchspin.min.js') }}"></script><!-- FORM JS -->


    <script src="{{ asset('assets/frontend/js/magnific-popup.min.js') }}"></script><!-- MAGNIFIC-POPUP JS -->

    <script src="{{ asset('assets/frontend/js/waypoints.min.js') }}"></script><!-- WAYPOINTS JS -->
    <script src="{{ asset('assets/frontend/js/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
    <script src="{{ asset('assets/frontend/jjs/waypoints-sticky.min.js') }}"></script><!-- COUNTERUP JS -->

    <script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js') }}"></script><!-- MASONRY  -->

    <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script><!-- OWL  SLIDER  -->


    <script src="{{ asset('assets/frontend/js/stellar.min.js') }}"></script><!-- PARALLAX BG IMAGE   -->
    <script src="{{ asset('assets/frontend/js/scrolla.min.js') }}"></script><!-- ON SCROLL CONTENT ANIMTE   -->

    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script><!-- CUSTOM FUCTIONS  -->
    <script src="{{ asset('assets/frontend/js/shortcode.js') }}"></script><!-- SHORTCODE FUCTIONS  -->
    <script src="js/switcher.js"></script><!-- SWITCHER FUCTIONS  -->
    <script src="{{ asset('assets/frontend/js/jquery.bgscroll.js') }}"></script><!-- BACKGROUND SCROLL -->
    <script src="{{ asset('assets/frontend/js/tickerNews.min.js') }}"></script><!-- TICKERNEWS-->

    <!-- Wrapper Ends -->

    @yield('scripts')
    @stack('scripts')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XNCT9N2XLP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-XNCT9N2XLP');

    </script>
</body>

</html>
