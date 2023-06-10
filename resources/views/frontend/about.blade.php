<x-frontend.layouts.app>
    @section('title', 'About Us | Owara3m ')
    @section('header-title', 'Welcome ')

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{ asset('assets/frontend/images/banner/about-banner.jpg') }});">
            <div class="overlay-main bg-black opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white">About Us</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="bg-black p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>About Us </li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB  ROW END -->

        <!-- ABOUT COMPANY SECTION START -->
        <div class="section-full p-tb100 bg-black-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="section-head text-left">
                            <span class="wt-title-subline text-gray-dark font-16 m-b15">What is bitcoin</span>
                            <h2 class="text-uppercase">A New Kind of Money </h2>
                            <div class="wt-separator-outer">
                                <div class="wt-separator bg-primary"></div>
                            </div>
                            <p><strong>Bitcoin is the world's first advanced decentralized cash and installment organize. Nullam non magna in diam ultricies hendrerit at nec ligula. </strong></p>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. remaining essentially unchanged. It was popularised in the with the .
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="wt-media">
                            <img src="{{ asset('assets/frontend/images/gallery/pic3.jpg') }}" alt="" class="img-responsive" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ABOUT COMPANY SECTION END -->

        <!-- WHY CHOOSE US SECTION START  -->
        <div class="section-full  p-t80 p-b80 bg-black">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head text-center">
                    <h2 class="text-uppercase">Why Choose Bitcoin</h2>
                    <div class="wt-separator-outer">
                        <div class="wt-separator bg-primary"></div>
                    </div>
                </div>
                <!-- TITLE END-->
                <div class="section-content no-col-gap">
                    <div class="row">

                        <!-- COLUMNS 1 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{asset('assets/frontend/images/icon/pick-29.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Instant Trading</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMNS 2 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ asset('assets/frontend/images/icon/pick-28.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content ">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Recurring Buying</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMNS 3 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ asset('assets/frontend/images/icon/pick-17.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Safe and Secure</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMNS 4 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ asset('assets/frontend/images/icon/pick-19.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Investment Planning</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMNS 5 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ asset('assets/frontend/images/icon/pick-12.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Covered By Insurance</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>
                        <!-- COLUMNS 6 -->
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center bg-black-light m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="#" class="icon-cell"><img src="{{ asset('assets/frontend/images/icon/pick-38.png') }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">Bitcoin Transaction</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesg indtrysum has been the Ipsum dummy of the printing indus .</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- WHY CHOOSE US SECTION END -->

        <!-- SECTION CONTENT -->
        <div class="section-full bg-primary p-t50 p-b30">
            <div class="container">
                <div class="section-content">
                    <div class="row">

                        <div class="col-md-3 col-sm-6">
                            <div class="text-black wt-icon-box-wraper center">
                                <div class="counter font-70 font-weight-800 m-b5">35</div>
                                <span class="font-18">Support Countries</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="m-b30 text-black wt-icon-box-wraper center">
                                <div class="font-70 font-weight-800 m-b5"><span class="counter">700</span></div>
                                <span class="font-18">BitCoin ATMs</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="m-b30 text-black wt-icon-box-wraper center">
                                <div class="counter font-70 font-weight-800 m-b5">300</div>
                                <span class="font-18">Producers</span>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="m-b30 wt-icon-box-wraper center text-black">
                                <div class="counter font-70 font-weight-800 m-b5">55</div>
                                <span class="font-18">Operators</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->




    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
