<x-frontend.layouts.app>
    @section('title', 'Packages | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')

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
                    <li><a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li>Packages</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->



        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">

                <div class="m-b100">
                    <!-- PRICING STYLE-2 COLUMNS 3 WITH GAP -->
                    <div class="section-content">
                        <div class="pricingtable-row m-b30">
                            <div class="row">
                                @foreach ($packages as $package)

                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 m-b40">
                                    <div class="pricingtable-wrapper">
                                        <div class="pricingtable-inner pricing-table-style-2">

                                            <div class="pricingtable-title">
                                                <h3>{{ $package->name }}</h3>
                                            </div>
  
                                            <div class="pricingtable-price">
                                                <span class="pricingtable-bx">{{ $package->currency }}{{ $package->amount }}</span>
                                                {{-- <span class="pricingtable-type"></span> --}}
                                            </div>

                                            <ul class="pricingtable-features">
                                                <li><i class="fa fa-check"></i>Within Investment Period</li>
                                                <li><i class="fa fa-check"></i> Gas Fee USDT {{ $package->gas_fee }} </li>
                                                <li><i class="fa fa-check"></i>{{ $package->daily_leverage }} % Daily Profit </li>
                                            </ul>

                                            <div class="pricingtable-footer">
                                                <a href="{{ route('register') }}" class="site-button  text-uppercase">Purchase</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- SECTION CONTENT END -->
        </div>
    </div>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
