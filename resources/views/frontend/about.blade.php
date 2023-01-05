<x-frontend.layouts.app>
    @section('title', 'About Us')
    @section('header-title', 'Welcome ')
    @section('styles')

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

    <!-- About Section Ends -->
    <!-- Facts Section Starts -->

    <section class="facts">
        <!-- Container Starts -->
        <div class="container">
            <!-- Fact Badges Starts -->
            <div class="row text-center facts-content">
                <div class="text-center heading-facts">
                    <h2>SAFEST TRADES<span> numbers</span></h2>
                    <p>Lorem ipsum Contrary to popular belief, Lorem Ipsum is not simply random text</p>
                </div>
                <!-- Fact Badge Item Starts -->
                <div class="col-xs-12 col-md-3 col-sm-6 fact">
                    <h3>2015</h3>
                    <h4>Established since</h4>
                </div>
                <!-- Fact Badge Item Ends -->
                <!-- Fact Badge Item Starts -->
                <div class="col-xs-12 col-md-3 col-sm-6 fact fact-clear">
                    <h3>2K+</h3>
                    <h4>Number of Corporations</h4>
                </div>
                <!-- Fact Badge Item Ends -->
                <!-- Fact Badge Item Starts -->
                <div class="col-xs-12 col-md-3 col-sm-6 fact">
                    <h3>17k</h3>
                    <h4>Client Base</h4>
                </div>
                <!-- Fact Badge Item Ends -->
                <!-- Fact Badge Item Starts -->
                <div class="col-xs-12 col-md-3 col-sm-6">
                    <h3>170</h3>
                    <h4>Employees</h4>
                </div>
                <!-- Fact Badge Item Ends -->
                <div class="col-xs-12 buttons">
                    <a class="btn btn-primary btn-pricing" href="register.html">See pricing</a>
                    <span class="or"> or </span>
                    <a class="btn btn-primary btn-register" href="register.html">Register Now</a>
                </div>
            </div>
            <!-- Fact Badges Ends -->
        </div>
        <!-- Container Ends -->
    </section>

    <!-- facts Section Ends -->

    @push('scripts')
        {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}
    @endpush
</x-frontend.layouts.app>
