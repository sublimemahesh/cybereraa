<div class="col-12">
    <div>
        <div>
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.packages.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.packages.index') ? route('user.packages.index') : 'javascript:void(0)' }}">Choose Plan</a>
                    <a class="nav-link {{ request()->routeIs('user.packages.active') ? 'active' : '' }}" href="{{ !request()->routeIs('user.packages.active') ? route('user.packages.active') : 'javascript:void(0)' }}">Active Plan</a>
                    <a class="nav-link {{ request()->routeIs('user.transactions.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.index') ? route('user.transactions.index') : 'javascript:void(0)' }}">My Transactions</a>
                    <a class="nav-link {{ request()->routeIs('user.transactions.purchased.history') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.purchased.history') ? route('user.transactions.purchased.history') : 'javascript:void(0)' }}">Purchase History</a>
                </div> 
            </nav>
        </div>
    </div>
</div>
