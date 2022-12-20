 
 
<x-frontend.layouts.app>
    @section('title', 'project')
    @section('header-title', 'Welcome ')
    @section('styles')

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive-circle-image-slide.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">



    @endsection




 <!-- Banner Area Starts -->
 <section class="banner-area">
     <div class="banner-overlay">
         <div class="banner-text text-center">
             <div class="container">
                 <!-- Section Title Starts -->
                 <div class="row text-center">
                     <div class="col-xs-12">
                         <!-- Title Starts -->
                         <h2 class="title-head">Our <span>Projects</span></h2>
                         <!-- Title Ends -->
                         <hr>
                         <!-- Breadcrumb Starts -->
                         <ul class="breadcrumb">
                             <li><a href="index-2.html"> home</a></li>
                             <li>Projects</li>
                         </ul>
                         <!-- Breadcrumb Ends -->
                     </div>
                 </div>
                 <!-- Section Title Ends -->
             </div>
         </div>
     </div>
 </section>
 <!-- Banner Area Starts -->
 <!-- About Section Starts -->

 <section class="about-page">
     <div class="container">
         <!-- Section Content Starts -->
         <div class="row about-content">
             <!-- Image Starts -->
             <div class="col-sm-12 col-md-5 col-lg-7 text-center ">
                 <div class="slide-container">
                     <div class="slide" data-slide-no="1"></div>
                     <div class="slide" data-slide-no="2"></div>
                     <div class="slide" data-slide-no="3"></div>
                     <div class="slide" data-slide-no="4"></div>
                     <div class="slide" data-slide-no="5"></div>
                     <div class="slide" data-slide-no="6"></div>
                     <div class="slide" data-slide-no="7"></div>
                     <div class="slide" data-slide-no="8"></div>
                     <div class="slide" data-slide-no="9"></div>
                     <div class="slide" data-slide-no="10"></div>
                     <div class="slide" data-slide-no="11"></div>
                     <div class="slide" data-slide-no="12"></div>
                 </div>
             </div>
             <!-- Image Ends -->
             <!-- Content Starts -->
             <div class="col-sm-12 col-md-7 col-lg-5 set-margine">
                 <div class="feature-about">
                     <h3 class="title-about">Green Energy Projects</h3>
                     <p>Photovoltaic (PV) panels, often known as solar panels, or other methods of gathering solar
                         energy, such as concentrating solar systems, are used to harvest the power of the sun in
                         solar farms, which are large–scale solar installations. They differ in a number of
                         significant ways from rooftop solar systems and even commercial solar power systems.</p>
                 </div>
                 <div class="feature-about">
                     <h3 class="title-about">Real Estate & Cultivation Project</h3>
                     <p>Real estate transactions take a lot of effort and time. You will have to deal with all the
                         parties in addition to the different procedures to sell the property. Finding the home of
                         your dreams with a reliable estate agent is quicker and easier because the process is
                         practically the same as when buying.</p>
                 </div>
                 <a class="btn btn-primary btn-services" href="services.html">Our services</a>
             </div>
             <!-- Content Ends -->

         </div>
         <!-- Section Content Ends -->
     </div>
     <!--/ Content row end -->
 </section>

 <section class="about-page">
     <div class="container">
         <!-- Section Content Starts -->
         <div class="row about-content">

             <!-- Content Starts -->
             <div class="col-sm-12 col-md-7 col-lg-5 set-margine">
                 <div class="feature-about">
                     <h3 class="title-about">Hospitality Project</h3>
                     <p>The hospitality industry is a broad category of fields within the service industry that
                         includes lodging, food and drink service, event planning, theme parks, travel and tourism.
                         It includes hotels, tourism agencies, restaurants and bar.</p>
                 </div>
                 <div class="feature-about">
                     <h3 class="title-about">Transportation Project</h3>
                     <p>It is your duty to make informed, intelligent purchasing decisions. A key choice is making a
                         vehicle purchase. Take your time while choosing a vehicle and be knowledgeable about it.
                         Before approaching a dealer or individual seller, be sure you are well–informed and
                         confident in your choice.</p>
                 </div>
                 <a class="btn btn-primary btn-services" href="services.html">Our services</a>
             </div>
             <!-- Content Ends -->

             <!-- Image Starts -->
             <div class="col-sm-12 col-md-5 col-lg-7 text-center">
                 <div class="slide-container2">
                     <div class="slide2" data-slide-no="13"></div>
                     <div class="slide2" data-slide-no="14"></div>
                     <div class="slide2" data-slide-no="15"></div>
                     <div class="slide2" data-slide-no="16"></div>
                     <div class="slide2" data-slide-no="17"></div>
                     <div class="slide2" data-slide-no="18"></div>
                     <div class="slide2" data-slide-no="19"></div>
                     <div class="slide2" data-slide-no="20"></div>
                     <div class="slide2" data-slide-no="21"></div>
                     <div class="slide2" data-slide-no="22"></div>
                     <div class="slide2" data-slide-no="23"></div>
                     <div class="slide2" data-slide-no="24"></div>
                 </div>
             </div>
             <!-- Image Ends -->

         </div>
         <!-- Section Content Ends -->
     </div>
     <!--/ Content row end -->
 </section>

 <!-- About Section Ends -->

 @push('scripts')

 <script src="{{ asset('assets/frontend/js/responsive-circle-image-slide.js') }}"></script>

@endpush
</x-frontend.layouts.app>
