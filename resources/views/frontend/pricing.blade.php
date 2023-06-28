<x-frontend.layouts.app>
    @section('title', 'Packages | Owara3m')
    @section('header-title', 'Welcome ')

    @section('header')
        @include('frontend.layouts.header-other')
    @endsection

    @section('styles')
        <link href="{{ asset('assets/frontend/css/pricing.css') }}" rel="stylesheet">
        <!-- BOOTSTRAP STYLE SHEET -->
    @endsection

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/about-banner.jpg') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white">Packages</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li>
                        <a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li>Packages</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">
                <div class="row">
                    @foreach ($packages as $package)
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="title">
                                    <img src="{{asset('assets/frontend/images/tether-usdt-icon.svg') }}" class="img-pricin">
                                    <h2>{{ $package->name }}</h2>
                                </div>
                                <div class="price">
                                    <h4><sup class='price-txt'>{{ $package->currency }}</sup>{{ $package->amount }}</h4>
                                </div>
                                <div class="option">
                                    <ul>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>Within Investment Period</li>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>Gas Fee USDT {{ $package->gas_fee }}</li>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>{{ $package->daily_leverage }} % Daily Profit</li>
                                    </ul>
                                </div>
                                <a href="{{ route('user.packages.index') }}">Order Now</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- SECTION CONTENT END -->
        </div>
    </div>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
