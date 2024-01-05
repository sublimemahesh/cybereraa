<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/backend/images/favicon.png') }}">
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    @include('frontend.layouts.style')


    @yield('styles')
</head>


<body id="bg">

  <!-- Loader container -->
   <div class="loader-container" id="loaderContainer">
    <img src="{{asset('assets/frontend/images/logo.png') }}" alt="Your Logo" class="logo">
  </div>
 <!--END Loader container -->

<div class="page-wraper">

    @yield('header')

    {{ $slot }}

    @include('frontend.layouts.footer')

</div>
<!-- Template JS Files -->

@include('frontend.layouts.script')

<!-- Wrapper Ends -->

@yield('scripts')


<!-- Google tag (gtag.js) -->
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-XNCT9N2XLP"></script>
 <script>
     window.dataLayer = window.dataLayer || [];

     function gtag() {
         dataLayer.push(arguments);
     }

     gtag('js', new Date());

     gtag('config', 'G-XNCT9N2XLP');

 </script>--}}
</body>

</html>
