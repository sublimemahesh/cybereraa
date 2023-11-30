<x-frontend.layouts.app>
    @section('title', 'Terms and Conditions | Coin1m ')
    @section('header-title', 'Welcome ')
    @section('header')
    @include('frontend.layouts.header-other')
    @endsection
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{ asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white  banner-txt">Terms and Conditions</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>Terms and Conditions</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB  ROW END -->

        <!-- ABOUT COMPANY SECTION START -->


        <div class="section-full p-tb100 themecolor-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="section-head text-left">
                            <span class="wt-title-subline text-gray-dark font-16 m-b15"> </span>
                            <h2 class="text-uppercase">{{ $terms_and_conditions->title }}</h2>
                            <div class="wt-separator-outer">
                                <div class="wt-separator bg-primary"></div>
                            </div>
                            {!! $terms_and_conditions->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- ABOUT COMPANY SECTION END -->

        <!-- WHY CHOOSE US SECTION START  -->
        <div class="section-full  p-t80 p-b80 themecolor-1">
            <div class="container">

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @foreach ($terms_and_conditions->children as $section)
                        <h3 class="text-uppercase">{{ $section->title }}</h3>
                        <div class="wt-separator-outer">
                            <div class="wt-separator bg-primary"></div>
                        </div>
                        {!! $section->content !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- WHY CHOOSE US SECTION END -->

    </div>
    <!-- CONTENT END -->




    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
