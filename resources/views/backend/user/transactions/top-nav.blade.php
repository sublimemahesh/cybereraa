<div class="col-12">
    <div>
        <div>
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.packages.custom') ? 'active' : '' }}" href="{{ !request()->routeIs('user.packages.custom') ? route('user.packages.custom') : 'javascript:void(0)' }}">Custom Plan</a>
                    <a class="nav-link {{ request()->routeIs('user.packages.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.packages.index') ? route('user.packages.index') : 'javascript:void(0)' }}">Choose Plan</a>
                </div>
            </nav>
        </div>
    </div>
</div>
