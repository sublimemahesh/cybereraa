<!-- Call To Action Section Starts -->
<section class="call-action-all">
    <div class="call-action-all-overlay">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Call To Action Text Starts -->
                    <div class="action-text">
                        <h2>COME AND JOIN US TO WIN YOUR LIFE!...</h2>
                        <p class="lead">What if your dream investment can be made in the safest spot on the earth? just invest and wait and enjoy up to a guaranteed return of 400% in 15 months.
                            Daily withdrawals, No claim Bonuses, and many more massive benefits.</p>
                    </div>
                    <!-- Call To Action Text Ends -->
                    <!-- Call To Action Button Starts -->
                    <p class="action-btn">
                        <a class="btn btn-primary" href="{{ route('register') }}">Register Now</a>
                    </p>
                    <!-- Call To Action Button Ends -->
                </div>
            </div>
            <div class="header-logo-img">
                <img class='shimmer' src="{{ asset('assets/frontend/images/project/header_icon_img.png') }}" alt="">
            </div>
        </div>
    </div>
</section>

<!-- Call To Action Section Ends -->


<!-- Footer Starts -->
<footer class="footer">
    <!-- Footer Top Area Starts -->
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <!-- Footer Widget Starts -->
                <div class="col-sm-4 col-md-2">
                    <h4>Short Links</h4>
                    <div class="menu">
                        <ul>
                            <li>
                                <a href="{{ route('/') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}">About Us</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Widget Ends -->
                <!-- Footer Widget Starts -->
                <div class="col-sm-4 col-md-2">
                    <h4>Important Links</h4>
                    <div class="menu">
                        <ul>
                            <li>
                                <a href="{{ route('faq') }}">FAQ</a>
                            </li>
                            <li>
                                <a href="{{ route('terms&Conditions') }}">Terms and conditions</a>
                            </li>
                            <li>
                                <a href="{{ route('disclaimer') }}">Disclaimer</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Footer Widget Ends -->
                <!-- Footer Widget Starts -->
                <div class="col-sm-4 col-md-3">
                    <h4>Contact Us </h4>
                    <div class="contacts">
                        <div>
                            <span> <a href="mailto:support@safesttrades.com">support@safesttrades.com</a></span>
                        </div>
                        <div>
                            <span> Safest Trades, Proton Trading Pro LLC., 140 21ST ST STE R, Sacramento, CA 95811.</span>
                        </div>
                    </div>
                    <!-- Social Media Profiles Ends -->
                </div>
                <!-- Footer Widget Ends -->
                <!-- Footer Widget Starts -->
                <div class="col-sm-12 col-md-5">
                    {!! $footer_numbers['social_media_links']->content !!}
                </div>
                <!-- Footer Widget Ends -->
            </div>
        </div>
    </div>
    <!-- Footer Top Area Ends -->
    <!-- Footer Bottom Area Starts -->
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Copyright Text Starts -->
                    <p class="text-center">© <?php echo date("Y"); ?> Safest Trades. All Rights Reserved. | Solution by
                        <a href="https://www.synotec.lk/" target="_blank">Synotec Holdings Pvt. Ltd
                        </a>
                    </p>
                    <!-- Copyright Text Ends -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom Area Ends -->
</footer>
<!-- Footer Ends -->
<!-- Back To Top Starts  -->
<a href="#" id="back-to-top" class="back-to-top fa fa-arrow-up"></a>
<!-- Back To Top Ends  -->
