<div class="col-12">
    <div class="card">
        <div class="card-header border-0  flex-wrap">
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.transactions.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.index') ? route('user.transactions.index') : 'javascript:void(0)' }}">My Transactions</a>
                    <a class="nav-link {{ request()->routeIs('user.transactions.purchased.history') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.purchased.history') ? route('user.transactions.purchased.history') : 'javascript:void(0)' }}">Purchase History</a>
                </div>
            </nav>
        </div>
    </div>
</div>
