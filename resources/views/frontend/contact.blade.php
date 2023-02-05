<x-frontend.layouts.app>
    @section('title', 'Contact Us | Safest Trades | One to One Marketing Website')
    @section('header-title', 'Welcome ')

    @section('meta')
        <meta name="description"
            content="Need to speak to us? Do you have any queries or suggestions? Please contact us about all enquiries including membership and volunteer work using the form below.">
        <meta name="keywords"
            content="safesttrades, safest trades, one to one marketing, one to one marketing website, network marketing website, e money sites, money investment sites, cryptocurrency trading, trade, trade online, trades websites">
        <meta name="author" content="SAFEST TRADES">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @endsection

    @section('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endsection


    <div id="page">
        <section id="hero" class='net-hero'>
            <div class="background">
                <canvas id="hero-background"></canvas>
            </div>
            <div class="foreground">
                <div class="main">
                    <section class="banner-area">
                        <div class="banner-overlay">
                            <div class="banner-text text-center">
                                <div class="container">
                                    <!-- Section Title Starts -->
                                    <div class="row text-center">
                                        <div class="col-xs-12">
                                            <!-- Title Starts -->
                                            <h2 class="title-head">Contact <span>us</span></h2>
                                            <!-- Title Ends -->
                                            <hr>
                                            <!-- Breadcrumb Starts -->
                                            <ul class="breadcrumb">
                                                <li>
                                                    <a href="{{ route('/') }}" id='home'> home</a>
                                                </li>
                                                <li>contact</li>
                                            </ul>
                                            <!-- Breadcrumb Ends -->
                                        </div>
                                    </div>
                                    <!-- Section Title Ends -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
        </section>
    </div>


    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-8 contact-form">
                    <h3 class="col-xs-12">feel free to drop us a message</h3>
                    <p class="col-xs-12">Need to speak to us? Do you have any queries or suggestions? Please contact us
                        about all enquiries including membership and volunteer work using the form below.</p>
                    <!-- Contact Form Starts -->
                    <form id="form-contact" action="{{ route('send.mail') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <!-- Input Field Starts -->
                        <div class="form-group col-md-6">
                            <input class="form-control" data-input="contact-us" name="name" value="{{ old('name') }}" id="firstname" placeholder="YOUR NAME" type="text" required>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input Field Ends -->
                        <!-- Input Field Starts -->
                        <div class="form-group col-md-6">
                            <input class="form-control" data-input="contact-us" name="phone" value="{{ old('phone') }}" id="lastname" placeholder="PHONE" type="text" required>
                            @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input Field Ends -->
                        <!-- Input Field Starts -->
                        <div class="form-group col-md-6">
                            <input class="form-control" data-input="contact-us" name="email" value="{{ old('email') }}" id="email" placeholder="EMAIL" type="email" required>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input Field Ends -->
                        <!-- Input Field Starts -->
                        <div class="form-group col-md-6">
                            <input class="form-control" data-input="contact-us" name="subject" value="{{ old('subject') }}" id="subject" placeholder="SUBJECT" type="text" required>
                            @error('subject')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input Field Ends -->
                        <!-- Input Field Starts -->
                        <div class="form-group col-xs-12">
                            <textarea class="form-control" id="message" data-input="contact-us" name="message" placeholder="MESSAGE" required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input Field Ends -->
                        <!-- Submit Form Button Starts -->
                        <div class="form-group col-xs-12 col-sm-4">
                            <button class="btn btn-primary btn-contact" type="submit">send message</button>
                        </div>
                        <!-- Submit Form Button Ends -->
                        <!-- Form Submit Message Starts -->
                        <div class="col-xs-12 text-center output_message_holder d-none">
                            <p class="output_message"></p>
                        </div>
                        <!-- Form Submit Message Ends -->
                    </form>
                    <!-- Contact Form Ends -->
                </div>
                <!-- Contact Widget Starts -->
                <div class="col-xs-12 col-md-4">
                    <div class="widget">
                        <div class="contact-page-info">
                            <!-- Contact Info Box Starts -->
                            <div class="contact-info-box">
                                <i class="fa fa-home big-icon"></i>
                                <div class="contact-info-box-content">
                                    <h4>Address</h4>
                                    <p> Safest Trades, Proton Trading Pro LLC, 140 21ST ST STE R, Sacramento, CA 95811.</p>
                                </div>
                            </div>

                            <div class="contact-info-box">
                                <i class="fa fa-envelope big-icon"></i>
                                <div class="contact-info-box-content">
                                    <h4>Email Addresses</h4>
                                    <p>
                                        <a href="mailto:support@safesttrades.com">support@safesttrades.com</a>
                                    </p>
                                </div>
                            </div>
                            <!-- Contact Info Box Ends -->
                            <!-- Social Media Icons Starts -->
                            <div class="contact-info-box">
                                <i class="fa fa-share-alt big-icon"></i>
                                <div class="contact-info-box-content">
                                    <h4>Social Profiles</h4>
                                    <div class="social-contact">
                                        <ul>
                                            <li class="facebook">
                                                <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li class="twitter">
                                                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li class="google-plus">
                                                <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Social Media Icons Starts -->
                        </div>
                    </div>
                </div>
                <!-- Contact Widget Ends -->
            </div>
        </div>
    </section>


    <!-- Contact Section Ends -->

    @push('scripts')
        <script>

            /* ----------------------------------------------------------- */
            /*  AJAX CONTACT FORM
            /* ----------------------------------------------------------- */

            $("#form-contact").on("submit", function (e) {
                e.preventDefault();
                $(".output_message").text("Loading...");
                var form = $(this);
                axios.post(form.attr("action"), form.serialize()).then(response => {
                    if (response.data) {
                        $("#form-contact").find(".output_message_holder").addClass("d-block");
                        $("#form-contact").find(".output_message").addClass("success");
                        $(".output_message").text("Your message has been sent successfully!");
                        $("#form-contact")[0].reset()
                    }
                }).catch(error => {
                    $("#form-contact").find(".output_message_holder").addClass("d-block");
                    $("#form-contact").find(".output_message").addClass("error");
                    $(".output_message").text("Error while Sending email! try later");
                    let errorMap = [];
                    document.querySelectorAll('input[data-input=contact-us]').forEach(input => {
                        errorMap.push(input.id)
                    })
                    errorMap.map(id => {
                        error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                    })
                })
                return false;
            });

            function appendError(id, html) {
                try {
                    let el = $(document.getElementById(id));
                    $(el).next(".text-danger").remove();
                    $(html).insertAfter(el)
                } catch (e) {

                }
            }
        </script>
        <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
