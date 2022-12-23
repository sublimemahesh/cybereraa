 
 <x-frontend.layouts.app>
    @section('title', 'Package')
    @section('header-title', 'Welcome ')
    @section('styles')

    <link href="{{asset('assets/frontend/css/pricing.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    
   


    @endsection
 
 
 
 <!-- Banner Area Starts -->
 <section class="banner-area pricing-hero">
     <div class="banner-overlay">
         <div class="banner-text text-center">
             <div class="container">
                 <!-- Section Title Starts -->
                 <div class="row text-center">
                     <div class="col-xs-12">
                         <!-- Title Starts -->
                         <h2 class="title-head">Our <span> Packages</span></h2>
                         <!-- Title Ends -->
                         <hr>
                         <!-- Breadcrumb Starts -->
                         <ul class="breadcrumb">
                             <li><a href="index-2.html" id='home'> home</a></li>
                             <li>Packages</li>
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


 @foreach ($packages->children as $section)
{!! $section->content !!}
{{-- {!!html_entity_decode($section)!!} --}}
@endforeach


 {{-- <section class="pricing-section">
     <div class="container">
         <div class="outer-box">
             <div class="row">

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-paper-plane"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Lite Package</div>
                             <h4 class="price">$100</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">20 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-paper-plane"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Lite Package</div>
                             <h4 class="price">$250</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">50 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-paper-plane"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Lite Package</div>
                             <h4 class="price">$500</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">100 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-paper-plane"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Lite Package</div>
                             <h4 class="price">$1000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">200 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-rocket"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Boost Package</div>
                             <h4 class="price">$2500</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">500 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-rocket"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title">Boost Package</div>
                             <h4 class="price">$5000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">1000 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-rocket"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title">Boost Package</div>
                             <h4 class="price">$10000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">2000 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-rocket"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title">Boost Package</div>
                             <h4 class="price">$25000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">5000 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-gem"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Top Package</div>
                             <h4 class="price">$50000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">10000 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>

                 <!-- Pricing Block -->
                 <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                     <div class="inner-box">
                         <div class="icon-box">
                             <div class="icon-outer"><i class="fas fa-gem"></i></div>
                         </div>
                         <div class="price-box">
                             <div class="title"> Top Package</div>
                             <h4 class="price">$100000</h4>
                         </div>
                         <br>
                         <br>
                         <ul class="features">
                             <li class="true">Duration 15 Month</li>
                             <li class="true">Up to 1% Leverage</li>
                             <li class="true">20000 By Points</li>
                         </ul>
                         <div class="btn-box">
                             <a href="#" class="theme-btn">BUY plan</a>
                         </div>
                     </div>
                 </div>



             </div>
         </div>
     </div>
 </section> --}}

 @push('scripts')
 <script src="{{ asset('assets/frontend/js/testimonials.js') }}"></script>

@endpush
</x-frontend.layouts.app>