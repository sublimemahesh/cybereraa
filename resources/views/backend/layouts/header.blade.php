<!--********************************** Nav header start ***********************************-->
<div class="nav-header">
    <a href="{{ route('/') }}" class="brand-logo">
        <img src="{{ asset('assets/backend/images/logo/logo.png') }}" class="logo-abbr" id="logo-abbr" alt="">
        <img src="{{ asset('assets/backend/images/logo/logo-text.png') }}" class="brand-title" id="brand-title" alt="">
        <img src="{{ asset('assets/backend/images/logo/logo-color.png') }}" class="logo-color" alt="">
        <img src="{{ asset('assets/backend/images/logo/logo-text-color.png') }}" class="brand-title color-title" alt="">
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
                    <div class="dashboard_bar ">
                        <h3 class="h3-txt">@yield('header-title')</h3>
                        <span class="txte-right">
                            @yield('header-title2')
                        </span>
                    </div>
                </div>

                {{-- <div class="navbar-nav header-right">
                    <div class="dz-side-menu">
                        <ul>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="">
                                </a>

                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </nav>
    </div>
</div>
<!--********************************** Header end ti-comment-alt ***********************************-->
