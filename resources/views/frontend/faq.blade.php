<x-frontend.layouts.app>
    @section('title', 'FAQ | Coin1m ')
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
				<div class="col-8">

					<div id='1'>
						<h3>FAQ SING UP AND SIGN IN</h3>
						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
								FAQ SING UP AND SIGN IN ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
								FAQ SING UP AND SIGN IN ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id='2'>
						<h3>FAQ BUY PACKAGES</h3> 

						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
									FAQ BUY PACKAGES ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
								FAQ BUY PACKAGES ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id='3'>
						<h3>FAQ INVITE MEMBERS</h3>

						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
								FAQ INVITE MEMBERS ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
						<div class="accordion">
							<div class="accordion-item">
								<div class="accordion-item-header">
								FAQ INVITE MEMBERS ?
								</div>
								<div class="accordion-item-body">
									<div class="accordion-item-body-content">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
										Ipsum has been the industry's standard dummy text ever since the 1500s, when an
										unknown printer took a galley of type and scrambled it to make a type specimen
										book. It has survived not only five centuries, but also the leap into electronic
										typesetting, remaining essentially unchanged. It was popularised in the 1960s
										with the release of Letraset sheets containing Lorem Ipsum passages, and more
										recently with desktop publishing software like Aldus PageMaker including
										versions of Lorem Ipsum.
									</div>
								</div>
							</div>
						</div>
					</div>



				</div>

				<div class="col-4">

					<ul class="list-group" id='faq-cat-holder'>
						<li class="list-group-item">
							<a href="#1">FAQ SING UP AND SIGN IN</a>
						</li>
						<li class="list-group-item">
							<a href="#2">FAQ BUY PACKAGES</a>
						</li>
						<li class="list-group-item">
							<a href="#3">FAQ INVITE MEMBERS</a>
						</li>
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
