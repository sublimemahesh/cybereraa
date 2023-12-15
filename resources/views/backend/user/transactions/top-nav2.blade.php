<div class="col-12">
    <div>
        <div>
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.transactions.purchased.history') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.purchased.history') ? route('user.transactions.purchased.history') : 'javascript:void(0)' }}">Purcharse History</a>
                    <a class="nav-link {{ request()->routeIs('user.transactions.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transactions.index') ? route('user.transactions.index') : 'javascript:void(0)' }}">Bill Details</a>
                </div>
            </nav>
        </div>
    </div>
</div>
