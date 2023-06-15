<x-frontend.layouts.app>
    @section('title', 'Existing Projects | Owara3m')
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
                    <h1 class="text-white">Existing projects</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- BREADCRUMB ROW -->
        <div class="bg-black p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li>Existing projects</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->



        <!-- SECTION CONTENT -->
        <div class="section-full">

            @foreach ($projects as $key => $project)
            @if ($key % 2 == 0)

            <div class="row bg-black-light p-t80 p-b50">
                <div class="container">
                    <div class="col-md-7 col-sm-7">
                        <div class="wt-info  p-b30 mob-p-b20">
                            <h1 class="m-a0">{{ $project->title }}</h1>
                        </div>
                        <div class="mob-p-b30">
                            <h5>
                                {!! html_entity_decode($project->content) !!}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <!-- Card (Horizontal Flip) -->
                        <div class="flip-container mob-mb-10">
                            <div class="wt-box ">
                                <div class="wt-thum-bx">
                                    <img src="{{ storage('pages/' . $project->image) }}" alt="">
                                </div>
                                <div class="wt-info bg-black text-center p-a20">
                                    <h3 class="text-uppercase">{{ $project->title }}</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row bg-black p-t80 p-b50">
                <div class="container">
                    <div class="col-md-5 col-sm-5">
                        <!-- Card (Horizontal Flip) -->
                        <div class="flip-container mob-mb-10">
                            <div class="wt-box ">
                                <div class="wt-thum-bx">
                                    <img src="{{ storage('pages/' . $project->image) }}" alt="">
                                </div>
                                <div class="wt-info bg-black-light text-center p-a20">
                                    <h3 class="text-uppercase">{{ $project->title }}</h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 col-sm-7">
                        <div class="wt-info  p-b30 mob-ptb-20">
                            <h1 class="m-a0">{{ $project->title }}</h1>
                        </div>
                        <div>
                            <h5>
                                {!! html_entity_decode($project->content) !!}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @endif
            @endforeach

        </div>
        <!-- SECTION CONTENT END -->
    </div>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
