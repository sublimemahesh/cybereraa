<x-frontend.layouts.app>
    @section('title', 'Contact Us | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')


    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white  banner-txt">Contact</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->



        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">
                <div class="wt-box col-md-6">
                    <h4 class="text-uppercase">Contact Detail </h4>
                    <div class="wt-separator-outer m-b30">
                        <div class="wt-separator bg-primary"></div>
                    </div>

                    {{-- <div class="m-b30">
                        <div class="wt-icon-box-wraper bx-style-1 p-a15 left clearfix themecolor-1">
                            <div class="icon-sm">
                                <span class="icon-cell text-primary">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </div>
                            <div class="icon-content text-black">
                                <h5 class="wt-tilte text-uppercase">Phone</h5>
                                <p>+91 564 548 4854</p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="m-b30">
                        <div class="wt-icon-box-wraper bx-style-1 p-a15 left clearfix themecolor-1">
                            <div class="icon-sm">
                                <span class="icon-cell text-primary">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <div class="icon-content text-black">
                                <h5 class="wt-tilte text-uppercase">Email</h5>
                                <p>support@owara3m.com</p>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="m-b30">
                        <div class="wt-icon-box-wraper bx-style-1 p-a15 left clearfix themecolor-1">
                            <div class="icon-sm">
                                <span class="icon-cell text-primary">
                                    <i class="fa fa-fax"></i>
                                </span>
                            </div>
                            <div class="icon-content text-black">
                                <h5 class="wt-tilte text-uppercase">Fax</h5>
                                <p>+91 564 548 4854</p>
                            </div>
                        </div>
                    </div> --}}
{{-- 
                    <div class="m-b30">
                        <div class="wt-icon-box-wraper bx-style-1 p-a15 left clearfix themecolor-1">
                            <div class="icon-sm">
                                <span class="icon-cell text-primary">
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                            <div class="icon-content text-black">
                                <h5 class="wt-tilte text-uppercase">Address</h5>
                                <p>252 W 43rd St New York, NY</p>
                            </div>
                        </div>
                    </div> --}}

                </div>
                <div class="wt-box col-md-6">
                    <h4 class="text-uppercase">Contact Form </h4>
                    <div class="wt-separator-outer m-b30">
                        <div class="wt-separator bg-primary"></div>
                    </div>
                    <div class="p-a50 p-b60 themecolor-1">
                        <form class="cons-contact-form" method="post" action="http://thewebmax.com/bitinvest/form-handler.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="username" type="text" required class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input name="email" type="text" class="form-control" required placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon v-align-t"><i class="fa fa-pencil"></i></span>
                                    <textarea name="message" rows="5" class="form-control Message" required placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button name="submit" type="submit" value="Submit" class="site-button-secondry ">Submit</button>
                                <button name="Resat" type="reset" value="Reset" class="site-button ">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- SECTION CONTENT END -->
        </div>
    </div>
 <!-- CONTENT END -->


</x-frontend.layouts.app>
