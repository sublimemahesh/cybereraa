<x-frontend.layouts.app>
    @section('title', 'About Us')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="{{ asset('assets/frontend/css/road_map.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/frontend/css/mvv.css') }}" rel="stylesheet">

    @endsection



    <!-- Banner Area Starts -->
    <section class="banner-area">
        <div class="banner-overlay">
            <div class="banner-text text-center">
                <div class="container">
                    <!-- Section Title Starts -->
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <!-- Title Starts -->
                            <h2 class="title-head">About <span>Us</span></h2>
                            <!-- Title Ends -->
                            <hr>
                            <!-- Breadcrumb Starts -->
                            <ul class="breadcrumb">
                                <li><a href="index-2.html"> home</a></li>
                                <li>About</li>
                            </ul>
                            <!-- Breadcrumb Ends -->
                        </div>
                    </div>
                    <!-- Section Title Ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area Starts -->
    <!-- About Section Starts -->

    @foreach ($abouts->children as $section)
        <section class="about-page">
            <div class="container">
                <!-- Section Content Starts -->
                <div class="row about-content">
                    <!-- Image Starts -->
                    <div class="col-sm-12 col-md-5 col-lg-6 text-center">
                        <img id="about-us" class="img-responsive img-about-us"
                            src="{{ storage('pages/' . $section->image) }}" alt="about us">
                    </div>
                    <!-- Image Ends -->
                    <!-- Content Starts -->
                    <div class="col-sm-12 col-md-7 col-lg-6">
                        <div class="feature-about">
                            <h3 class="title-about">{{ $section->title }}</h3>
                            {!! $section->content !!}
                        </div>
                        {{-- <a class="btn btn-primary btn-services" href="pricing.php">Our Packages</a> --}}
                    </div>
                    <!-- Content Ends -->
                </div>
                <!-- Section Content Ends -->
            </div>
            <!--/ Content row end -->
        </section>
    @endforeach

    <section id="mvv">
    <div class="pt-5 pb-5">
        <div class="container">
        </div>
        <div class="container">
          <div class="row">
            <div  class="col-lg-6 col-md-6 ">

                <div class="col-lg-12 col-md-12 margin-30px-bottom xs-margin-20px-bottom">
                    <div class="services-block-three">
                        <a href="javascript:void(0)">
                            <div class="padding-15px-bottom">
                                <i class="fa fa-paper-plane-o"></i>
                            </div>
                            <h4>OUR MISSION</h4>
                            
                                @foreach ($homes_mission as $key => $hm)
                                {!!$hm->content !!}
                                @endforeach
                           
                        </a>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 margin-30px-bottom xs-margin-20px-bottom">
                    <div class="services-block-three">
                        <a href="javascript:void(0)">
                            <div class="padding-15px-bottom">
                                <i class="fa fa-eercast"></i>
                            </div>
                            <h4>OUR VISION</h4>
                            @foreach ($homes_vission as $key => $hvi)
                            {!!$hvi->content !!}
                            @endforeach
                        </a>
                    </div>
                </div>


            </div>
            <div class="col-lg-6 col-md-6 ">
                <div class="col-lg-12 col-md-12 margin-30px-bottom xs-margin-20px-bottom">
                    <div class="services-block-three">
                        <a href="javascript:void(0)">
                            <div class="padding-15px-bottom">
                                <i class="fa fa-diamond"></i>
                            </div>
                            <h4>OUR VALUES</h4>
                            @foreach ($homes_value as $key => $hval)
                            {!!$hval->content !!}
                            @endforeach
                        </a>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>








    <section id="road">
        <div class="container">
            <center>
                <h3 class="title-about">Roadmap</h3>
            </center><br>
            <div class="main-timeline">

                <!-- start experience section-->
                <div class="timeline">
                    <div class="icon"></div>
                    <div class="date-content">
                        <div class="date-outer">
                            <span class="date">
                                <span class="month">June</span>
                                <span class="year">2023</span>
                            </span>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h5 class="title">First Stage</h5>
                        <p class="description">
                            Enrolling all the kith and kins by the end of June 2023
                        </p>
                    </div>
                </div>
                <!-- end experience section-->

                <!-- start experience section-->
                <div class="timeline">
                    <div class="icon"></div>
                    <div class="date-content">
                        <div class="date-outer">
                            <span class="date">
                                <span class="month">December </span>
                                <span class="year">2023</span>
                            </span>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h5 class="title">Second stage</h5>
                        <p class="description">
                            Enrolling 10000 ambassadors by December 2023.
                        </p>
                    </div>
                </div>
                <!-- end experience section-->

                <!-- start experience section-->
                <div class="timeline">
                    <div class="icon"></div>
                    <div class="date-content">
                        <div class="date-outer">
                            <span class="date">
                                <span class="month">June</span>
                                <span class="year">2023</span>
                            </span>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h5 class="title">Third stage</h5>
                        <p class="description">
                            Launching our cryptocurrency by June 2023 and diversifying our cryptocurrency via leading
                            cryptocurrency exchanges, including Binance gate.io.
                        </p>
                    </div>
                </div>
                <!-- end experience section-->

                <!-- start experience section-->
                <div class="timeline">
                    <div class="icon"></div>
                    <div class="date-content">
                        <div class="date-outer">
                            <span class="date">
                                <span class="month">End of </span>
                                <span class="year">2024</span>
                            </span>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h5 class="title">fourth stage</h5>
                        <p class="description">
                            Building the community up to 100000 by the end of 2024.
                        </p>
                    </div>
                </div>
                <!-- end experience section-->

                <!-- start experience section-->
                <div class="timeline">
                    <div class="icon"></div>
                    <div class="date-content">
                        <div class="date-outer">
                            <span class="date">
                                <span class="month">End of </span>
                                <span class="year">2025 </span>
                            </span>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <h5 class="title">Fifth stage</h5>
                        <p class="description">
                            Building the community up to 1000000 by the end of 2025 and patronizing our cryptocurrency.
                        </p>
                    </div>
                </div>
                <!-- end experience section-->

            </div>
        </div>
    </section>




    @push('scripts')
        {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}
    @endpush
</x-frontend.layouts.app>
