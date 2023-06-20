<x-frontend.layouts.app>
    @section('title', 'News | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/about-banner.jpg') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white">News</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT START -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">

                <!-- BLOG START -->
                <div class="blog-post date-style-1 blog-detail">
                    <div class="wt-post-media wt-img-effect">
                        <a href="javascript:void(0);"><img src="{{ storage('blogs/' . $news->image) }}" alt=""></a>
                    </div>
                    <div class="wt-post-title ">
                        <h3 class="post-title"><a href="javascript:void(0);">{{ $news->title }}</a></h3>
                    </div>
                    <div class="wt-post-meta ">
                        <ul>
                            <li class="post-date"> <i class="fa fa-calendar"></i><strong>{{ date('d', strtotime($news->created_at)) }} {{ date('M', strtotime($news->created_at)) }}</strong> <span> {{ date('Y', strtotime($news->created_at)) }}</span> </li>
                            <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>Admin</span></a> </li>
                        </ul>
                    </div>
                    <div class="wt-post-text">

                        {!! html_entity_decode($news->description) !!}

                    </div>
                    
                    <div class="wt-box">
                        <div class="wt-divider bg-gray-dark"><i class="icon-dot c-square"></i></div>
                        <div class="row  p-lr15">
                            <h4 class="tagcloud pull-left m-t5 m-b0">Share this Post:</h4>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-md social-square social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="wt-divider bg-gray-dark"><i class="icon-dot c-square"></i></div>
                    </div>
                </div>

                <div class="section-content p-t50">
                    <!-- TITLE START -->
                    <div class="section-head">
                        <h2 class="text-uppercase">Related News Post</h2>
                        <div class="wt-separator-outer">
                            <div class="wt-separator style-square">
                                <span class="separator-left bg-primary"></span>
                                <span class="separator-right bg-primary"></span>
                            </div>
                        </div>
                    </div>
                    <!-- TITLE END -->

                    <!-- CAROUSEL -->
                    <div class="section-content">
                        <div class="owl-carousel blog-related-slider  owl-btn-vertical-center">
                           
                            @foreach ($all_news as $news_recent)
                            <!-- COLUMNS 1 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="{{ route('news.show', $news_recent) }}"><img src="{{ storage('blogs/' . $news_recent->image) }}" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="{{ route('news.show', $news_recent) }}">{{ $news_recent->title }}</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>{{ date('d', strtotime($news->created_at)) }} {{ date('M', strtotime($news->created_at)) }}</strong> <span> {{ date('Y', strtotime($news->created_at)) }}</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>Admin</span></a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>{{ $news_recent->short_description }}</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="{{ route('news.show', $news_recent) }}" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- BLOG END -->

            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
