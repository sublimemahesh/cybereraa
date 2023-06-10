<x-frontend.layouts.app>
    @section('title', 'News | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/about-banner.jpg') }});">
            <div class="overlay-main bg-black opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white">News</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="bg-black p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><{{ route('news.show','news') }}><i class="fa fa-home"></i> Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT START -->
        <div class="section-full p-t80 p-b50 bg-black-light">
            <div class="container">

                <!-- BLOG POST START -->

                <!-- COLUMNS 1 -->
                <div class="blog-post blog-md date-style-1 clearfix">

                    <div class="wt-post-media wt-img-effect zoom-slow">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/de9Mhw2dU60"></iframe>

                    </div>
                    <div class="wt-post-info">

                        <div class="wt-post-title ">
                            <h3 class="post-title"><a href="{{ route('news.show','news') }}">Blogpost With Youtube</a></h3>
                        </div>
                        <div class="wt-post-meta ">
                            <ul>
                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                <li class="post-author"><i class="fa fa-user"></i><a href="news-single.php">By <span>John</span></a> </li>
                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="{{ route('news.show','news') }}">0</a> </li>
                            </ul>
                        </div>
                        <div class="wt-post-text">
                            <p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                        </div>
                        <div class="clearfix">
                            <div class="wt-post-readmore pull-left">
                                <a href="{{ route('news.show','news') }}" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
                            </div>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-radius social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- COLUMNS 2 -->
                <div class="blog-post blog-md date-style-1 clearfix">

                    <div class="wt-post-media wt-img-effect zoom-slow">
                        <iframe src="https://player.vimeo.com/video/23534361" width="1000" height="563"></iframe>
                    </div>
                    <div class="wt-post-info">

                        <div class="wt-post-title ">
                            <h3 class="post-title"><a href="{{ route('news.show','news') }}">Blogpost With Vimeo</a></h3>
                        </div>
                        <div class="wt-post-meta ">
                            <ul>
                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                <li class="post-author"><i class="fa fa-user"></i><a href="{{ route('news.show','news') }}">By <span>John</span></a> </li>
                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="{{ route('news.show','news') }}">0</a> </li>
                            </ul>
                        </div>
                        <div class="wt-post-text">
                            <p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                        </div>
                        <div class="clearfix">
                            <div class="wt-post-readmore pull-left">
                                <a href="{{ route('news.show','news') }}" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
                            </div>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-radius social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- COLUMNS 3 -->
                <div class="blog-post blog-md date-style-1 clearfix">

                    <div class="wt-post-media">
                        <!--Fade slider-->
                        <div class="owl-carousel owl-fade-slider-one owl-btn-vertical-center owl-dots-bottom-right">

                            <div class="item">
                                <div class="aon-thum-bx">
                                    <img src="{{ asset('assets/frontend/images/blog/grid/pic1.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="item">
                                <div class="aon-thum-bx">
                                    <img src="{{ asset('assets/frontend/images/blog/grid/pic2.jpg') }}" alt="">
                                </div>
                            </div>

                            <div class="item">
                                <div class="aon-thum-bx">
                                    <img src="{{ asset('assets/frontend/images/blog/grid/pic3.jpg') }}" alt="">
                                </div>
                            </div>

                        </div>
                        <!--fade slider END-->
                    </div>

                    <div class="wt-post-info">

                        <div class="wt-post-title ">
                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image slider</a></h3>
                        </div>
                        <div class="wt-post-meta ">
                            <ul>
                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                <li class="post-author"><i class="fa fa-user"></i><{{ route('news.show','news') }}>By <span>John</span></a> </li>
                                <li class="post-comment"><i class="fa fa-comments"></i> <{{ route('news.show','news') }}>0</a> </li>
                            </ul>
                        </div>

                        <div class="wt-post-text">
                            <p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                        </div>

                        <div class="clearfix">
                            <div class="wt-post-readmore pull-left">
                                <{{ route('news.show','news') }} title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
                            </div>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-radius social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>



                    </div>

                </div>
                <!-- COLUMNS 4 -->
                <div class="blog-post blog-md date-style-1 clearfix">

                    <div class="wt-post-media wt-img-effect zoom-slow">
                        <{{ route('news.show','news') }}><img src="images/blog/grid/pic4.jpg" alt=""></a>
                    </div>
                    <div class="wt-post-info">

                        <div class="wt-post-title ">
                            <h3 class="post-title"><{{ route('news.show','news') }}>Blogpost With Image</a></h3>
                        </div>
                        <div class="wt-post-meta ">
                            <ul>
                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                <li class="post-author"><i class="fa fa-user"></i><{{ route('news.show','news') }}>By <span>John</span></a> </li>
                                <li class="post-comment"><i class="fa fa-comments"></i> <{{ route('news.show','news') }}>0</a> </li>
                            </ul>
                        </div>
                        <div class="wt-post-text">
                            <p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                        </div>
                        <div class="clearfix">
                            <div class="wt-post-readmore pull-left">
                                <{{ route('news.show','news') }} title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
                            </div>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-radius social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- BLOG POST END -->

                <!-- PAGINATION START -->
                <div class="pagination-bx clearfix ">
                    <ul class="custom-pagination pagination">
                        <li><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
                <!-- PAGINATION END -->

            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->

</x-frontend.layouts.app>
