<!--********************************** Sidebar start ***********************************-->
<div class="deznav pt-md-0">
    <div class="deznav-scroll">
        <ul class="metismenu pt-0" id="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            @include('backend.layouts.sidebar')

            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
