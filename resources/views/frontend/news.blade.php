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
                            <h2 class="title-head">Get in <span>touch</span></h2>
                            <!-- Title Ends -->
                            <hr>
                            <!-- Breadcrumb Starts -->
                            <ul class="breadcrumb">
                                <li><a href="{{ route('/') }}"> home</a></li>
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
    <!-- Banner Area Ends -->

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
                            <img class="img-responsive" src="{{ storage('blogs/' . $news->image) }}" alt="{{ storage('blogs/' . $news->image) }}"></a>
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
        {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}
    @endpush
</x-frontend.layouts.app>
