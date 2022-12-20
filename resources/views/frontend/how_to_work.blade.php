  
  <x-frontend.layouts.app>
    @section('title', 'how it work')
    @section('header-title', 'Welcome ')
    @section('styles')

    <link href="{{asset('assets/frontend/css/hiw.css')}}" rel="stylesheet">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>


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

  <!-- hiw Section Starts -->
  <section id='hiw'>
      <ul class="infoGraphic">
          <li>
              <div class="numberWrap">
                  <div class="number fontColor1">1</div>
                  <div class="coverWrap">
                      <div class="numberCover"></div>
                  </div>
              </div>
              <div class="content">
                  <div class="icon iconCodepen"></div>
                  <h2>Develop</h2>
                  <p>Sagittis, audantium sem eveniet lacus pede porttitor aenean.</p>
              </div>
          </li>
          <li>
              <div class="numberWrap">
                  <div class="number fontColor2">2</div>
                  <div class="coverWrap">
                      <div class="numberCover"></div>
                  </div>
              </div>
              <div class="content">
                  <div class="icon iconSocial"></div>
                  <h2>Engage</h2>
                  <p>Sagittis, audantium sem eveniet lacus pede porttitor aenean.</p>
              </div>
          </li>
          <li>
              <div class="numberWrap">
                  <div class="number  fontColor3">3</div>
                  <div class="coverWrap">
                      <div class="numberCover"></div>
                  </div>
              </div>
              <div class="content">
                  <div class="icon iconAirplane"></div>
                  <h2>Deliver</h2>
                  <p>Sagittis, audantium sem eveniet lacus pede porttitor aenean.</p>
              </div>
          </li>
          <li>
              <div class="numberWrap">
                  <div class="number  fontColor4">4</div>
                  <div class="coverWrap">
                      <div class="numberCover"></div>
                  </div>
              </div>
              <div class="content">
                  <div class="icon iconMap"></div>
                  <h2>Plan</h2>
                  <p>Sagittis, audantium sem eveniet lacus pede porttitor aenean.</p>
              </div>
          </li>

      </ul>

  </section>
  <!-- hiw Section Ends -->

  @push('scripts')

  <script src="{{ asset('assets/frontend/js/hiw.js') }}"></script>

@endpush
</x-frontend.layouts.app>