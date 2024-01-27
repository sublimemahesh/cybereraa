<x-frontend.layouts.app>
    @section('title', 'How it work | Cyber eraa ')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header')

<!-- CONTENT START -->



	<!--==================================================-->
	<!-- Start breadcumb-area -->
	<!--==================================================-->
	<div class="breadcumb-area style-nine d-flex align-items-center" style="background: url('{{ asset('assets/frontend/images/inner-bg.jpg') }}');background-size: cover;background-position: center;background-repeat: no-repeat;">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breacumb-content">
						<div class="breadcumb-title">
							<h1>How It Work</h1>
						</div>
						<div class="breadcumb-content-text">
							<a href="index.php"> <span>home</span>How It Work</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!--==================================================-->
<!--How it work -->
<!--==================================================-->

    <div class="feature-area style-one upper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sections-title">
                        <div class="sub-title">
                            <h3>Steps</h3>
                        </div>
                        <div class="main-title">
                            <h1>Three steps Cyber eraa</h1>
                        </div>
                        <div class="section-text">
                            {{-- <p></p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bottom">

                @foreach ($how_it_work as $key => $section)
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                           <span class='how-it-no'>{{ $key + 1 }}</span>
                        </div>
                        <div class="feature-title">
                            <h3>{{ $section->title }}</h3>
                            <p>{!! html_entity_decode($section->content) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>








<!-- CONTENT END -->




    @push('scripts')

    @endpush
</x-frontend.layouts.app>
