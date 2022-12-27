<x-frontend.layouts.app>
    @section('title', 'News')
    @section('header-title', 'Welcome ')
    @section('styles')
    @endsection


    <section class="banner-area">
        <div class="banner-overlay">
            <div class="banner-text text-center">
                <div class="container">
                    <!-- Section Title Starts -->
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <!-- Title Starts -->
                            <h2 class="title-head  title-head-news">{{ $news->title }}</h2>
                            <!-- Title Ends -->
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
    <!-- Banner Area Ends -->

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
        {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}
    @endpush
</x-frontend.layouts.app>