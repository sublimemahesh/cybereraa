<header class="site-header header-style-6">

    <div class="top-bar bg-primary">
        <div class="container">
            <div class="row">
                <div class="clearfix">
                    <div class="wt-topbar-left">
                        <ul class="social-icons social-square social-darkest">
                            <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-linkedin"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                            <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                        </ul>
                    </div>

                    <div class="wt-topbar-right">

                        <ul class="list-unstyled e-p-bx pull-right">
                            @auth()
                            <li>
                                <a class="site-button header-btn" href="{{ route(authUserFolder() .'.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                            </li>
                            @endauth
                            @guest()
                            <li>
                                <a class="site-button header-btn" href="{{ route('login') }}"><i class="fa fa-user"></i>Login</a>
                            </li>
                            <li>
                                <a class="site-button header-btn" href="{{ route('register') }}"><i class="fa fa-sign-in"></i>Register</a>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Link -->

    <!-- Search Form -->
    <div class="main-bar header-middle themecolor-2">
        <div class="container">
            <div class="logo-header mob-width">
                <a href="{{ route('/') }}">
                    <img src="{{ asset('assets/frontend/images/logo-dark.png') }}" width="216" height="37" alt="" />
                </a>
            </div>
            <div class="header-info">
                <ul>
                    <li>
                        <div>
                            <div class="icon-sm">
                                <span class="icon-cell  text-primary"><i class="iconmoon-travel"></i></span>
                            </div>
                            <div class="icon-content">
                                <strong>Our Location </strong>
                                <span>145 N Los Ave, NY</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div>
                            <div class="icon-sm">
                                <span class="icon-cell  text-primary"><i class="iconmoon-smartphone-1"></i></span>
                            </div>
                            <div class="icon-content">
                                <strong>Phone Number</strong>
                                <span>1500-2309-0202</span>
                            </div>
                        </div>
                    </li>
                    {{-- <li class="btn-col-last">
                        <a class="site-button text-uppercase radius-sm font-weight-700">Requet a Quote</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="sticky-header main-bar-wraper">
        <div class="main-bar header-botton nav-bg-secondry">
            <div class="container">
                <!-- NAV Toggle Button -->
                <button data-target=".header-nav" data-toggle="collapse" type="button" class="navbar-toggle collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- ETRA Nav -->


                <!-- MAIN Vav -->
                <div class="header-nav navbar-collapse collapse ">
                    <ul class=" nav navbar-nav">
                        <li class="active">
                            <a href="{{ route('/') }}">HOME</i></a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">ABOUT US</i></a>
                        </li>

                        <li>
                            <a href="javascript:;">PROJECTS<i class="fa fa-chevron-down"></i></a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="{{ route('project') }}">EXISTING PROJECTS</a>
                                </li>
                                <li>
                                    <a href="{{ route('Upcoming-project') }}">UPCOMING PROJECTS</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('pricing') }}">PACKAGES</i></a>
                        </li>
                        <li>
                            <a href="{{ route('how-it-work') }}">HOW IT WORK</a>
                        </li>

                        <li>
                            <a href="{{ route('faq') }}">FAQ</i></a>
                        </li>

                        <li>
                            <a href="{{ route('news') }}">NEWS</i></a>
                        </li>

                        <li>
                            <a href="{{ route('contact') }}">CONTACT US</i></a>
                        </li>



                    </ul>
                </div>
            </div>
        </div>
    </div>

</header>
