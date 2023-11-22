<div class="main-header upper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="sticky-header" class="nav-menu">
                    <div class="header-logo">
                        <a href="{{ route('/') }}"><img src="{{asset('assets/frontend/images/logo.png') }}" alt=""></a>
                        <a class="main_sticky" href="{{ route('/') }}"><img src="{{asset('assets/frontend/images/logo.png') }}" alt=""></a>
                    </div>
                    <div class="heder-menu">
                        <ul>
                            <li><a href="{{ route('/') }}">Home</a></li>  
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="#">Projects +</a>
                                <div class="sub-menu">
                                    <ul>
                                        <li><a href="{{ route('project') }}">Existing Projects</a></li>
                                        <li><a href="{{ route('Upcoming-project') }}">Upcoming projects</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="{{ route('pricing') }}">Packages</a></li> 
                            <li><a href="{{ route('how-it-work') }}">How It Work</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('contact') }}">Contact </a></li>
                        </ul>
                        <div class="menu-button"> 
                            <a href="#">Join us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Start - Mobile-Menu- Section -->
<!-- ============================================================= -->
<div class="mobile-menu-area d-sm-block d-md-block d-lg-none ">
<div class="mobile-menu">
    <nav class="itsoft_menu">
        <ul class="nav_scroll">

            <li><a href="{{ route('/') }}">Home</a></li>
            <li><a href="about.php">about</a></li>
            <li><a href="#">Projects +</a>
                <div class="sub-menu">
                    <ul> 
                        <li><a href="existing-projects.php">Existing Projects</a></li>
                        <li><a href="upcoming-projects.php">Upcoming Projects</a></li>
                    </ul>
                </div>
            </li>

            <li><a href="packages.php">Packages </a></li>
            <li><a href="packhow-it-work.phpages.php">How It Work</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="contact.php">Contact </a></li>
        </ul>
    </nav>
</div>
</div>