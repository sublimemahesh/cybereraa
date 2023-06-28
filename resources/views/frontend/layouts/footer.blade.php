<footer class="site-footer footer-dark bg-no-repeat bg-full-height bg-center " id='footer'  style="background-image:url({{ asset('assets/frontend/images/background/footer-bg.jpg') }});">
    <!-- FOOTER BLOCKES START -->
    <div class="footer-top overlay-wraper">
        <div class="overlay-main themecolor-1 opacity-05"></div>
        <div class="container">
            <div class="row">
                <!-- ABOUT COMPANY -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget_about">
                        <h4 class="widget-title text-white">About Company</h4>
                        <div class="logo-footer clearfix p-b15">
                            <a href="{{ route('/') }}"><img src="{{ asset('assets/frontend/images/footer-logo.png') }}" width="230" height="67" alt=""/></a>
                        </div>

                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="widget widget_services">
                        <h4 class="widget-title text-white">Useful links</h4>
                        <ul>
                            <li><a href="{{ route('about') }}">ABOUT</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('pricing') }}">PACKAGES</a></li>
                            <li><a href="{{ route('news') }}">NEWS</a></li>
                            <li><a href="{{ route('contact') }}">CONTACT US </a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="widget widget_services">
                        <h4 class="widget-title text-white">Useful links</h4>
                        <ul>
                            <li><a href="{{ route('disclaimer') }}"> DISCLAIMER </a></li>
                            <li><a href="{{ route('disclaimer') }}"> TERM AND CONDITONS </a></li>
                            <li><a href="{{ route('disclaimer') }}"> PRIVACY AND POLICY </a></li>
                        </ul>
                    </div>
                </div>
                <!-- NEWSLETTER -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget_newsletter">
                        <h4 class="widget-title text-white">Newsletter</h4>
                        <div class="newsletter-bx">
                            <form role="search" method="post">
                                <div class="input-group">
                                <input name="news-letter" class="form-control" placeholder="ENTER YOUR EMAIL" type="text">
                                <span class="input-group-btn">
                                    <button type="submit" class="site-button"><i class="fa fa-paper-plane-o"></i></button>
                                </span>
                            </div>
                             </form>
                        </div>
                    </div>
                    <!-- SOCIAL LINKS -->
                    <div class="widget widget_social_inks">
                        <h4 class="widget-title text-white">Social Links</h4>
                        <ul class="social-icons social-square social-darkest">
                            <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-linkedin"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- FOOTER COPYRIGHT -->
    <div class="footer-bottom themecolor-1  overlay-wraper">
        <div class="overlay-main"></div>
        <div class="constrot-strip"></div>
        <div class="container p-t30">
            <div class="row">
                <div class="wt-footer-bot-left">
                    <span class="copyrights-text">© 2023 . All Rights Reserved. Designed By Synotec Holdings Pvt. Ltd.</span>
                </div>
                <div class="wt-footer-bot-right">
                    <ul class="copyrights-nav pull-right">
                        <li><a href="javascript:void(0);">Terms  & Condition</a></li>
                        <li><a href="javascript:void(0);">Privacy Policy</a></li>
                        <li><a href="contact-1.html">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- BUTTON TOP START -->
<button class="scroltop"><span class=" iconmoon-house relative" id="btn-vibrate"></span>Top</button>
<!-- BUTTON TOP END -->
