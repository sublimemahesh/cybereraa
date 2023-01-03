<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
</head>
<body class="antialiased vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text fw-bold"> @yield('code')</h1>
                        <h4>
                            <i class="fa fa-thumbs-down text-danger"></i> {{ HttpRes::$statusTexts[$exception->getStatusCode()] ?? '' }}
                        </h4>
                        <p>@yield('message')</p>
                        <div>
                            @if(url()->previous() !== url()->full())
                                <a class="btn btn-primary" href="{{ url()->previous() }}">Go Back</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('/') }}"> Back To Home</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
