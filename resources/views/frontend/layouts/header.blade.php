<div class="wrapper">
    <!-- Header Starts -->
    <header class="header">
        <div class="container">
            <div class="row">
                <!-- Logo Starts -->
                <div class="main-logo col-xs-12 col-md-3 col-md-3 col-lg-3 hidden-xs">
                    <a href="{{ route('/') }}">
                        <img id="logo" class="img-responsive mys-logo"
                            src="{{ asset('assets/frontend/images/down/logo.png') }}" alt="logo">
                    </a>
                </div>
                <!-- Logo Ends -->
                <!-- Statistics Starts -->
                <div class='mbd'>
                    <div class="col-md-6 col-lg-6 ">
                        <div class="owl-carousel owl-theme owl-loaded owl-drag div-r  " id="price-slider">
                            <div class="owl-stage-outer">
                                <div class="owl-stage"
                                    style="transform: translate3d(-1527px, 0px, 0px); transition: all 0.25s ease 0s; width: 3334px;">

                                    @foreach ($header_currency as $section)

                                    <div class="owl-item coin-list">
                                        <div class="item">
                                            <div>
                                                <p class='tp'><i class="fa fa-caret-up" aria-hidden="true"></i>{{ $section->change}}%(30
                                                    days)</p>
                                                <h5 class="ttt">$<?php echo number_format($section->value, 2); ?></h5>
                                                <img src="{{ storage('currencies/' . $section->image_name) }}"
                                                    class="cryimg">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="owl-nav disabled">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statistics Ends -->
                <!-- User Sign In/Sign Up Starts -->
                <div class="col-md-3 col-lg-3">
                    <ul class="unstyled user">
                        @auth
                            <li class="sign-in" id='log-btn'>
                                <a href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}"
                                    class="btn btn-primary  header-btn">
                                    {{-- <i class="fa fa-tachometer" aria-hidden="true"></i> --}}
                                    <i class="fas fa-tachometer-alt"> </i>
                                    My account </a>
                            </li>
                        @endauth
                        @guest
                            <li class="sign-in">
                                <a href="{{ route('login') }}" class="btn btn-primary  header-btn">
                                    <i class="fa fa-user"></i>
                                    signin</a>
                            </li>
                            <li class="sign-up">
                                <a href="{{ route('register') }}" class="btn btn-primary  header-btn"><i
                                        class="fa fa-user-plus"></i> register</a>
                            </li>
                        @endguest

                    </ul>
                </div>
                <!-- User Sign In/Sign Up Ends -->
            </div>
        </div>
        <!-- Navigation Menu Starts -->
        <nav class="site-navigation navigation" id="site-navigation">
            <div class="container">
                <div class="site-nav-inner">
                    <!-- Logo For ONLY Mobile display Starts -->
                    <a class="logo-mobile" href="index.php">
                        <img id="logo-mobile" class="img-responsive"
                            src="{{ asset('assets/frontend/images/down/logo.png') }}" alt="">
                    </a>
                    <!-- Logo For ONLY Mobile display Ends -->
                    <!-- Toggle Icon for Mobile Starts -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Toggle Icon for Mobile Ends -->
                    <div class="collapse navbar-collapse navbar-responsive-collapse">
                        <!-- Main Menu Starts -->
                        <ul class="nav navbar-nav">
                            <li id='index'><a href="{{ route('/') }}">Home</a></li>
                            <li id='about'><a href="{{ route('about') }}">About Us</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">projects<i
                                        class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('project') }}">Existing Projects</a></li>
                                    <li><a href="{{ route('Upcoming-project') }}">Upcoming Projects</a></li>
                                </ul>
                            </li>
                            
                            <li id='pricing'><a href="{{ route('pricing') }}"> Packages</a></li>
                            <li id='faq'><a href="{{ route('faq') }}">FAQ</a></li>
                            <li id='contact'><a href="{{ route('contact') }}">Contact</a></li>
                            <li id='news'><a href="{{ route('news') }}">News</a></li>
                        </ul>
                        <!-- Main Menu Ends -->
                    </div>
                </div>
            </div>
            <!-- Search Input Starts -->
            <div class="site-search">
                <div class="container">
                    <input type="text" placeholder="type your keyword and hit enter ...">
                    <span class="close">×</span>
                </div>
            </div>
            <!-- Search Input Ends -->
        </nav>
        <!-- Navigation Menu Ends -->
    </header>
