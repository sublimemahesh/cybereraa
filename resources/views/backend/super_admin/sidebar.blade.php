<!--********************************** Sidebar start ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('super_admin.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            @include('backend.layouts.sidebar')
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-activity"></i>
                    <span class="nav-text">Logs</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ url('super-admin/user-activity') }}">User Activity</a>
                    </li>
                    <li>
                        <a href="{{ url('super-admin/logs') }}">Logs</a>
                    </li>
                </ul>
            </li>
            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
