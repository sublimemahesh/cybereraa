<x-frontend.layouts.app>
    @section('title', 'News | Safest Trades | One to One Marketing Website')
    @section('header-title', 'Welcome ')

    @section('meta')
        <meta name="description"
            content="What if your dream investment can be made in the safest spot on the earth? just invest and wait and enjoy up to a guaranteed return of 400% in 15 months.">
        <meta name="keywords"
            content="safesttrades, safest trades, one to one marketing, one to one marketing website, network marketing website, e money sites, money investment sites, cryptocurrency trading, trade, trade online, trades websites">
        <meta name="author" content="SAFEST TRADES">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @endsection

    @section('styles')
    @endsection


    <div id="page">
        <section id="hero" class='net-hero'>
            <div class="background">
                <canvas id="hero-background"></canvas>
            </div>
            <div class="foreground">
                <div class="main">
                    <section class="banner-area">
                        <div class="banner-overlay">
                            <div class="banner-text text-center">
                                <div class="container">
                                    <!-- Section Title Starts -->
                                    <div class="row text-center">
                                        <div class="col-xs-12">
                                            <!-- Title Starts -->
                                            <h2 class="title-head">{{ $news->title }}</h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}"> home</a></li>
                                                <li>{{ $news->title }}</li>
                                            </ul>
                                            <!-- Breadcrumb Ends -->
                                        </div>
                                    </div>
                                    <!-- Section Title Ends -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
        </section>
    </div>








    <!-- Section Content Starts -->
    <section id="blog">
        <div class="container blog-page">
            <div class="row">
                <div class="content col-xs-12 col-md-8">
                    <!-- Article Starts -->
                    <article>
                        <!-- Figure Starts -->
                        <figure class="blog-figure">
                            <img class="img-responsive" src="{{ storage('blogs/' . $news->image) }}" alt="">
                        </figure>
                        <div class="meta second-font">
                            <span><i class="fa fa-user"></i> <a href="#">admin</a></span>
                            <span class="date"><i class="fa fa-calendar"></i>
                                {{ date('d-M-Y', strtotime($news->created_at)) }} </span>
                            {{-- <span><i class="fa fa-commenting"></i> <a href="blog-post.html">18 comments</a></span>
                        <span><i class="fa fa-tags"></i> market, cryptocurrency, trading</span> --}}
                        </div>
                        <!-- Figure Ends -->
                        <!-- Content Starts -->
                        <p class="content-article">{!! html_entity_decode($news->description) !!} </p>
                        <!-- Content Ends -->
                        <!-- Meta Starts -->
                    </article>
                    <!-- Article Ends -->
                </div>
                <!-- Sidebar Starts -->
                <div class="sidebar col-xs-12 col-md-4">
                    <!-- Latest Posts Widget Ends -->
                    <div class="widget recent-posts">
                        <h3 class="widget-title">Recent Posts</h3>
                        <ul class="unstyled clearfix">
                            <!-- Recent Post Widget Starts -->

                            @foreach ($all_news as $news_recent)
                                <li>
                                    <div class="posts-thumb pull-left">
                                        <a href="{{ route('news.show', $news_recent) }}">
                                            <img alt="img" src="{{ storage('blogs/' . $news_recent->image) }}"">
                                        </a>
                                    </div>
                                    <div class="post-info">
                                        <h4 class="entry-title">
                                            <a
                                                href="{{ route('news.show', $news_recent) }}">{{ $news_recent->title }}</a>
                                        </h4>
                                        <p class="post-meta">
                                            <span class="post-date"><i class="fa fa-clock-o"></i>
                                                {{ date('d-M-Y', strtotime($news->created_at)) }} </span>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            @endforeach

                            <!-- Recent Post Widget Ends -->
                        </ul>
                    </div>

                </div>
                <!-- Sidebar Ends -->
            </div>
        </div>
    </section>
    <!-- Section Content Ends -->

    @push('scripts')
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush

</x-frontend.layouts.app>
