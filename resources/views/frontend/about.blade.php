
<x-frontend.layouts.app>
    @section('title', 'about')
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
<section class="about-page">
    <div class="container">
        <!-- Section Content Starts -->
        <div class="row about-content">
            <!-- Image Starts -->
            <div class="col-sm-12 col-md-5 col-lg-6 text-center">
                <img id="about-us" class="img-responsive img-about-us" src="{{ asset('assets/frontend/images/down/unnamed11.png') }}" alt="about us">
            </div>
            <!-- Image Ends -->
            <!-- Content Starts -->
            <div class="col-sm-12 col-md-7 col-lg-6">
                <div class="feature-about">
                    <h3 class="title-about">WE ARE SAFEST TRADES </h3>
                    <p>Lorem ipsum Contrary to popular belief, Lorem Ipsum is not simply random text.
                        It has roots in a piece of classical Latin literature from 45 BC,
                        making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
                        College in Virginia, looked up one of the more obscure Latin words,
                        consectetur, from a Lorem Ipsum passage, and going through the cites of
                        the word in classical literature, discovered the undoubtable source.
                        Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus
                        Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC.
                        This book is a treatise on the theory of ethics, very popular during the Renaissance.
                        The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..",
                        comes from a line in section 1.10.32...</p>
                </div>
                <a class="btn btn-primary btn-services" href="pricing.php">Our Packages</a>
            </div>
            <!-- Content Ends -->

        </div>
        <!-- Section Content Ends -->
    </div>
    <!--/ Content row end -->
</section>
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