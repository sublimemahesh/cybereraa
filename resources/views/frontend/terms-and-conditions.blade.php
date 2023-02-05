<x-frontend.layouts.app>
    @section('title', 'Terms and Conditions | Safest Trades | One to One Marketing Website')
    @section('header-title', 'Welcome ')

    @section('meta')
        <meta name="description"
            content="All the information made available here is generally provided to serve as an example only, without obligation and without specific recommendations for action.">
        <meta name="keywords"
            content="safesttrades, safest trades, one to one marketing, one to one marketing website, network marketing website, e money sites, money investment sites, cryptocurrency trading, trade, trade online, trades websites">
        <meta name="author" content="SAFEST TRADES">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @endsection

    @section('styles')
    <link href="{{ asset('assets/frontend/css/terms-and-conditions.css') }}" rel="stylesheet">

    @endsection



    <div id="page">
        <section id="hero" class='net-hero'>
            <div class="background">
                <canvas id="hero-background"></canvas>
            </div>
            <div class="foreground">
                <div class="main">
                    <section class="banner-area">
                        <div class="banner-overlay">
                            <div class="banner-text text-center">
                                <div class="container">
                                    <!-- Section Title Starts -->
                                    <div class="row text-center">
                                        <div class="col-xs-12">
                                            <!-- Title Starts -->
                                            <h2 class="title-head">TERMS & <span>CONDITIONS</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}" id='home'> home</a></li>
                                                <li>TERMS & CONDITIONS</li>
                                            </ul>
                                            <!-- Breadcrumb Ends -->
                                        </div>
                                    </div>
                                    <!-- Section Title Ends -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
        </section>
    </div>

    {{--<section>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 ">
                    @if (count($terms_and_conditions_content) > 0)
                        @foreach ($terms_and_conditions_content as $section)
                            <div class="col-xs-12"> {!! $section->content !!}</div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>

    <section class='terms-and-conditions-section'>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    @if (count($terms_and_conditions) > 0)
                        @foreach ($terms_and_conditions as $section)
                            <h3 class="col-xs-12 title-about">{{ $section->title }}</h3>
                            <div class="col-xs-12 terms-and-conditions-cont"> {!! $section->content !!}</div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>--}}


    <!-- Contact Section Ends -->

    @push('scripts')
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
