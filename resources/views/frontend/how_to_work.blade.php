<x-frontend.layouts.app>
    @section('title', 'How it work')
    @section('header-title', 'Welcome ')
    @section('styles')

        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/frontend/css/hiw.css') }}" rel="stylesheet">
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>

        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

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

    <section id="hiw">
        <div class="container">
            <div class="col-xs-12 col-sm-2">
                <ul id="nav-serialscrolling" class="faq-cat-holder">
                    <li><span class="sub-link" data-serialscrolling="home"><span>Login and Register</span><i class="fas fa-arrow-right  rigth-arrow"></i></span><i
                            class='fas fa-arrow-down ul-count'></i></li>
                    <li><span class="sub-link" data-serialscrolling="work"><span>KYC Approval</span><i class="fas fa-arrow-right rigth-arrow" ></i></span><i
                            class='fas fa-arrow-down ul-count '></i></li>
                    <li><span class="sub-link" data-serialscrolling="team"><span>Buy Packages</span><i class="fas fa-arrow-right rigth-arrow"></i></span><i
                        class='fas fa-arrow-down ul-count '></i></li>
                    <li><span class="sub-link" data-serialscrolling="team2"><span>Invite Members</span><i class="fas fa-arrow-right rigth-arrow"></i></span><i
                        class='fas fa-arrow-down ul-count '></i></li>
                    <li><span class="sub-link" data-serialscrolling="team3"><span>Withdraw Money</span><i class="fas fa-arrow-right rigth-arrow" id="lasat-arrow"></i></span></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-10">
                <div data-serialscrolling-target="home"  class='frist-div'>
                    <h1>What is Lorem Ipsum ?</h1>

                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and
                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap
                        into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                        with
                        the
                        release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                        publishing
                        software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
                <div data-serialscrolling-target="work"  class='frist-div'>
                    <h1>What is Lorem Ipsum ?</h1>

                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and
                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap
                        into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                        with
                        the
                        release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                        publishing
                        software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
                <div data-serialscrolling-target="team"  class='frist-div'>
                    <h1>What is Lorem Ipsum ?</h1>

                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and
                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap
                        into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                        with
                        the
                        release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                        publishing
                        software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
                <div data-serialscrolling-target="team2"  class='frist-div'><h1>What is Lorem Ipsum ?</h1>

                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and
                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap
                        into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                        with
                        the
                        release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                        publishing
                        software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div></div>
                <div data-serialscrolling-target="team3"  class='frist-div'>
                    <h1>What is Lorem Ipsum ?</h1>

                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                        type
                        and
                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                        leap
                        into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                        with
                        the
                        release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                        publishing
                        software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
            </div>
        </div>
    </section>






    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/frontend/js/jquery.serialscrolling.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/hiw.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
