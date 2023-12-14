<!--********************************** Nav header start ***********************************-->
<div class="nav-header">
    <a href="{{ route('/') }}" class="brand-logo d-flex flex-column justify-content-center">
        <div>
            <img src="{{ asset('assets/backend/images/logo/logo.png') }}" class="logo-abbr" id="logo-abbr" alt="">
            <img src="{{ asset('assets/backend/images/logo/logo-text.png') }}" class="brand-title" id="brand-title" alt="">
            <img src="{{ asset('assets/backend/images/logo/logo-color.png') }}" class="logo-color" alt="">
            <img src="{{ asset('assets/backend/images/logo/logo-text-color.png') }}" class="brand-title color-title" alt="">
        </div>
        <div> {{ Auth::user()->username }}</div>
    </a>
    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="22" y="11" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect x="11" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect x="22" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect x="11" y="11" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect x="11" y="22" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect height="4" rx="2" fill="#2A353A" width="400"></rect>
                <rect y="11" height="4" rx="2" fill="#2A353A" width="400"></rect>
                <rect x="22" y="22" width="4" height="4" rx="2" fill="#2A353A"></rect>
                <rect y="22" height="4" rx="2" fill="#2A353A" width="400"></rect>
            </svg>
        </div>
    </div>
</div>
<!--********************************** Nav header end ***********************************-->

<!--********************************** Header start ***********************************-->


<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">

                    <div class='logout-btn mob-dis'>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-1" aria-expanded="false">
                                {{-- <i class="bi bi-box-arrow-left"></span></i>
                                <span class="nav-text">{{ __('Logout') }} </span> --}}
                                <img src="{{ asset('assets/backend/images/icon/logout.png') }}"/>
                                <br>
                                <div data-devil='ml:10'>
                                    {{-- <span class="nav-text">{{ __('Logout') }} </span>  --}}
                                </div>
                            </a>
                        </form>
                    </div>


                    <div class="dashboard_bar ">
                        <h3 class="h3-txt">@yield('header-title')</h3>
                        <div id="google_translate_element"></div>
                        <span class="txte-right">
                            @yield('header-title2',Auth::user()->username)
                        </span>

                        <div class='logout-btn'>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-1" aria-expanded="false">
                                    {{-- <i class="bi bi-box-arrow-left"></span></i>
                                    <span class="nav-text">{{ __('Logout') }} </span> --}}
                                    <img src="{{ asset('assets/backend/images/icon/logout.png') }}"/>
                                    <br>
                                    <div data-devil='ml:10'>
                                        {{-- <span class="nav-text">{{ __('Logout') }} </span>  --}}
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>


<!--********************************** Header end ti-comment-alt ***********************************-->
