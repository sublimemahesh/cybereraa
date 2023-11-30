<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | {{ config('app.name', 'coin1m') }}</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">
    <!-- Favicon -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/skins/orange.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    @yield('styles')
</head>
<body>

{{--@include('frontend.layouts.header')--}}

<section style="height: 90vh;display: flex;align-items: center;">
    <div class="container" style="justify-content: center;display: flex;">
        <div class="row">
            <div class="col-md-12 col-xs-12 text-center">
                {{--<h1 class="error-text fw-bold"> @yield('code')</h1>--}}
                <h4>
                    {{--<i class="fa fa-thumbs-down text-danger"></i> {{ HttpRes::$statusTexts[$exception->getStatusCode()] ?? '' }}--}}
                </h4>
                <p style="font-size: 23px;">@yield('message')</p>
                <div>
                    @if($exception->getStatusCode() !== 403 && url()->previous() !== route('/') && url()->previous() !== url()->full())
                        <a class="btn btn-primary" href="{{ url()->previous() }}">Go Back</a>
                    @elseif($exception->getStatusCode() === 401)
                        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('/') }}"> Back To Home</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer Starts -->
<footer class="footer">
    <!-- Footer Bottom Area Starts -->
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center" style="padding: 5px;font-size: 10px;">
                    <!-- Copyright Text Starts -->
                    <p style="font-size: 10px;">
                        @yield('code')
                        | {{ HttpRes::$statusTexts[$exception->getStatusCode()] ?? '' }}
                        | {{ $exception->getMessage() }}
                    </p>
                    <!-- Copyright Text Ends -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom Area Ends -->
</footer>
<!-- Footer Ends -->

<!-- Wrapper Ends -->
@yield('scripts')
@stack('scripts')

</body>
</html>

