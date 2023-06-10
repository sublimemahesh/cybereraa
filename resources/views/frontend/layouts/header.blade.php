<header class="site-header header-style-3 topbar-transparent">

        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="clearfix">
                        <div class="wt-topbar-left">
                               <ul class="list-unstyled e-p-bx pull-left">
                                <li><i class="fa fa-envelope"></i>mail@bitinvest.com</li>
                                <li><i class="fa fa-phone"></i>(654) 321-7654</li>
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
            <div class="main-bar">
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


                        <!-- ETRA Nav -->
                        <div class="extra-nav">
                            <div class="extra-cell">
                                <a href="#search" class="site-search-btn"><i class="fa fa-search"></i></a>
                            </div>
                            <div class="extra-cell">
                                <a href="javascript:;" class="wt-cart cart-btn" title="Your Cart">
                                    <span class="link-inner">
                                        <span class="woo-cart-total"> </span>
                                        <span class="woo-cart-count">
                                            <span class="shopping-bag wcmenucart-count ">2</span>
                                        </span>
                                    </span>
                                </a>

                              <div class="cart-dropdown-item-wraper clearfix">
                                <div class="nav-cart-content">

                                    <div class="nav-cart-items p-a15">
                                        <div class="nav-cart-item clearfix">
                                            <div class="nav-cart-item-image">
                                                <a href="#"><img src="{{asset('assets/frontend/images/cart/pic-3.jpg') }}" alt="p-1"></a>
                                            </div>
                                            <div class="nav-cart-item-desc">
                                                <a href="#">Product Three</a>
                                                <span class="nav-cart-item-price"><strong>2</strong> x $19.99</span>
                                                <a href="#" class="nav-cart-item-quantity">x</a>
                                            </div>
                                        </div>
                                        <div class="nav-cart-item clearfix">
                                            <div class="nav-cart-item-image">
                                                <a href="#"><img src="{{asset('assets/frontend/images/cart/pic-4.jpg') }}" alt="p-2"></a>
                                            </div>
                                            <div class="nav-cart-item-desc">
                                                <a href="#">Product Four</a>
                                                <span class="nav-cart-item-price"><strong>1</strong> x $24.99</span>
                                                <a href="#" class="nav-cart-item-quantity">x</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nav-cart-title p-tb10 p-lr15 clearfix">
                                        <h4  class="pull-left m-a0">Subtotal:</h4>
                                        <h5 class="pull-right m-a0">$114.95</h5>
                                    </div>
                                    <div class="nav-cart-action p-a15 clearfix">
                                        <button class="site-button  btn-block m-b15 " type="button">View Cart</button>
                                        <button class="site-button  btn-block" type="button">Checkout </button>
                                    </div>
                                </div>
                              </div>

                            </div>
                         </div>

                        <!-- SITE Search -->
                        <div id="search">
                        <span class="close"></span>
                        <form role="search" id="searchform" action="http://thewebmax.com/search" method="get" class="radius-xl">
                            <div class="input-group">
                                <input value="" name="q" type="search" placeholder="Type to search"/>
                                <span class="input-group-btn"><button type="button" class="search-btn"><i class="fa fa-search"></i></button></span>
                            </div>
                        </form>
                    </div>

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
