

<x-frontend.layouts.app>
    @section('title', 'Contact Us')
    @section('header-title', 'Welcome ')
    @section('styles')
    @endsection


{{-- <section class="banner-area">
    <div class="banner-overlay">
        <div class="banner-text text-center">
            <div class="container">
                <!-- Section Title Starts -->
                <div class="row text-center">
                    <div class="col-xs-12">
                        <!-- Title Starts -->
                        <h2 class="title-head">Contact <span>us</span></h2>
                        <!-- Title Ends -->
                        <hr>
                        <!-- Breadcrumb Starts -->
                        <ul class="breadcrumb">
                            <li><a href="index-2.html"> home</a></li>
                            <li>contact</li>
                        </ul>
                        <!-- Breadcrumb Ends -->
                    </div>
                </div>
                <!-- Section Title Ends -->
            </div>
        </div>
    </div>
</section> --}}
<!-- Banner Area Ends -->
<!-- Contact Section Starts -->


<div id="page">
    <section id="hero" class='net-hero'>
        <div class="background">
            <canvas id="hero-background"></canvas>
        </div>
        <div class="foreground">
            <div class="main">
                <section class="banner-area">
                    <div class="banner-overlay">
                        <div class="banner-text text-center">
                            <div class="container">
                                <!-- Section Title Starts -->
                                <div class="row text-center">
                                    <div class="col-xs-12">
                                        <!-- Title Starts -->
                                        <h2 class="title-head">Contact <span>us</span></h2>
                                        <!-- Title Ends -->
                                        <hr>
                                        <!-- Breadcrumb Starts -->
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('/') }}" id='home'> home</a></li>
                                            <li>contact</li>
                                        </ul>
                                        <!-- Breadcrumb Ends -->
                                    </div>
                                </div>
                                <!-- Section Title Ends -->
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </section>
</div>





 <section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 contact-form">
                <h3 class="col-xs-12">feel free to drop us a message</h3>
                <p class="col-xs-12">Need to speak to us? Do you have any queries or suggestions? Please contact us
                    about all enquiries including membership and volunteer work using the form below.</p>
                <!-- Contact Form Starts -->
                <form class="form-contact" method="post" action="https://slimhamdi.net/bayya/php/process-form.php">
                    <!-- Input Field Starts -->
                    <div class="form-group col-md-6">
                        <input class="form-control" name="firstname" id="firstname" placeholder="FIRST NAME"
                            type="text" required>
                    </div>
                    <!-- Input Field Ends -->
                    <!-- Input Field Starts -->
                    <div class="form-group col-md-6">
                        <input class="form-control" name="lastname" id="lastname" placeholder="LAST NAME"
                            type="text" required>
                    </div>
                    <!-- Input Field Ends -->
                    <!-- Input Field Starts -->
                    <div class="form-group col-md-6">
                        <input class="form-control" name="email" id="email" placeholder="EMAIL" type="email"
                            required>
                    </div>
                    <!-- Input Field Ends -->
                    <!-- Input Field Starts -->
                    <div class="form-group col-md-6">
                        <input class="form-control" name="text" id="subject" placeholder="SUBJECT" type="text"
                            required>
                    </div>
                    <!-- Input Field Ends -->
                    <!-- Input Field Starts -->
                    <div class="form-group col-xs-12">
                        <textarea class="form-control" id="message" name="message" placeholder="MESSAGE" required></textarea>
                    </div>
                    <!-- Input Field Ends -->
                    <!-- Submit Form Button Starts -->
                    <div class="form-group col-xs-12 col-sm-4">
                        <button class="btn btn-primary btn-contact" type="submit">send message</button>
                    </div>
                    <!-- Submit Form Button Ends -->
                    <!-- Form Submit Message Starts -->
                    <div class="col-xs-12 text-center output_message_holder d-none">
                        <p class="output_message"></p>
                    </div>
                    <!-- Form Submit Message Ends -->
                </form>
                <!-- Contact Form Ends -->
            </div>
            <!-- Contact Widget Starts -->
            <div class="col-xs-12 col-md-4">
                <div class="widget">
                    <div class="contact-page-info">
                        <!-- Contact Info Box Starts -->
                        <div class="contact-info-box">
                            <i class="fa fa-home big-icon"></i>
                            <div class="contact-info-box-content">
                                <h4>Address</h4>
                                <p>123 Disney Street Slim Av. Brooklyn Bridge, NY, New York</p>
                            </div>
                        </div>
                        <!-- Contact Info Box Ends -->
                        <!-- Contact Info Box Starts -->
                        <div class="contact-info-box">
                            <i class="fa fa-phone big-icon"></i>
                            <div class="contact-info-box-content">
                                <h4>Phone Numbers</h4>
                                <p>+88 0123 4567 890<br>+88 0231 3421 453</p>
                            </div>
                        </div>
                        <!-- Contact Info Box Ends -->
                        <!-- Contact Info Box Starts -->
                        <div class="contact-info-box">
                            <i class="fa fa-envelope big-icon"></i>
                            <div class="contact-info-box-content">
                                <h4>Email Addresses</h4>

                                <p>contact@example.com<br>info@example.com</p>
                            </div>
                        </div>
                        <!-- Contact Info Box Ends -->
                        <!-- Social Media Icons Starts -->
                        <div class="contact-info-box">
                            <i class="fa fa-share-alt big-icon"></i>
                            <div class="contact-info-box-content">
                                <h4>Social Profiles</h4>
                                <div class="social-contact">
                                    <ul>
                                        <li class="facebook"><a href="#" target="_blank"><i
                                                    class="fa fa-facebook"></i></a></li>
                                        <li class="twitter"><a href="#" target="_blank"><i
                                                    class="fa fa-twitter"></i></a></li>
                                        <li class="google-plus"><a href="#" target="_blank"><i
                                                    class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Social Media Icons Starts -->
                    </div>
                </div>
            </div>
            <!-- Contact Widget Ends -->
        </div>
    </div>
</section> 


<!-- Contact Section Ends -->

@push('scripts')
<script src="{{ asset('assets/frontend/js/net.js') }}"></script>
@endpush
</x-frontend.layouts.app>