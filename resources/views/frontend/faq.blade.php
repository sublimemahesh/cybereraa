<x-frontend.layouts.app>
    @section('title', 'FAQ | Owara3m ')
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
                    <h1 class="text-white">Frequently Asked Questions</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>Frequently Asked Questions </li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <!-- TITLE  START -->
                        <div class="p-b30">
                            <h2 class="text-uppercase">FAQ</h2>
                            <div class="wt-separator-outer">
                                <div class="wt-separator bg-primary"></div>
                            </div>
                        </div>
                        <!-- TITLE START -->

                        <!-- ACCORDION START -->
                        <div class="wt-accordion acc-bg-gray" id="accordion5">

                            <div id="1">
                                <h3>Registration & Login</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 7)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>

                            <div id="2">
                                <h3>Security</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 8)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>

                            <div id="3">
                                <h3>How to buy Packages</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 9)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>

                            <div id="4">
                                <h3>KYC activation</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 10)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>

                            <div id="5">
                                <h3>Withdrawal</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 11)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>

                            <div id="6">
                                <h3>Coin Staking</h3>

                                @foreach ($faqs as $key=>$faq)
                                @if ($faq->parent_id == 125)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key }}" class="collapsed" data-parent="#accordion5">
                                                {{ $faq->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key }}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($faq->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endif
                                @endforeach

                            </div>


                        </div>
                        <!-- ACCORDION END -->
                    </div>
                    <div class="col-md-3 col-sm-3 p-tb15" >
                        <!-- BROCHURES -->
                        <div class="wt-box m-b30 " id="faq-cat-holder">
                            <div class="text-left m-b20">
                                <h4>FAQ Menu</h4>
                                <div class="wt-separator-outer">
                                    <div class="wt-separator bg-primary"></div>
                                </div>
                            </div>
                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#1" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">Registration & Login</strong>
                                </a>
                            </div>
                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#2" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black"> Security </strong>
                                </a>
                            </div>
                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#3" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">How to buy Packages</strong>
                                </a>
                            </div>

                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#4" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">KYC activation</strong>
                                </a>
                            </div>

                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#5" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">Withdrawal</strong>
                                </a>
                            </div>

                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#5" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">Coin Staking</strong>
                                </a>
                            </div>
                        </div>

                        <!-- CONTACT US -->
                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->
</x-frontend.layouts.app>
