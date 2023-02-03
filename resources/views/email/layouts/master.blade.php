<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <title>@yield('title') | {{ config('app.name','SafestTrade') }}</title>
    <style type="text/css">
        body {
            width: 650px;
            font-family: work-Sans, sans-serif;
            background-color: #f6f7fb;
            display: block;
        }

        a {
            text-decoration: none;
        }

        span {
            font-size: 14px;
        }

        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }

        .text-center {
            text-align: center
        }

    </style>
    @yield('styles')
</head>

<body style="margin: 30px auto;">
    <table style="width: 100%">
        <tbody>
        <tr>
            <td>
                <table style="background-color: #f6f7fb; width: 100%">
                    <tbody>
                    <tr>
                        <td>
                            <table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="https://www.safesttrades.com/assets/backend/images/logo/logo-black-transparent.png" alt="{{ config('app.name','SafestTrade') }}" style="height: 50px;">
                                    </td>
                                    <td style="text-align: right; color:#999">
                                        <span>{{ config('app.name','SafestTrade') }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table
                                    style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                                <tbody>
                                <tr>
                                    <td style="padding: 30px">
                                        @yield('content')
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table style="width: 650px; margin: 0 auto; margin-top: 30px;text-align: center">
                                <tbody>
                                <tr>
                                    <td>
                                        <p style="font-size:13px; margin:0;">
                                            ©Copyright {{ date('Y') }} {{ config('app.name','SafestTrade') }} All Rights Reserved
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</body>

</html>
