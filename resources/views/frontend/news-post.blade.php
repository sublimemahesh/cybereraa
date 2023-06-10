<x-frontend.layouts.app>
    @section('title', 'News | Owara3m ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header-other')
    
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url(images/banner/blog-banner.jpg);">
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
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT START -->
        <div class="section-full p-t80 p-b50 bg-black-light">
            <div class="container">

                <!-- BLOG START -->
                <div class="blog-post date-style-1 blog-detail">
                    <div class="wt-post-media wt-img-effect">
                        <a href="javascript:void(0);"><img src="images/blog/default/thum1.jpg" alt=""></a>
                    </div>
                    <div class="wt-post-title ">
                        <h3 class="post-title"><a href="javascript:void(0);">Maiores, sunt eveniet doloremque porro hic exercitationem distinctio sequi adipisci. Nulla, fuga perferendis </a></h3>
                    </div>
                    <div class="wt-post-meta ">
                        <ul>
                            <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                            <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                            <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0</a> </li>
                        </ul>
                    </div>
                    <div class="wt-post-text">
                        <p>Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.</p>

                        <p>Nullam id dolor id nibh ultricies vehicula ut id elit. <a href="#">Curabitur blandit tempus porttitor</a>. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.</p>

                        <blockquote>
                            The trouble with programmers is that you can never tell what a programmer is doing until it's too late. The future belongs to a different kind of person with a different kind of mind: artists, inventors, storytellers-creative and holistic ‘right-brain’ thinkers whose abilities mark the fault line between who gets ahead and who doesn’t.
                            <div class="p-t15">
                                <p> – Daniel Pink</p>
                            </div>
                        </blockquote>

                        <p class="clearfix">
                            Asperiores, tenetur, blanditiis, quaerat odit ex exercitationem pariatur quibusdam veritatis quisquam laboriosam esse beatae hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis Consectetur, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium vitae, consequuntur minima tempora cupiditate ratione est, ad molestias deserunt in ipsam ea quasi cum culpa adipisci dolores voluptatum fuga at! assumenda provident lorem ipsum dolor sit amet, consectetur.</p>

                        <p>Nullam id dolor id nibh ultricies vehicula ut id elit. <a href="#">Curabitur blandit tempus porttitor</a>. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida at eget metus. Vestibulum id ligula porta felis euismod semper.</p>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id dolor dui, dapibus gravida elit. Donec consequat laoreet sagittis. Suspendisse ultricies ultrices viverra. Morbi rhoncus laoreet tincidunt. Mauris interdum convallis metus. Suspendisse vel lacus est, sit amet tincidunt erat. Etiam purus sem, euismod eu vulputate eget, porta quis sapien. Donec tellus est, rhoncus vel scelerisque id, iaculis eu nibh.</p>

                        <p>Donec posuere bibendum metus. Quisque gravida luctus volutpat. Mauris interdum, lectus in dapibus molestie, quam felis sollicitudin mauris, sit amet tempus velit lectus nec lorem. Nullam vel mollis neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel enim dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed tincidunt accumsan massa id viverra. Sed sagittis, nisl sit amet imperdiet convallis, nunc tortor consequat tellus, vel molestie neque nulla non ligula. Proin tincidunt tellus ac porta volutpat. Cras mattis congue lacus id bibendum. Mauris ut sodales libero. Maecenas feugiat sit amet enim in accumsan.</p>

                        <p>Duis vestibulum quis quam vel accumsan. Nunc a vulputate lectus. Vestibulum eleifend nisl sed massa sagittis vestibulum. Vestibulum pretium blandit tellus, sodales volutpat sapien varius vel. Phasellus tristique cursus erat, a placerat tellus laoreet eget. Fusce vitae dui sit amet lacus rutrum convallis. Vivamus sit amet lectus venenatis est rhoncus interdum a vitae velit.
                        </p>


                    </div>
                    <div class="widget bg-black-light  widget_tag_cloud">
                        <h4 class="tagcloud">Tags</h4>
                        <div class="tagcloud">
                            <a class="bg-orange" href="javascript:void(0);">First tag</a>
                            <a href="javascript:void(0);">Second tag</a>
                            <a href="javascript:void(0);">Three tag</a>
                            <a href="javascript:void(0);">Four tag</a>
                            <a href="javascript:void(0);">Five tag</a>
                        </div>
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
                        <h2 class="text-uppercase">Related Blog Post</h2>
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
                            <!-- COLUMNS 1 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="javascript:void(0);"><img src="images/blog/grid/pic1.jpg" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0 Comments</a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>Hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="javascript:void(0);" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            <!-- COLUMNS 2 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="javascript:void(0);"><img src="images/blog/grid/pic2.jpg" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0 Comments</a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>Hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="javascript:void(0);" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            <!-- COLUMNS 3 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="javascript:void(0);"><img src="images/blog/grid/pic3.jpg" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0 Comments</a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>Hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="javascript:void(0);" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            <!-- COLUMNS 4 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="javascript:void(0);"><img src="images/blog/grid/pic4.jpg" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0 Comments</a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>Hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="javascript:void(0);" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            <!-- COLUMNS 5 -->
                            <div class="item">
                                <div class="blog-post blog-grid date-style-1">
                                    <div class="wt-post-media wt-img-effect zoom-slow">
                                        <a href="javascript:void(0);"><img src="images/blog/grid/pic5.jpg" alt=""></a>
                                    </div>
                                    <div class="wt-post-info p-tb30 p-m30">
                                        <div class="wt-post-title ">
                                            <h3 class="post-title"><a href="javascript:void(0);">Blogpost With Image</a></h3>
                                        </div>
                                        <div class="wt-post-meta ">
                                            <ul>
                                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>20 Dec</strong> <span> 2017</span> </li>
                                                <li class="post-author"><i class="fa fa-user"></i><a href="javascript:void(0);">By <span>John</span></a> </li>
                                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="javascript:void(0);">0 Comments</a> </li>
                                            </ul>
                                        </div>
                                        <div class="wt-post-text">
                                            <p>Hic perferendis velit deserunt soluta iste repellendus officia in neque veniam debitis</p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="wt-post-readmore pull-left">
                                                <a href="javascript:void(0);" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
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
                            <!-- COLUMNS 6 -->


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
