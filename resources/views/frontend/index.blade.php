<x-frontend.layouts.app>
    @section('title', 'Home Page | Cyber eraa')
    @section('header-title', 'Welcome')
    @section('header')
    @include('frontend.layouts.header')
    @endsection

    @section('styles')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style2.css') }}" type="text/css" media="all" />
    @endsection

    <!-- CONTENT START -->

    <!-- SLIDER START -->
    {{-- @include('frontend.slider') --}}
    <!-- SLIDER END -->


    <!-- ============================================================== -->
    <!-- Start -slider-area -->
    <!-- ============================================================= -->
    <div id="particles">
        <div id="webcoderskull">
            <div class="slider-area d-flex align-items-center" id="home">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6 col-md-6 slider-txt-top">
                            <div class="single-slider-box">
                                <div class="slider-content">
                                    <div class="slider-title">
                                        <h1>The Best Trading Cryptocurrency Resource</h1>
                                        <p>Cryptography, encryption process of transforming information referred to as
                                            plaintext) using done.</p>
                                    </div>
                                </div>
                                <div class="slider-button">

                                    @auth()

                                      @endauth
                                        @guest()

                                        <a href="{{ route('register')}}">Get Started Now</a>
                                        @endguest

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="single-sliders-box">
                                <div class="slider-thumb">
                                    <img src="{{asset('assets/frontend/images/crypto-2.png') }}" alt="" />
                                    <!-- <div class="shaps_img rotateme">
                                        <img src="assets/images/crypto.png" alt="">
                                    </div> -->
                                    <div class="seps_img bounce-animate">
                                        <img src="{{asset('assets/frontend/images/crypto-1.png') }}" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->
    <!-- Start brand-area -->
    <!--==================================================-->
    <div class="coin-slider brand-area">
        <div class="container">
            <div class="row top" style="background:#7c1249">
                <div class="owl-carousel brand_list">
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/bitcoin(4).png') }}" alt="" />
                                <span class="bitcoin text-white"></span> | <span class="bitcoin-change text-white break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/ethereum(3).png') }}" alt="" />
                                <span class="ethereum text-white"></span> | <span class="ethereum-change text-white break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/litecoin(7).png') }}" alt="" />
                                <span class="text-white litecoin"></span> | <span class="litecoin-change text-white break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/tron.png') }}" alt="" />
                                <span class="tron text-white"></span> | <span class="text-white tron-change break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/cardano.png') }}" alt="" />
                                <span class="cardano text-white"></span> | <span class="text-white cardano-change break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/dai.png') }}" alt="" />
                                <span class="dai text-white"></span> | <span class="text-white dai-change break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/dogecoin.png') }}" alt="" />
                                <span class="dogecoin text-white"></span> | <span class="text-white dogecoin-change break-coin"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-brand-box">
                            <div class="brand-thumb">
                                <img src="{{asset('assets/frontend/images/coin-icon/uniswap.png') }}" alt="" />
                                <span class="uniswap text-white"></span> | <span class="text-white uniswap-change break-coin"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==================================================-->
    <!-- Start about-area -->
    <!--==================================================-->
    <div class="about-area" data-dxs='mt:-50'>
        <div class="container">
            <div class="row" data-dxs='mb:-30'>
                <div class="col-lg-6 col-md-6">
                    <div class="single-about-box">
                        <div class="about-thumb bounce-animate" data-devil='pt:70' data-dxs='pt:0 mt:0'>
                            <img src="{{asset('assets/frontend/images/crypto-3.png') }}" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single-about-box">
                        <div class="section-title">
                            <div class="sub-title index-sub-title">
                                <h3>UNLOCK THE FUTURE OF WEALTH</h3>
                            </div>
                            <div class="main-title">
                                <h1>Empower Your Prosperity in the Digital Frontier</h1>
                            </div>
                            <div class="section-text">
                                <p>
                                    Welcome to Cyber eraa – Your Portal to Crypto Prosperity! Dive into the world of digital
                                    assets with confidence. Whether you're a seasoned investor or just starting, our
                                    platform offers expert insights,
                                    tools, and a community to help you navigate and thrive in the exciting realm of
                                    crypto investments. Explore the future of finance with Cyber eraa – where possibilities
                                    are limitless, and your financial
                                    success is our priority.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="about-tmb">
                                    <img src="{{asset('assets/frontend/images/about.png') }} " alt="" />
                                    <div class="about-titles">
                                        <h4>Binance Smart Chain</h4>
                                    </div>
                                </div>
                                <div class="about-tmb">
                                    <img src="{{asset('assets/frontend/images/about.png') }}" alt="" />
                                    <div class="about-titles">
                                        <h4>Coin Entherium</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="about-tmb">
                                    <img src="{{asset('assets/frontend/images/about.png') }}" alt="" />
                                    <div class="about-titles">
                                        <h4>Exchange Money</h4>
                                    </div>
                                </div>
                                <div class="about-tmb">
                                    <img src="{{asset('assets/frontend/images/about.png') }} " alt="" />
                                    <div class="about-titles">
                                        <h4>OKEX Block Chain</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-button">
                            <a href="{{ route('about') }}">learn more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->
    <!-- Start feature-area -->
    <!--==================================================-->
    <section class='sftDetails-sec stf-bc'>
        <div class="feature-area stf-bc-net">
            <div>
                <div class="container" data-devil='mb:200' data-dxs="mb:0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sections-title">
                                <div class="sub-title">
                                    <h3>features</h3>
                                </div>
                                <div class="main-title">
                                    <h1>We Take Care Quality</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- start Investments Profit -->
                    <section id="invest_profit">
                        <div class="containerSt">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="rightitem counter-number marg-auto" data-dxs="p:unset w:300 mb:10" >
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/members.png') }}'></div>
                                        <div>
                                            <div class="text counter">35,000</div>
                                            <span class="counter-txt">OUR FAMILY MEMBERS</span>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-4">

                                    <div class="rightitem counter-number marg-auto" data-dxs="p:unset w:300 mb:10">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/join-members.png') }}'></div>
                                        <div>
                                            <div class="text counter">750</div>
                                            <span class="counter-txt">TODAY JOIN FAMILY</span>
                                        </div>

                                    </div>


                                </div>
                                <div class="col-sm-12 col-md-4">

                                    <div class="rightitem counter-number marg-auto" data-dxs="p:unset w:300">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/income-members.png') }}'></div>
                                        <div>
                                            <div class="text counter">1,935,000</div>
                                            <span class="counter-txt">MEMBERS INCOME</span>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div>
                    <div class="container">
                        <!-- start Profit chart-->
                        <section id="sftDetails" class="animations">
                            <div class="fintecContainer">
                                <div class="wrapperDetailsinside">
                                    <div class="middleSec">
                                        <img src="{{asset('assets/frontend/images/sf/NewToken.png') }}" alt="NewToken" class="coinmidle" />
                                        <img src="{{asset('assets/frontend/images/sf/Ellipse36.png') }}" alt="Ellipse36" class="roundIns change-width" />
                                        <img src="{{asset('assets/frontend/images/sf/Ellipse35.png') }}" alt="Ellipse35" class="roundgradiant" />
                                        <span class="dt i1 dt-round1"><span>15%</span></span>
                                        <span class="dt i2 dt-round1"><span>10%</span></span>
                                        <span class="dt i3  dt-round1"><span class="">05%</span></span>
                                        <!-- <span class="dt i4  dt-round1"><span class="">1%</span></span> -->
                                        <span class="dt i5 dt-round1"><span>05%</span></span>
                                        <span class="dt i6 dt-round1"><span>35%</span></span>
                                        <span class="dt i7 dt-round1"><span>20%</span></span>
                                        <span class="dt i8 dt-round1"><span>05%</span></span>
                                        <span class="dt i9 dt-round1"><span>05%</span></span>
                                    </div>
                                    <div class="leftitem RealEstate">
                                        <div class="text">REAL ESTATE</div>
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/house.png')}}'></div>
                                    </div>
                                    <div class="leftitem Plantations">
                                        <div class="text">SPOT TRADING</div>
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/trophy.png')}}'></div>
                                    </div>
                                    <div class="leftitem DiamondMining">
                                        <div class="text">NFT HOLD</div>
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/nft.png')}}'></div>
                                    </div>
                                    <!-- <div class="leftitem WebProjects">
                                        <div class="text">Web 3.0 Projects</div>
                                        <div class="imageIn"><img src='./assets/images/sf/web.png'></div>
                                    </div> -->
                                    <div class="rightitem ForexTrading">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/crypto-trading.png')}}'></div>
                                        <div class="text"> CRYPTO TRADING </div>
                                    </div>
                                    <div class="rightitem CommodityTrading">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/candlestick.png')}}'></div>
                                        <div class="text">FOREX TRADING</div>
                                    </div>
                                    <div class="rightitem EquityTrading">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/commodity.png')}}'></div>
                                        <div class="text">COMMODITY TRADING</div>
                                    </div>
                                    <div class="rightitem CryptoSpot">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/plantation.png')}}'></div>
                                        <div class="text">PLANTATION</div>
                                    </div>
                                    <div class="rightitem CryptoDerivatives">
                                        <div class="imageIn"><img src='{{asset('assets/frontend/images/sf/liquidity.png')}}'></div>
                                        <div class="text">DIGITAL MARKETING</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bcGradiant"></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--==================================================-->
    <!--How it work -->
    <!--==================================================-->

    <div class="feature-area style-one upper" data-dxs="pt:60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sections-title">
                        <div class="sub-title">
                            <h3>Steps</h3>
                        </div>
                        <div class="main-title">
                            <h1>How It Work</h1>
                        </div>
                        <div class="section-text">
                            <p>Cryptocurrencies are used primarily outside existing banking and coin governmental
                                institutions and are exchanged</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/lock.png') }}" alt />
                        </div>
                        <div class="feature-title">
                            <h3>SING UP AND SIGN IN</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces. Synergisticall
                                sustainable infomediaries via</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/tags.png') }}" alt />
                        </div>
                        <div class="feature-title">
                            <h3>BUY INVESTMENT PACKAGES</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces. Synergisticall
                                sustainable infomediaries via</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/money.png') }}" alt />
                        </div>
                        <div class="feature-title">
                            <h3>WITHDRAW MONEY</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces. Synergisticall
                                sustainable infomediaries via</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==================================================-->
    <!-- Start testimonial-area -->
    <!--==================================================-->
    <div class="testimonial-area" style="background:#52001e ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sections-title">
                        <div class="sub-title">
                            <h3>testimonial</h3>
                        </div>
                        <div class="main-title">
                            <h1>From Our Clients</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel testi_list">

                    @foreach ($testimonials as $key => $testimonial)
                    <div class="col-lg-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-thumb">
                                <img class="testimonia-img" src="{{ storage('testimonials/' . $testimonial->image) }}" alt="author"/>
                                <div class="testi-title">
                                    <h2>{{ $testimonial->name }}</h2>
                                    <h4>{{ $testimonial->title }}</h4>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                {!! html_entity_decode($testimonial->comment) !!}
                            </div>
                            {{-- <div class="testimonial-icon">
                                <ul>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i> <span>(4.5)</span></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    @endforeach

                    {{-- <div class="col-lg-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-thumb">
                                <img src="{{asset('assets/frontend/images/crypto-9.png') }}" alt="" />
                                <div class="testi-title">
                                    <h2>Anna Asler</h2>
                                    <h4>Investor</h4>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                <p>Holisticly recaptiualiz collaborative deliverables rather than interactive
                                    opportunities. Continually myoca web-enabled done.</p>
                            </div>
                            <div class="testimonial-icon">
                                <ul>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i> <span>(5)</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-thumb">
                                <img src="{{asset('assets/frontend/images/crypto-7.png') }}" alt="" />
                                <div class="testi-title">
                                    <h2>Debra Hiles</h2>
                                    <h4>Students</h4>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                <p>Holisticly recaptiualiz collaborative deliverables rather than interactive
                                    opportunities. Continually myoca web-enabled done.</p>
                            </div>
                            <div class="testimonial-icon">
                                <ul>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i> <span>(4.5)</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-thumb">
                                <img src="{{asset('assets/frontend/images/crypto-8.png') }}" alt="" />
                                <div class="testi-title">
                                    <h2>alex john</h2>
                                    <h4>founder</h4>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                <p>Holisticly recaptiualiz collaborative deliverables rather than interactive
                                    opportunities. Continually myoca web-enabled done.</p>
                            </div>
                            <div class="testimonial-icon">
                                <ul>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i> <span>(4.5)</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="single-testimonial-box">
                            <div class="testimonial-thumb">
                                <img src="{{asset('assets/frontend/images/crypto-9.png')}}" alt="" />
                                <div class="testi-title">
                                    <h2>Anna Asler</h2>
                                    <h4>Investor</h4>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                <p>Holisticly recaptiualiz collaborative deliverables rather than interactive
                                    opportunities. Continually myoca web-enabled done.</p>
                            </div>
                            <div class="testimonial-icon">
                                <ul>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i> <span>(5)</span></li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
    <!--==================================================-->
    <!-- Start call-do-action-area -->
    <!--==================================================-->
    <div class="call-do-action-area" style="background:#360011;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-call-do-action-box">
                        <div class="call-do-action-title">
                            <h1>Explore the Next Crypto Ready to Selling</h1>
                            <p>Credibly streamline premium innovation and client-focused the. Intrinsicly integrate
                                end-to-end synergy whereas.</p>
                        </div>
                        <div class="call-do-button">
                            <a href="{{ route('register')}}">Get Started Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single-call-do-box">
                        <div class="call-do-action-thumb">
                            <img src="{{asset('assets/frontend/images/crypto-6.png') }}" alt="" />
                            <div class="call-shap rotateme">
                                <img src="{{asset('assets/frontend/images/crypto-4.png') }}" alt="" />
                            </div>
                            <div class="call-do-shap bounce-animate">
                                <img src="{{asset('assets/frontend/images/crypto-5.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- CONTENT END -->


    @section('scripts')

    <!-- particls js -->
    <script src="{{ asset('assets/frontend/js/particls.chart1.js') }}"></script>
    <!-- Coin prices API js -->
    <script src="{{ asset('assets/frontend/js/coin_prices.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/sf.js') }}"></script>




    <script>
        inViewport("animations");

    </script>
    @endsection

</x-frontend.layouts.app>
