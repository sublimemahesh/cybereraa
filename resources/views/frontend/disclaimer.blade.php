<x-frontend.layouts.app>
    @section('title', 'Disclaimer | Owara3m | One to One Marketing Website')
    @section('header-title', 'Welcome ')

    @section('meta')
        <meta name="description"
            content="Any and all liability for risks resulting from investment transactions or other asset dispositions carried out by the customer based on information received">
        <meta name="keywords"
            content="Owara3m, Owara3m, one to one marketing, one to one marketing website, network marketing website, e money sites, money investment sites, cryptocurrency trading, trade, trade online, trades websites">
        <meta name="author" content="Owara3m">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @endsection

    @section('styles')

    <link href="{{ asset('assets/frontend/css/disclaimer.css') }}" rel="stylesheet">

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
                                            <h2 class="title-head">Dis<span>claimer</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}" id='home'> home</a></li>
                                                <li>Disclaimer</li>
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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 ">
                    @if (count($disclaimers_content) > 0)
                        @foreach ($disclaimers_content as $section)
                            <div class="col-xs-12"> {!! $section->content !!}</div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>

    <section class='disclainmer-section'>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    @if (count($disclaimers) > 0)
                        @foreach ($disclaimers as $section)
                            <h3 class="col-xs-12 title-about">{{ $section->title }}</h3>
                            <div class="col-xs-12 disclainmer-cont"> {!! $section->content !!}</div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>


    <!-- Contact Section Ends -->

    @push('scripts')
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
