 <x-frontend.layouts.app>
     @section('title', 'FAQ')
     @section('header-title', 'Welcome ')
     @section('styles')
         <link href="{{ asset('assets/frontend/css/faq.css') }}" rel="stylesheet">

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
                             <h2 class="title-head">F<span>AQ</span></h2>
                             <!-- Title Ends -->
                             <hr>
                             <!-- Breadcrumb Starts -->
                             <ul class="breadcrumb">
                                 <li><a href="index-2.html"> home</a></li>
                                 <li>FAQ</li>
                             </ul>
                             <!-- Breadcrumb Ends -->
                         </div>
                     </div>
                     <!-- Section Title Ends -->
                 </div>
             </div>
         </div>
     </section>
     <!-- facts Section Start -->


     <section id='faq'>
         <div class='container'>
             <div class="cd-faq js-cd-faq container2   max-width-md margin-top-lg margin-bottom-lg ">
                 <div class="cd-faq__categories">
                     <ul id="faq-cat-holder">
                         <li><a class="cd-faq__category cd-faq__category-selected truncate" href="#7">Sing Up And
                                 Sign In</a>
                         </li>
                         <li><a class="cd-faq__category truncate" href="#8">Kyc Approval</a></li>
                         <li><a class="cd-faq__category truncate" href="#9">Buy Packages</a></li>
                         <li><a class="cd-faq__category truncate" href="#10">Invite Members</a></li>
                         <li><a class="cd-faq__category truncate" href="#11">Withdraw Money</a></li>

                     </ul> <!-- cd-faq__categories -->

                 </div>
                 <div class="cd-faq__items">
                     <ul id="7" class="cd-faq__group">
                         <li class="cd-faq__title">
                             <h2>Sing Up And Sign In</h2>
                         </li>
                         @foreach ($faqs as $faq)
                             @if ($faq->parent_id == 7)
                                 <li class="cd-faq__item">
                                     <a class="cd-faq__trigger" href="#0"><span>{{ $faq->title }}</span></a>
                                     <div class="cd-faq__content">
                                         <div class="text-component">
                                             {!! html_entity_decode($faq->content) !!}
                                         </div>
                                     </div> <!-- cd-faq__content -->
                                 </li>
                             @endif
                         @endforeach
                     </ul>
                     <!-- cd-faq__group -->
                     <ul id="8" class="cd-faq__group">
                         <li class="cd-faq__title">
                             <h2>Kyc Approval</h2>
                         </li>
                         @foreach ($faqs as $faq)
                             @if ($faq->parent_id == 8)
                                 <li class="cd-faq__item">
                                     <a class="cd-faq__trigger" href="#0"><span>{{ $faq->title }}</span></a>
                                     <div class="cd-faq__content">
                                         <div class="text-component">
                                             {!! html_entity_decode($faq->content) !!}
                                         </div>
                                     </div> <!-- cd-faq__content -->
                                 </li>
                             @endif
                         @endforeach
                     </ul>
                     <!-- cd-faq__group -->
                     <ul id="9" class="cd-faq__group">
                         <li class="cd-faq__title">
                             <h2>Buy Packages</h2>
                         </li>
                         @foreach ($faqs as $faq)
                             @if ($faq->parent_id == 9)
                                 <li class="cd-faq__item">
                                     <a class="cd-faq__trigger" href="#0"><span>{{ $faq->title }}</span></a>
                                     <div class="cd-faq__content">
                                         <div class="text-component">
                                             {!! html_entity_decode($faq->content) !!}
                                         </div>
                                     </div> <!-- cd-faq__content -->
                                 </li>
                             @endif
                         @endforeach
                     </ul>
                     <!-- cd-faq__group -->
                     <ul id="10" class="cd-faq__group">
                         <li class="cd-faq__title">
                             <h2>Invite Members</h2>
                         </li>
                         @foreach ($faqs as $faq)
                             @if ($faq->parent_id == 10)
                                 <li class="cd-faq__item">
                                     <a class="cd-faq__trigger" href="#0"><span>{{ $faq->title }}</span></a>
                                     <div class="cd-faq__content">
                                         <div class="text-component">
                                             {!! html_entity_decode($faq->content) !!}
                                         </div>
                                     </div> <!-- cd-faq__content -->
                                 </li>
                             @endif
                         @endforeach
                     </ul>
                     <!-- cd-faq__group -->

                     <ul id="11" class="cd-faq__group">
                         <li class="cd-faq__title">
                             <h2>Withdraw Money</h2>
                         </li>
                         @foreach ($faqs as $faq)
                             @if ($faq->parent_id == 11)
                                 <li class="cd-faq__item">
                                     <a class="cd-faq__trigger" href="#0"><span>{{ $faq->title }}</span></a>
                                     <div class="cd-faq__content">
                                         <div class="text-component">
                                             {!! html_entity_decode($faq->content) !!}
                                         </div>
                                     </div> <!-- cd-faq__content -->
                                 </li>
                             @endif
                         @endforeach
                     </ul>
                     <!-- cd-faq__group -->
                 </div>
                 <!-- cd-faq__items -->
                 <a href="#0" class="cd-faq__close-panel text-replace">Close</a>
                 <div class="cd-faq__overlay" aria-hidden="true"></div>
             </div>
         </div>
     </section>









     @push('scripts')
         <script src="{{ asset('assets/frontend/js/faq.js') }}"></script>
         <script src="{{ asset('assets/frontend/js/util.js') }}"></script>
     @endpush
 </x-frontend.layouts.app>
