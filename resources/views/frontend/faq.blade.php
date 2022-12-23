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


     @foreach ($faqs->children as $section)
        {!! $section->content !!}
    @endforeach





     {{-- <section>
         <div class='faq'>
             <input id='faq-a' type='checkbox'>
             <label for='faq-a'>
                 <p class="faq-heading">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae?</p>
                 <div class='faq-arrow'></div>
                 <p class="faq-text">Lorem ipsum dolor sit amet.
                     Est atque voluptate eum molestiae explicabo eos natus neque est quia accusantium vel nihil sequi
                     qui
                     animi magni ut rerum vitae.
                     Id optio ducimus et voluptatem minus et adipisci quasi sit officia sunt..</p>
             </label>
             <input id='faq-b' type='checkbox'>
             <label for='faq-b'>
                 <p class="faq-heading">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae?</p>
                 <div class='faq-arrow'></div>
                 <p class="faq-text">Lorem ipsum dolor sit amet.
                     Est atque voluptate eum molestiae explicabo eos natus neque est quia accusantium vel nihil sequi
                     qui
                     animi magni ut rerum vitae.
                     Id optio ducimus et voluptatem minus et adipisci quasi sit officia sunt..</p>
             </label>
             <input id='faq-c' type='checkbox'>
             <label for='faq-c'>
                 <p class="faq-heading">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae?</p>
                 <div class='faq-arrow'></div>
                 <p class="faq-text">Lorem ipsum dolor sit amet.
                     Est atque voluptate eum molestiae explicabo eos natus neque est quia accusantium vel nihil sequi
                     qui
                     animi magni ut rerum vitae.
                     Id optio ducimus et voluptatem minus et adipisci quasi sit officia sunt..</p>
             </label>
             <input id='faq-d' type='checkbox'>
             <label for='faq-d'>
                 <p class="faq-heading">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae?</p>
                 <div class='faq-arrow'></div>
                 <p class="faq-text">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae
                     explicabo eos natus neque est quia accusantium vel nihil sequi qui animi magni ut rerum vitae.
                     Id optio ducimus et voluptatem minus et adipisci quasi sit officia sunt..
                 </p>
             </label>
             <input id='faq-e' type='checkbox'>
             <label for='faq-e'>
                 <p class="faq-heading">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae?</p>
                 <div class='faq-arrow'></div>
                 <p class="faq-text">Lorem ipsum dolor sit amet. Est atque voluptate eum molestiae
                     explicabo eos natus neque est quia accusantium vel nihil sequi qui animi magni ut rerum vitae.
                     Id optio ducimus et voluptatem minus et adipisci quasi sit officia sunt.</p>
             </label>
         </div>
         <!-- Container Ends -->
     </section> --}}
   

     @push('scripts')
         {{-- <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script> --}}
     @endpush
 </x-frontend.layouts.app>
