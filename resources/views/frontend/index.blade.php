<x-frontend.layouts.app>
    @section('title', 'Home')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="{{ asset('assets/frontend/css/testimonials.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/frontend/css/hiw2.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/frontend/css/net.css') }}" rel="stylesheet">


    @endsection


    <div id="page">
        <section id="hero" class='net-hero'>
            <div class="background">
                <canvas id="hero-background"></canvas>
            </div>
            <div class="foreground">
                <div class="main">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-5 col-lg-6 loging-area">
                                <img class="w-100 shadow vert-move image222"
                                    src="{{ asset('assets/frontend/images/project/banner-img.png') }}" id='hero-img' />
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-6">
                                <div id='hero-text'>
                                    <h1 class="title-head">INVEST & <span> EARN IN THE SAFEST SPOT ON THE EARTH.</span></h1>
                                    <p class="about-text">
                                        What if your dream investment can be made in the safest spot on 
                                        the earth? just invest and wait and enjoy up to a guaranteed return of 400% in 15 months. Daily withdrawals, No claim Bonuses, and many more massive benefits.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <!-- About Section Starts -->
    <section class="about-us about-css" id='iny'>
        <div class="container">
            <!-- Section Title Starts -->
            <div class="row text-center">
                <h2 class="title-head">Invest now, you’ll <span>never regret it.</span></h2>
                <div class="title-head-subtitle">
                    <p>Explain our Mission Values vision</p>
                </div>
            </div>
            <!-- Section Title Ends -->

            <!-- Section Content Starts -->
            <div class="row about-content">
                <!-- Image Starts -->
                <div class="col-sm-12 col-md-5 col-lg-6 text-center">

                    {{-- {!!$homes->children[4]->content !!} --}}

                    @foreach ($homes_video as $key => $hv)
                        {!! $hv->content !!}
                    @endforeach

                </div>
                <!-- Image Ends -->
                <!-- Content Starts -->
                <div class="col-sm-12 col-md-7 col-lg-6">

                    @foreach ($homes_contents as $key => $hc)
                        <h3 class="title-about">{{ $hc->title }}</h3>
                        <p class="about-text">{!! $hc->content !!}</p>
                    @endforeach

                    <a class="btn btn-primary" href="{{ route('about') }}">Read More</a>
                </div>
                <!-- Content Ends -->
            </div>
            <!-- Section Content Ends -->
        </div>
    </section>
    <!-- About Section Ends -->
    <!-- hiw Section Starts -->
    <section id='hiw'>
        <h2 class="title-head text-center">How<span> it works.</span></h2>
        <div class="title-head-subtitle text-center">
            <p>Explain How it works with us</p>

        </div>
        <ul class="infoGraphic">
            <li>
                <div class="numberWrap">
                    <div class="number fontColor1">1</div>
                    <div class="coverWrap">
                        <div class="numberCover"></div>
                    </div>
                </div>
                <div class="content">
                    {{-- <div class="icon iconCodepen"></div> --}}
                    <h2>First Step</h2>
                    <p>SING UP AND SIGN IN.</p>
                </div>
            </li>
            <li>
                <div class="numberWrap">
                    <div class="number fontColor2">2</div>
                    <div class="coverWrap">
                        <div class="numberCover"></div>
                    </div>
                </div>
                <div class="content">
                    {{-- <div class="icon iconSocial"></div> --}}
                    <h2>Second Step</h2>
                    <p>KYC APPROVAL.</p>
                </div>
            </li>
            <li>
                <div class="numberWrap">
                    <div class="number  fontColor3">3</div>
                    <div class="coverWrap">
                        <div class="numberCover"></div>
                    </div>
                </div>
                <div class="content">
                    {{-- <div class="icon iconAirplane"></div> --}}
                    <h2>Third Step</h2>
                    <p>BUY PACKAGES.</p>
                </div>
            </li>
            <li>
                <div class="numberWrap">
                    <div class="number  fontColor4">4</div>
                    <div class="coverWrap">
                        <div class="numberCover"></div>
                    </div>
                </div>
                <div class="content">
                    {{-- <div class="icon iconMap"></div> --}}
                    <h2>Fourth Step</h2>
                    <p>WITHDRAW MONEY.</p>
                </div>
            </li>
        </ul>
    </section>

    <section class="image-block bg-image-1 parallax">
        <div class="container benefit-back">
            <div class="row">
                <!-- Features Starts -->
                <div class="col-md-8 benefit-list">
                    <div class="row row-merge">
                        @if (count($benefits) > 0)
                            @foreach ($benefits as $section)
                                <div class="col-sm-6 col-md-6 col-xs-12">
                                    <div class="feature text-center">
                                        <span class="feature-icon">
                                            <img id="strong-security"
                                                src="{{ storage('pages/' . $section->image) }}"
                                                alt="strong security">
                                        </span>
                                        <h3 class="feature-title">{{ $section->title }}</h3>
                                        {!! $section->content !!}<br>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                    </div>
                </div>
                <!-- Features Ends -->
                <!-- Video Starts -->
                <div class="col-md-4 ts-padding">
                    <div class='vertical-btn'>
                        <div class="text-center">

                            <a class="button-video mfp-youtube" href="https://www.youtube.com/watch?v=3aV5-q8vRz8"></a>

                        </div>
                    </div>
                </div>
                <!-- Video Ends -->
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="owl-carousel owl-theme casino-slider">
                @foreach ($packages->children as $section)
                    <div class="item">
                        <a href="https://www.747live.net/
                            " target="_blank"><img
                                src="{{ storage('pages/' . $section->image) }}" alt=""></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Quote and Chart Section Ends -->
    <!-- Comment Section Starts -->

    {{-- <section class="team about-css">
        <div class="container">
            <!-- Section Title Starts -->
            <div class="row text-center">
                <h2 class="title-head">our <span>testimonials .</span></h2>
                <div class="title-head-subtitle">
                    <p>A talented team of invest testimonials </p>
                </div>
            </div>
            <!-- Section Title Ends -->
            <!-- Team Members Starts -->

            <div id="testim" class="testim">
                <!--         <div class="testim-cover"> -->
                <div class="wrap">
                    <span id="right-arrow" class="arrow right fa fa-chevron-right"></span>
                    <span id="left-arrow" class="arrow left fa fa-chevron-left "></span>
                    <ul id="testim-dots" class="dots">
                        @foreach ($testimonials as $key => $testimonial)
                            @if ($key == 0)
                                <li class="dot active"></li>
                            @else
                                <li class="dot"></li>
                            @endif
                        @endforeach
                    </ul>
                    <div id="testim-content" class="cont">

                        @foreach ($testimonials as $key => $testimonial)
                            @if ($key == 0)
                                @php
                                    $status = 'active';
                                @endphp
                            @else
                                @php
                                    $status = '';
                                @endphp
                            @endif

                            <div class="{{ $status }}">
                                <div class="img"><img src="{{ storage('testimonials/' . $testimonial->image) }}"
                                        alt=""></div>
                                <h2>{{ $testimonial->name }}</h2>

                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt
                                    ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco.</p>
                            </div>
                        @endforeach

                    </div>

                </div>
                <!-- </div> -->
            </div>
            <!-- Team Members Ends -->
        </div>
    </section> --}}
    <!-- Comment Section Ends -->
    
    <!-- Blog Section Starts -->

    <section class="blog">
        <div class="container">
            <!-- Section Title Starts -->
            <div class="row text-center">
                <h2 class="title-head">Our <span>News .</span></h2>
                <div class="title-head-subtitle">
                    <p>Discover latest news about on our news</p>

                </div>
            </div>
            <!-- Section Title Ends -->
            <!-- Section Content Starts -->
            <div class="row latest-posts-content">
                @foreach ($all_news->slice(0, 3) as $news)
                    <!-- Article Starts -->
                    <div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="latest-post">
                            <!-- Featured Image Starts -->
                            <a href="{{ route('news.show', $news) }}"><img class="img-responsive"
                                    src="{{ storage('blogs/' . $news->image) }}"
                                    alt="{{ storage('blogs/' . $news->image) }}"></a>
                            <!-- Featured Image Ends -->
                            <!-- Article Content Starts -->
                            <div class="post-body">
                                <h4 class="post-title">
                                    <a href="{{ route('news.show', $news) }}"> {{ $news->title }}</a>
                                </h4>
                                <div class="post-text">
                                    {{ $news->short_description }}
                                </div>
                            </div>
                            <div class="post-date">
                                <span>{{ date('d', strtotime($news->created_at)) }}</span>
                                <span>{{ date('M', strtotime($news->created_at)) }}</span>
                            </div>
                            <a href="{{ route('news.show', $news) }}" class="btn btn-primary">read more</a>
                            <!-- Article Content Ends -->
                        </div>
                    </div>
                    <!-- Article Ends -->
                @endforeach

            </div>
            <!-- Section Content Ends -->
        </div>
    </section>
    <!-- Blog Section Ends -->

    @push('scripts')
        <script src="{{ asset('assets/frontend/js/testimonials.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/hiw2.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/net_home.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
