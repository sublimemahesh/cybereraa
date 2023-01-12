 <x-frontend.layouts.app>
     @section('title', 'Upcoming Project')
     @section('header-title', 'Welcome ')
     @section('styles')

         <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive-circle-image-slide.css') }}">

     @endsection

     <!-- Banner Area Starts -->
     
     {{-- <section class="banner-area">
         <div class="banner-overlay">
             <div class="banner-text text-center">
                 <div class="container">
                     <!-- Section Title Starts -->
                     <div class="row text-center">
                         <div class="col-xs-12">
                             <!-- Title Starts -->
                             <h2 class="title-head">Upcoming <span> Projects</span></h2>
                             <!-- Title Ends -->
                             <hr>
                             <!-- Breadcrumb Starts -->
                             <ul class="breadcrumb">
                                 <li><a href="index-2.html"> home</a></li>
                                 <li>Upcoming Projects</li>
                             </ul>
                             <!-- Breadcrumb Ends -->
                         </div>
                     </div>
                     <!-- Section Title Ends -->
                 </div>
             </div>
         </div>
     </section> --}}

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
                                            <h2 class="title-head">Upcoming <span> Projects</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li><a href="{{ route('/') }}"> home</a></li>
                                                <li>Upcoming Projects</li>
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





     {{-- /////////////////////  project ///////////////////////////// --}}

     <div id="project">
         @foreach ($projects as $key => $project)
             @if ($key % 2 == 0)
                 <section>
                     <div class="container">
                         <!-- 1 st proect Section Content Starts -->
                         <div class="row about-content">
                             <!-- Image Starts -->
                             <div class="col-sm-12 col-md-5 col-lg-6 text-center">
                                 <img id="about-us" class="img-responsive img-about-us"
                                     src="{{ storage('pages/' . $project->image) }}"
                                     alt="{{ storage('pages/' . $project->image) }}">
                             </div>
                             <!-- Image Ends -->
                             <!-- Content Starts -->
                             <div class="col-sm-12 col-md-7 col-lg-6">
                                 <div class="feature-about">
                                     <h3 class="title-about">{{ $project->title }}</h3>
                                     {!! html_entity_decode($project->content) !!}
                                 </div>
                             </div>
                             <!-- Content Ends -->
                         </div>
                         <!-- 1st Section Content Ends -->
                     </div>
                     <!--/ Content row end -->
                 </section>
             @else
                 <section class="about-css">
                     <div class="container">
                         <!-- 2nd proect Section Content Starts -->
                         <div class="row about-content">

                             <!-- Content Starts -->
                             <div class="col-sm-12 col-md-7 col-lg-6">
                                 <div class="feature-about">
                                     <h3 class="title-about">{{ $project->title }}</h3>
                                     {!! html_entity_decode($project->content) !!}
                                 </div>
                             </div>
                             <!-- Content Ends -->

                             <!-- Image Starts -->
                             <div class="col-sm-12 col-md-5 col-lg-6 text-center">
                                 <img id="about-us" class="img-responsive img-about-us"
                                     src="{{ storage('pages/' . $project->image) }}"
                                     alt="{{ storage('pages/' . $project->image) }}">
                             </div>
                             <!-- Image Ends -->

                         </div>
                         <!--  Section Content Ends -->
                     </div>
                     <!--/ Content row end -->
                 </section>
             @endif
         @endforeach
     </div>

     @push('scripts')
     <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
     @endpush
 </x-frontend.layouts.app>
