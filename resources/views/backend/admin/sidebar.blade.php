<!--********************************** Sidebar start ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
             <li>
                <a href="{{ route('admin.earnings.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-cash-stack"></i>
                    <span class="nav-text"> User Earnings </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Packages</span>
                </a>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">book</i>
                    <span class="nav-text">CMS</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.countries.index') }}">Country</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pages.index') }}">Pages</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blogs.index') }}">Bloge</a>
                    </li>
                </ul>
            </li>


            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->