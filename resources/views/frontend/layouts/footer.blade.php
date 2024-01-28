<!--==================================================-->
<!-- Start footer-area -->
<!--==================================================-->
<div class="footer-area">
	<div class="container">
		<div class="row tops">
			<div class="col-lg-3 col-md-6">
				<div class="single-footer-box">
					<div class="footer-logo">
						<img src="{{asset('assets/frontend/images/footer-logo.png') }}" alt="">
					</div>
					<div class="footer-content">
						{{-- <div class="footer-title">
							<p>11Cryptocurrencies are used prim outside existing banking govern institutions hanged</p>
						</div> --}}
						<div class="footer-icon">
							<ul>
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-pinterest"></i></a></li>
								<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="single-footer-box">
					<div class="footer-content">
						<div class="footer-title">
							<h2>Useful Links</h2>
						</div>
						<div class="footer-ico">
							<ul>
								<li><a href="{{ route('/') }}"><span>Home</span></a></li>
								<li><a href="{{ route('about') }}"><span>About</span></a></li>
								<li><a href="{{ route('contact') }}"><span>Contact</span></a></li>
								<li><a href="{{ route('pricing') }}"><span>Packages</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="single-footer-box">
					<div class="footer-content">
						<div class="footer-title">
							<h2>Useful Links</h2>
						</div>
						<div class="footer-ico">
							<ul>
								<li><a href="{{ route('project') }}"><span>Existing Projects</span></a></li>
								<li><a href="{{ route('Upcoming-project') }}"><span>Upcoming Projects</span></a></li>
								<li><a href="{{ route('faq') }}"><span>FAQ</span></a></li>
								{{-- 	<li><a href="#"><span>Return Policy</span></a></li> --}}
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="single-footer-box">
					<div class="footer-content">
						<div class="footer-titles">
							<h2>Contact details</h2>
							{{-- <p>support@cybereraa.com</p>  --}}
							<a data-devil='c:#fff' href="mailto:support@cybereraa.com">support@cybereraa.com</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row footer-bottom">
			<div class="col-lg-6 col-md-6">
				<div class="copy-left-box">
					<div class="copy-left-title">
						<h3>Copyright © 2023 Cyber Eraa. All Rights Reserved . </h3>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="copy-right-box">
					<div class="copy-right-title">
						<ul>
							<li><a href="{{route('privacy-and-policy')}}"><span>Privacy Policy</span></a></li>
							<li><a href="{{route('terms&Conditions')}}"><span>Terms & Condition</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--==================================================-->
<!-- Start Search Popup Area -->
<!--==================================================-->
<div class="search-popup">
		<button class="close-search style-two"><i class="fa fa-times"></i></button>
		<button class="close-search"><i class="fas fa-arrow-up"></i></button>
		<form method="post" action="#">
			<div class="form-group">
				<input type="search" name="search-field" value="" placeholder="Search Here" required="">
				<button type="submit"><i class="fa fa-search"></i></button>
			</div>
		</form>
	</div>

<!-- scroll strat============  -->
<div class="scroll-area">
	<div class="top-wrap">
		<div class="go-top-btn-wraper">
			<div class="go-top go-top-button">
				<i class="fa fa-angle-double-up" aria-hidden="true"></i>
				<i class="fa fa-angle-double-up" aria-hidden="true"></i>
			</div>
		</div>
	</div>
</div>
<!-- scroll end============  -->
