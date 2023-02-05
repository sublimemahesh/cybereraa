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
                                            <h2 class="title-head">Get in <span>touch</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}" id='home'> home</a></li>
                                                <li>News</li>
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


    <!-- News Section Starts -->
    <section class="blog">
        <div class="container">
            <!-- Section Content Starts -->
            <div class="row latest-posts-content">

                @foreach ($all_news as $news)
                    <div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="latest-post">
                            <!-- Featured Image Starts -->
                            <a href="{{ route('news.show', $news) }}">
                                <img class="img-responsive" src="{{ storage('blogs/' . $news->image) }}"
                                    alt="{{ storage('blogs/' . $news->image) }}"></a>
                            <!-- Featured Image Ends -->
                            <!-- Article Content Starts -->
                            <div class="post-body">
                                <h4 class="post-title">
                                    <a href="{{ route('news.show', $news) }}">{{ $news->title }}</a>
                                </h4>
                                <div class="post-text">
                                    {{ $news->short_description }}
                                </div>
                            </div>
                            <div class="post-date">
                                <span>{{ date('d', strtotime($news->created_at)) }}</span>
                                <span>{{ date('M', strtotime($news->created_at)) }}</span>
                            </div>
                            <a href="{{ route('news.show', $news) }}" class="btn btn-primary">read more</a>
                            <!-- Article Content Ends -->
                        </div>
                    </div>
                @endforeach


                <!-- Article Ends -->
            </div>
            <!-- Section Content Ends -->
        </div>
    </section>
    <!-- News Section Ends -->

    @push('scripts')
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
