<x-frontend.layouts.app>
    @section('title', 'How it work')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/frontend/css/hiw.css') }}" rel="stylesheet">
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>

        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    @endsection


    <!-- Banner Area Starts -->
    <section style="backg" class="banner-area">
        <div class="banner-overlay">
            <div class="banner-text text-center">
                <div class="container">
                    <!-- Section Title Starts -->
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <!-- Title Starts -->
                            <h2 class="title-head">HOw <span>it work</span></h2>
                            <!-- Title Ends -->
                            <hr>
                            <!-- Breadcrumb Starts -->
                            <ul class="breadcrumb">
                                <li><a href="index-2.html"> home</a></li>
                                <li>How to it work</li>
                            </ul>
                            <!-- Breadcrumb Ends -->
                        </div>
                    </div>
                    <!-- Section Title Ends -->
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area end -->

    <section id="hiw">
        <div class="container">
            <div class="col-xs-12 col-sm-2">
                <ul id="nav-serialscrolling" class="faq-cat-holder">
                    @foreach ($how_it_works as $key => $htiw)
                        @if (count($how_it_works) > $key + 1)
                            <li><span class="sub-link"
                                    data-serialscrolling="{{ $key }}"><span>{{ $htiw->title }}</span><i
                                        class="fas fa-arrow-right  rigth-arrow"></i></span><i
                                    class='fas fa-arrow-down ul-count'></i></li>
                        @else
                            <li><span class="sub-link"
                                    data-serialscrolling="{{ $key }}"><span>{{ $htiw->title }}</span></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-12 col-sm-10">
                @foreach ($how_it_works as $key => $htiw)
                    <div data-serialscrolling-target="{{ $key }}" class='frist-div'>
                        <h1>{{ $htiw->title }}</h1>

                        <div>
                            {!! html_entity_decode($htiw->content) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </section>






    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/frontend/js/jquery.serialscrolling.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/hiw.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
