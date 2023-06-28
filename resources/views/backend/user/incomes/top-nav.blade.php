<div class="col-12">
    <div>
        <div class="card-header border-0  flex-wrap">
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.incomes.commission') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.commission') ? route('user.incomes.commission') : 'javascript:void(0)' }}">Commissions</a>
                    <a class="nav-link {{ request()->routeIs('user.incomes.rewards') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.rewards') ? route('user.incomes.rewards') : 'javascript:void(0)' }}">Rewards</a>
                    <a class="nav-link {{ request()->routeIs('user.earnings.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.index') ? route('user.earnings.index') : 'javascript:void(0)' }}">Earnings</a>
                </div>
            </nav>
        </div>
    </div>
</div>
