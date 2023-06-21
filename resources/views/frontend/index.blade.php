<x-frontend.layouts.app>
    @section('title', 'Home Page | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header')
    @endsection


    <!-- CONTENT START -->
    <div class="page-content">
        <!-- SLIDER START -->
        @include('frontend.slider')
        <!-- SLIDER END -->

        <!-- MARQUEE SCROLL -->
        <div class="themecolor-1 marquee">
            <div class="TickerNews" id="T1">
                <div class="ti_wrapper">
                    <div class="ti_slide">
                        <div class="ti_content">
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/bitcoin.png') }}" alt=""><span>BTC: </span><span>$ 10,633.1</span><span class="text-yellow p-lr5">0.97 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/bitcoin.png') }}" alt=""><span>BTC: </span><span>¥ 68,008.1</span><span class="text-danger p-lr5">0.00 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/bitcoin.png') }}" alt=""><span>BTC: </span><span>€ 8,699.23</span><span class="text-white p-lr5">1.08 %</span></a></div>

                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/Ethereum.png') }}" alt=""><span>ETH: </span><span>Ƀ 0.08160</span><span class="text-green p-lr5">-0.28 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/Ethereum.png') }}" alt=""><span>ETH: </span><span>$ 867.93</span><span class="text-danger p-lr5">-0.60 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/Ethereum.png') }}" alt=""><span>ETH: </span><span>¥ 5,549.46</span><span class="text-white p-lr5">-0.28 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/Ethereum.png') }}" alt=""><span>ETH: </span><span>€ 709.94</span><span class="text-gray p-lr5">0.26 %</span></a></div>

                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/monero.png') }}" alt=""><span>XMR: </span><span>Ƀ 0.0276</span><span class="text-green p-lr5">1.25 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/monero.png') }}" alt=""><span>XMR: </span><span>$ 295.33</span><span class="text-light-blue p-lr5">0.89 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/monero.png') }}" alt=""><span>XMR: </span><span>¥ 1,883.14</span><span class="text-green p-lr5">0.25 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/monero.png') }}" alt=""><span>XMR: </span><span>€ 240.56</span><span class="text-red p-lr5">-0.40 %</span></a></div>

                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/litecoin.png') }}" alt=""><span>LTC: </span><span>Ƀ 0.01956</span><span class="text-danger p-lr5">-0.20 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/litecoin.png') }}" alt=""><span>LTC: </span><span>$ 208.06</span><span class="text-green p-lr5">-1.97 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/litecoin.png') }}" alt=""><span>LTC: </span><span>¥ 1,330.24</span><span class="text-white p-lr5">-0.20 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/litecoin.png') }}" alt=""><span>LTC: </span><span>€ 169.91</span><span class="text-yellow p-lr5">-1.29 %</span></a></div>

                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/DigitalCash.png') }}" alt=""><span>DASH: </span><span>Ƀ 0.05590</span><span class="text-white p-lr5">0.26 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/DigitalCash.png') }}" alt=""><span>DASH: </span><span>$ 594.64</span><span class="text-green p-lr5">0.37 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/DigitalCash.png') }}" alt=""><span>DASH: </span><span>¥ 3,801.65</span><span class="text-red p-lr5">0.99 %</span></a></div>
                            <div class="ti_news"><a href="#"><img src="{{asset('assets/frontend/images/coin-icon/DigitalCash.png') }}" alt=""><span>DASH: </span><span>€ 486.29</span><span class="text-yellow p-lr5">-10.18 %</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MARQUEE SCROLL SECTION  END -->

        <!-- OUR VALUE SECTION START -->

        <div class="section-full themecolor-1">
            <div class="container">
                <div class="section-content ">
                    <!-- COLL-TO ACTION START -->
                    <div class="wt-subscribe-box">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <div class="call-to-action-left p-tb20 ">
                                        <h4 class="text-uppercase m-b10 font-weight-600">Invest in Cryptocurrency Bitcoin Mining & Easy Way to Trade Bitcoin.</h4>
                                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore edolore magna aliquyam erat.</p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="call-to-action-right p-tb30">
                                        <a href="contact-1.html" class="site-button-secondry text-uppercase font-weight-600">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OUR VALUE SECTION  END -->

        <!-- WELCOME SECTION START -->

       

        <div class="section-full home-about-section p-t80 bg-no-repeat bg-bottom-right themecolor-2" style="background-image:url(images/background/bg-coin.png)">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="wt-box text-right">
                            <img src="{{ storage('pages/' . $welcome->image) }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="wt-right-part p-b80">
                            <!-- TITLE START -->
                            <div class="section-head text-left">
                                <span class="wt-title-subline font-16 text-gray-dark m-b15">What is Owara3m</span>
                                <h2 class="text-uppercase">{{ $welcome->title }}</h2>
                                <div class="wt-separator-outer">
                                    <div class="wt-separator bg-primary"></div>
                                </div>
                            </div>
                            <!-- TITLE END -->
                            <div class="section-content">
                                <div class="wt-box">
                                    <p>
                                        <strong>
                                            {!! $welcome->content !!}
                                        </strong>
                                    </p>

                                    <a href="#" class="site-button text-uppercase m-r15 site-button2">Read More</a>
                                    <a href="#" class="site-button-secondry text-uppercase">Contact us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
        <!-- WELCOME SECTION  END -->

        <!-- WHY CHOOSE US SECTION START  -->

        <div class="section-full themecolor-1 p-t90 p-b30  ">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head text-center">
                    <span class="wt-title-subline font-16 text-gray-dark m-b15">Our Benefit</span>
                    <h2 class="text-uppercase">Why Choose Owara3m</h2>
                    <div class="wt-separator-outer">
                        <div class="wt-separator bg-primary"></div>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                </div>
                <!-- TITLE END-->
                <div class="section-content hover-block-outer" data-toggle="tab-hover">
                    <div class="row">

                        <div class="col-md-4 col-sm-12 m-b30  p-t30">

                            @if (count($benefits) > 0)
                            @foreach ($benefits as $key => $section)
                            @if ($key % 2 == 0)

                            <div class="wt-icon-box-wraper  right p-a20" data-target="#tab1" data-toggle="tab">
                                <div class="icon-md text-primary">
                                    <span class="icon-cell  text-primary"><img src="{{ storage('pages/' . $section->image) }}" alt=""></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase">{{ $section->title }}</h4>
                                    <p> {!! $section->content !!}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif

                        </div>

                        <div class="col-md-4 col-sm-12 m-b30 circle-content-pic ">

                            <div class="tab-content ">
                                <div id="tab1" class="tab-pane active">
                                    <div class="wt-box">
                                        <div class="wt-media text-primary m-t60 text-center">
                                            <img class="up-down-animation" src="{{asset('assets/frontend/images/ipad/banner.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 m-b30  p-t30 mob-m">
                            @if (count($benefits) > 0)
                            @foreach ($benefits as $key => $section)
                            @if ($key % 2 != 0)


                            <div class="wt-icon-box-wraper left p-a20 ">
                                <div class="icon-md text-primary">
                                    <span class="icon-cell  text-primary"><img src="{{ storage('pages/' . $section->image) }}" alt=""></span>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase">{{ $section->title }}</h4>
                                    <p> {!! $section->content !!}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- WHY CHOOSE US SECTION END -->

        <!-- COMPANY DETAIL SECTION START -->

      

        <div class="section-full p-t50 p-b50 overlay-wraper bg-parallax clouds1 bg-repeat" data-stellar-background-ratio="0.5" style="background-image:url({{ asset('assets/frontend/images/background/bg-1.jpg') }});">
            <div class="overlay-main themecolor-3 opacity-05"></div>
            <div class="container ">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="rocket-pic">
                            <div class="rocket-animation ">
                                <img src="{{asset('assets/frontend/images/rocket.png')}}" alt="" class="floating" />
                                <div class="rocket-fire"> <img src="{{asset('assets/frontend/images/fire.gif')}}" alt="" class="floating" /></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <div class="awesome-counter text-right text-white">
                            <h3 class="font-24">The Cryptocurrency</h3>
                            <h2 class="font-60 font-weight-600"><span class="text-primary">{{ $awesome_facts->title }}</span></h2>
                            <p> {!! $awesome_facts->content !!}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="status-marks  text-white m-tb10">
                                    <div class="status-value text-right">
                                        <span class="counter">1150</span>
                                        <i class="fa fa-building font-26 m-l15"></i>
                                    </div>
                                    <h6 class="text-uppercase text-right">PROJECT COMPLETED</h6>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="status-marks  text-white m-tb10">
                                    <div class="status-value text-right">
                                        <span class="counter">5223</span>
                                        <i class="fa fa-users font-26 m-l15"></i>
                                    </div>
                                    <h6 class="text-uppercase text-white text-right">HAPPY CLIENTS</h6>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="status-marks  text-white m-tb10">
                                    <div class="status-value text-right">
                                        <span class="counter">4522</span>
                                        <i class="fa fa-user-plus font-26 m-l15"></i>
                                    </div>
                                    <h6 class="text-uppercase text-white text-right">WORKERS EMPLOYED</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- COMPANY DETAIL SECTION End -->

        <!-- HOW IT WORK SECTION START  -->
        <div class="section-full  p-t80 p-b80 themecolor-1">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head text-center">
                    <span class="wt-title-subline font-16 text-gray-dark m-b15">Three steps bticoin</span>
                    <h2 class="text-uppercase">How It Work</h2>
                    <div class="wt-separator-outer">
                        <div class="wt-separator bg-primary"></div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga eos optio ducimus odit, labore hic fugiat iusto veniam necessitatibus quas doloremque sapiente maiores.</p>
                </div>
                <!-- TITLE END-->
                <div class="section-content no-col-gap">
                    <div class="row">

                        @foreach ($how_it_work as $key => $section)
                        @if ($key%2 == 0)
                        <!-- COLUMNS 1 -->

                        <div class="col-md-4 col-sm-4 step-number-block">
                            <div class="wt-icon-box-wraper  p-a30 center themecolor-2 m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ storage('pages/' . $section->image) }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <div class="step-number">{{ $key+1 }}</div>
                                    <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                    {!! html_entity_decode($section->content) !!}
                                </div>
                            </div>
                        </div>

                        @else
                        <!-- COLUMNS 2 -->
                        <div class="col-md-4 col-sm-4 step-number-block">
                            <div class="wt-icon-box-wraper  p-a30 center themecolor-3 m-a5 ">
                                <div class="icon-lg m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ storage('pages/' . $section->image) }}" alt=""></a>
                                </div>
                                <div class="icon-content text-white">
                                    <div class="step-number active">{{ $key+1 }}</div>
                                    <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                    {!! html_entity_decode($section->content) !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
        <!-- HOW IT WORK  SECTION END -->

        <!-- SECTION CONTENT START -->
        <div class="section-full no-col-gap bg-repeat">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-6 col-sm-6 themecolor-3">
                        <div class="section-content p-tb60 p-r30 clearfix">
                            <div class="wt-left-part any-query">
                                <img src="{{asset('assets/frontend/images/any-query.png')}}" alt="">
                                <div class="text-center p-t60">
                                    <h3 class="text-uppercase font-weight-500 text-white">Any Query?</h3>
                                    <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the.</p>
                                    <h4 class="text-primary">0 321 576 444</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 bg-primary">
                        <div class="section-content p-tb60 p-l30 clearfix">
                            <div class="wt-right-part any-query-contact">
                                <img src="{{asset('assets/frontend/images/any-query-contact.png')}}" alt="">
                                <div class="text-center p-t60">
                                    <h3 class="text-uppercase font-weight-500 text-white">Contact Us</h3>
                                    <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the.</p>
                                    <h4 class="text-secondry">support@bitinvest.com</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- SECTION CONTENT  END -->
    </div>
    <!-- CONTENT END -->


    @section('scripts')


    <script type="text/javascript">
        jQuery(function() {
            var timer = !1;
            _Ticker = jQuery("#T1").newsTicker();
            _Ticker.on("mouseenter", function() {
                var __self = this;
                timer = setTimeout(function() {
                    __self.pauseTicker();
                }, 200);
            });
            _Ticker.on("mouseleave", function() {
                clearTimeout(timer);
                if (!timer) return !1;
                this.startTicker();
            });
        });

    </script>

    <script src="{{asset('assets/frontend/plugins/revolution/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{asset('assets/frontend/plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script src="{{asset('assets/frontend/plugins/revolution/revolution/js/extensions/revolution-plugin.js') }}"></script>
    <!-- REVOLUTION SLIDER FUNCTION  ===== -->
    <script src="{{ asset('assets/frontend/js/rev-script-1.js') }}"></script>



    @endsection

</x-frontend.layouts.app>
