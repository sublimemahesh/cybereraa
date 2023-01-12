<x-frontend.layouts.app>
    @section('title', 'How it work')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/frontend/css/hiw.css') }}" rel="stylesheet">
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>

        {{-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> --}}
        {{-- <script src=' https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js' crossorigin='anonymous'></script> --}}


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
                                            <h2 class="title-head">How It <span>Works</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}"> home</a></li>
                                                <li>How It Works</li>
                                            </ul>
                                            <!-- Breadcrumb Ends -->
                                        </div>
                                    </div>
                                    <!-- Section Title Ends -->
                                </div>
                                <div class="header-logo-img">
                                    <img class='shimmer' src="{{ asset('assets/frontend/images/project/header_icon_img.png') }}" alt=""></div>
                                </div> 
                            </div>
                        </div>
                    </section>
                </div>
        </section>
    </div>


    <div class="container">
        <hr data-serialscrolling-target="0" class="hr-1" />
        <section id="hiw">
            <div class="col-xs-12 col-sm-3">
                <ul id="nav-serialscrolling" class="faq-cat-holder">
                    @foreach ($how_it_works as $key => $htiw)
                        @if (count($how_it_works) > $key + 1)
                            <li>
                                <span class="sub-link" data-serialscrolling="{{ $key }}">
                                    <span class='htext'>{{ $htiw->title }}</span>
                                    <i class="fa fa-arrow-right  rigth-arrow"></i>
                                </span>
                                <i class='fa fa-arrow-down ul-count' aria-hidden="true"></i>
                            </li>
                        @else
                            <li>
                                <span class="sub-link" data-serialscrolling="{{ $key }}">
                                    <span class='htext'> {{ $htiw->title }}</span>
                                    <i class="fa fa-arrow-right  rigth-arrow" id='lasat-arrow'></i>
                                </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-12 col-sm-9">
                @foreach ($how_it_works as $key => $htiw)
                    <div class='frist-div'>
                        <h1>{{ $htiw->title }}</h1>
                        <div>
                            @if (!empty($htiw->image))
                            <img src="{{ asset('storage/pages/'.$htiw->image) }}" class="hiw-img" alt="{{ $htiw->title }}">
                            @endif
                            {!! html_entity_decode($htiw->content) !!}
                        </div>
                        @php
                            $scroll = $key + 1;
                        @endphp
                    </div>
                    <hr data-serialscrolling-target="{{ $scroll }}" />
                @endforeach
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/frontend/js/jquery.serialscrolling.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/hiw.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
