<x-frontend.layouts.app>
    @section('title', 'Existing Projects | Coin1m ')
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
							<h1>Existing Projects</h1>
						</div>
						<div class="breadcumb-content-text">
							<a href="index.php"> <span>home</span> Existing Projects</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--==================================================-->
	<!-- Start projects area -->
	<!--==================================================-->
	<div class="about-area style-one upper ">
		<div class="container">
			<div class="row about-btm">
				<div class="col-lg-6 col-md-6">
					<div class="single-about-box">
						<div class="about-thumb bounce-animate">
							<img src="{{asset('assets/frontend/images/eproject/ep1.jpg') }}" class='project-img'>
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
								<h1>Cryptocurrency Mining</h1>
							</div>
							<div class="section-text">
								<p>Basically, what happens throughout the process of cryptocurrency mining is producing
									new bitcoins. Cryptocurrency mining ensures that transactions are valid and added to
									the cryptocurrency blockchain correctly using a global network of computers running
									the cryptocurrency code. .</p>
							</div>
						</div>
						<!-- <div class="about-tmb">
							<i class="fas fa-check"></i>
							<div class="about-titles">
								<h4>Prioritize the features your customers need</h4>
							</div>
						</div> -->

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
								<h1>Stock Market Trading</h1>
							</div>
							<div class="section-text">
								<p>Basically, stock trading means any buying and selling of stock. There are a few
									differences in this investment model. Stock trading is relatively a shorter-term
									investment that is carried on by very active investors.


									It is almost impossible to trade in the stock market without proper study, guidance,
									and training. But, if anyone is really keen on investing in the stock market, we at
									SAFEST TRADES can do the hard work with the ultimate support of our expert team for
									stock market trading.

									At the same time, stock trading is a difficult and risky enterprise, but with proper
									education, it is possible to lower the risks behind it so that we can increase your
									likelihood of success.</p>
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
							<img src="{{asset('assets/frontend/images/eproject/ep2.jpg') }}" class='project-img'>
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
							<img src="{{asset('assets/frontend/images/eproject/ep3.jpg') }}" class='project-img'>
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
								<h1>Diamond Mining</h1>
							</div>
							<div class="section-text">
								<p>An estimated US$13 billion worth of rough diamonds are produced annually, of which
									approximately US$8.5 billion are from Africa (approximately 65%). The diamond
									industry employs about ten million people worldwide, both directly and indirectly,
									across a wide spectrum of roles from mining to retail.</p>
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
