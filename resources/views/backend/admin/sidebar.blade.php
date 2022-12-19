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
                <a href="{{ route('admin.pages.index') }}" class="" aria-expanded="false">
                    <i class="material-icons">book</i>
                    <span class="nav-text">Pages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.blogs.index') }}" class="" aria-expanded="false">
                    <i class="material-icons">article</i>
                    <span class="nav-text">Blog</span>
                </a>
            </li>

            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->