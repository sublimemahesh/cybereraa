<x-frontend.layouts.app>
    @section('title', 'How it work | Coin1m ')
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
                            <h1>Three steps Coin1m</h1>
                        </div>
                        <div class="section-text">
                            <p>Cryptocurrencies are used primarily outside existing banking and coin
                                governmental institutions and are exchanged</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box"> 
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/lock.png') }}" alt>
                        </div>
                        <div class="feature-title">
                            <h3>SING UP AND SIGN IN</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces.
                                Synergisticall sustainable infomediaries via </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/tags.png') }}" alt>
                        </div>
                        <div class="feature-title">
                            <h3>BUY INVESTMENT PACKAGES</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces.
                                Synergisticall sustainable infomediaries via </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature-box">
                        <div class="feature-thumb">
                            <img src="{{asset('assets/frontend/images/money.png') }}" alt>
                        </div>
                        <div class="feature-title">
                            <h3>WITHDRAW MONEY</h3>
                            <p>Professionally engineer customized sce vis innovative interfaces.
                                Synergisticall sustainable infomediaries via </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








<!-- CONTENT END -->




    @push('scripts')

    @endpush
</x-frontend.layouts.app>
