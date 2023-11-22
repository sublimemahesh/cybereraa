<x-frontend.layouts.app>
    @section('title', 'Contact Us | Coin1m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header')


    <!-- CONTENT START -->
    <!--==================================================-->
    <!-- Start breadcumb-area -->
    <!--==================================================-->
    <div class="breadcumb-area style-nine d-flex align-items-center" style="background: url('{{ asset('assets/frontend/images/inner-bg.jpg') }}');background-size: cover;background-position: center;background-repeat: no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breacumb-content">
                        <div class="breadcumb-title">
                            <h1>Contact Us</h1>
                        </div>
                        <div class="breadcumb-content-text">
                            <a href="index.php"> <span>home</span>Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==================================================-->
    <!-- Start info-area -->
    <!--==================================================-->
    <div class="info-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-info-box">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-area-title">
                            <h3>Address Ifno</h3>
                            <p>3281 Steve Hunts, Market <br> Florida, FL 33176</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-info-box">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-area-title">
                            <h3>Phone Calls</h3>
                            <p>+98 (5784) 123 789 <br> +88 (3412) 876 346</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-info-box">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-area-title">
                            <h3>E-Mail Address</h3>
                            <p>example@gmail.com <br> yourmail@yahoo.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--==================================================-->
    <!-- Start footer-area -->
    <!--==================================================-->
    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sections-title">
                        <div class="sub-title">
                            <h3>contacts</h3>
                        </div>
                        <div class="main-title">
                            <h1>Write Us Something</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-contact-box">
                        <div class="contact-thumb">
                            <img src="assets/images/contact.png" alt>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="singles-contacts-box">
                        <div class="contact-title">
                            <h3>get in touch</h3>
                        </div>
                        <form action="https://formspree.io/f/myyleorq" method="POST" id="dreamit-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form_box">
                                        <input type="text" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form_box">
                                        <input type="text" name="Enter E-mail" placeholder="Enter E-Mail">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form_box">
                                        <input type="text" name="subject" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form_box">
                                        <textarea name="massage" id="massage" cols="30" rows="10" placeholder="Massage"></textarea>
                                    </div>
                                    <div class="form-button">
                                        <button type="submit">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- CONTENT END -->


</x-frontend.layouts.app>
