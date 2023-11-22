 <x-frontend.layouts.app>
     @section('title', 'Upcoming Project | Coin1m ')
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
							<h1>Upcoming Projects</h1>
						</div>
						<div class="breadcumb-content-text">
							<a href="index.php"> <span>home</span>Upcoming Projects</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--==================================================-->
	<!-- Start projects area -->
	<!--==================================================-->
	<div class="about-area style-one upper">
		<div class="container">
			<div class="row about-btm">
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="about-thumb bounce-animate">
							<img src="{{asset('assets/frontend/images/eproject/op3.jpg') }}" class='project-img'>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="section-title">
							<div class="sub-title">
								<h3>Projects</h3>
							</div>
							<div class="main-title">
								<h1>Information Technology Solutions</h1>
							</div>
							<div class="section-text">
								<p>We plan to invest in innovative IT-related project development in the future. Moreover, we hope to develop trading bots for various purposes in the future.</p>
							</div>
						</div>
					
						<div class="about-button upper">
							<a href="{{ route('contact') }}">contact us</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="about-area style-one upper">
		<div class="container">
			<div class="row about-btm">
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="section-title">
							<div class="sub-title">
								<h3>Projects</h3>
							</div>
							<div class="main-title">
								<h1>Hospitality Industry</h1>
							</div>
							<div class="section-text">
								<p>With the expansion of the network, we plan to develop a hotel and accommodation booking system using a blockchain framework that can be utilized globally. What happens in such a booking system is that anyone who uses cryptocurrency gets teh opportunity to travel across the globe by making crypto payments for accommodations and hotels. The users can make any payment directly from their crypto wallet in the currency of their preference.</p>
							</div>
						</div>
					
						<div class="about-button upper">
							<a href="{{ route('contact') }}">contact us</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="about-thumb bounce-animate">
							<img src="{{asset('assets/frontend/images/eproject/op2.jpg') }}" class='project-img'>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="about-area style-one upper">
		<div class="container">
			<div class="row about-btm">
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="about-thumb bounce-animate">
							<img src="{{asset('assets/frontend/images/eproject/op1.jpg') }}" class='project-img'>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="section-title">
							<div class="sub-title">
								<h3>Projects</h3>
							</div>
							<div class="main-title">
								<h1>Real Estates</h1>
							</div>
							<div class="section-text">
								<p>We have the plan to make investments in the real estate sector in the future. There, we expect to buy and sell lands, residential properties, commercial properties, and industrial properties in order to increase profits via an appreciation in the value of the real estate.</p>
							</div>
						</div>

						<div class="about-button upper">
							<a href="{{ route('contact') }}">contact us</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<!-- CONTENT END -->





 </x-frontend.layouts.app>
