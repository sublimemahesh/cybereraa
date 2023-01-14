<x-frontend.layouts.app>
    @section('title', 'Package')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="{{ asset('assets/frontend/css/pricing.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

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
                                            <h2 class="title-head">Our <span> Packages</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}" id='home'> home</a></li>
                                                <li>Packages</li>
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







    <section class="pricing-section">
        <div class="container">
            <div class="outer-box">
                <div class="row">

                    @foreach ($packages as $package)
                        <!-- Pricing Block Start -->
                        <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                            <div class="inner-box">
                                <div class="icon-box">
                                    <div class="icon-outer"><i class="fas fa-gem"></i></div>
                                </div>
                                <div class="price-box">
                                    <div class="title">{{ $package->name }}</div>
                                    <h4 class="price">{{ $package->currency }}{{ $package->amount }}</h4>
                                </div>
                                <br>
                                <br>
                                <ul class="features">
                                    <li class="true">Duration {{ $package->month_of_period }} Month</li>
                                    <li class="true">Up to {{ $package->daily_leverage }} Leverage</li>
                                    {{-- <li class="true">20 By Points</li> --}}
                                </ul>
                                <div class="btn-box">
                                    <a href="{{ route('register') }}" class="theme-btn">Buy Plan</a>
                                </div>
                            </div>
                        </div>
                        <!-- Pricing Block End -->
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
