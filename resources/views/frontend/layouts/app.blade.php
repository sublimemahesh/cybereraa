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

    @include('frontend.layouts.style')
   
   
    @yield('styles')
</head>

<body>
    @include('frontend.layouts.header')


    {{ $slot }}

    @include('frontend.layouts.footer')
    
    <!-- Template JS Files -->

    @include('frontend.layouts.script')

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
