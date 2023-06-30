<x-frontend.layouts.app>
    @section('title', 'How it work | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{ asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white">How it work</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>How it work</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB  ROW END -->

        <!-- HOW IT WORK  SECTION START -->
        <div class="section-full p-tb100 themecolor-2">
            <div class="container ">
                <div class="container ">
                    <!-- TITLE START-->
                    <div class="section-head text-center">

                        <p>Owara3m.com is a forex and cryptocurrency trading investment site that offers an opportunity
                            for investors to participate in trading activities and potentially earn a profit share.
                            Here's how it works:</p>
                        <div class="wt-separator-outer">
                            <div class="wt-separator bg-primary"></div>
                        </div>
                    </div>
                    <!-- TITLE END-->
                    <div class="section-content no-col-gap">
                        <div class="row">

                            @foreach ($how_it_work as $key => $section)
                            @if ($key%2 == 0)
                            <!-- COLUMNS 1 -->

                            <div class="col-md-12 col-sm-12 step-number-block hiw-cart-mb">
                                <div class="wt-icon-box-wraper  p-a30 center themecolor-1 m-a5">

                                    <div class="icon-content">
                                        <div class="step-number2">{{ $key+1 }}</div>
                                        <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                        <div class="hwt-content">
                                        {!! html_entity_decode($section->content) !!}
                                       </div>
                                    </div>
                                </div>
                            </div>

                            @else
                            <!-- COLUMNS 2 -->
                            <div class="col-md-12 col-sm-12 step-number-block hiw-cart-mb">
                                <div class="wt-icon-box-wraper  p-a30 center themecolor-3 m-a5 ">

                                    <div class="icon-content text-white">
                                        <div class="step-number2 active">{{ $key+1 }}</div>
                                        <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                        <div class="hwt-content">
                                        {!! html_entity_decode($section->content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach


                        </div>
                    </div>

                </div>


            </div>
        </div>

        <!-- HOW IT WORK SECTION END -->


    </div>
    <!-- CONTENT END -->




    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
