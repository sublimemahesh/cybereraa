<header class="site-header header-style-3 topbar-transparent">

    <div class="top-bar">
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
                        <div class=" language-select pull-right">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Language
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><img src="{{ asset('assets/frontend/images/united-states.png') }}" alt="">English</a></li>
                                    <li><a href="#"><img src="{{ asset('assets/frontend/images/france.png') }}" alt="">French</a></li>
                                    <li><a href="#"><img src="{{ asset('assets/frontend/images/germany.png') }}" alt="">German</a></li>
                                </ul>
                            </div>
                        </div>

                        <ul class="list-unstyled e-p-bx pull-right">
                            <li><a href="#" data-toggle="modal" data-target="#Login-form"><i class="fa fa-user"></i>Login</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#Register-form"><i class="fa fa-sign-in"></i>Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sticky-header main-bar-wraper">
        <div class="main-bar main-bar-marging">
            <div class="container">

                <div class="logo-header mostion">
                    <a href="index-2.html">
                        <img src="{{asset('assets/frontend/images/logo-light.png') }}" width="230" height="67" alt="" />
                    </a>
                </div>

                <!-- NAV Toggle Button -->
                <button data-target=".header-nav" data-toggle="collapse" type="button" class="navbar-toggle collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

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
                                <li><a href="{{ route('project') }}">EXISTING PROJECTS</a></li>
                                <li><a href="{{ route('Upcoming-project') }}">UPCOMING PROJECTS</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('pricing') }}">PACKAGES</i></a>
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
