<x-frontend.layouts.app>
    @section('title', 'FAQ | Cyber Eraa')
    @section('header-title', 'Welcome ')

    @section('header')
    @include('frontend.layouts.header')

    @section('styles')
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

	<link rel="stylesheet" href="{{asset('assets/frontend/css/faq.css') }}" type="text/css" media="all" />


    @endsection
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
							<h1>FAQ</h1>
						</div>
						<div class="breadcumb-content-text">
							<a href="index.php"> <span>home</span>FAQ</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--==================================================-->
	<!--FAQ -->
	<!--==================================================-->

	<div class=" feature-area style-one upper faq">
		<div class='container'>
			<div class="row">
				<div class="col-sm-12 col-md-8">
                    @foreach ($faqs as $key => $faq)

                    <div id='{{ $key }}'>

						<h3 class='faq-section-head-txt'>{{ $faq->title }}</h3>
                        @foreach ($faq->children as $key1 => $child)
                        <div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
                                    <h4 class='faq-list-head-txt'> {{ $child->title }}</h4>
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										{!! html_entity_decode($child->content) !!}
									</div>
								</div>
							</div>
						</div>

                        @endforeach

					</div>

                    @endforeach

				</div>

				<div class="col-md-4" data-dxs="dis:none">

					<ul class="list-group" id='faq-cat-holder'>

                        @foreach ($faqs as $key => $faq)
                        <li class="list-group-item">
							<a href="#{{ $key }}">{{ $faq->title }}</a>
						</li>
                        @endforeach
					</ul>

				</div>
			</div>

		</div>
	</div>


<!-- CONTENT END -->



@section('scripts')
<script src="{{ asset('assets/frontend/js/faq.js') }}"></script>
@endsection


</x-frontend.layouts.app>
