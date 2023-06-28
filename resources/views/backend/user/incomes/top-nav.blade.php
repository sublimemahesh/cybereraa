<div class="col-12">
    <nav>
        <div class="order nav nav-tabs">
            <a class="nav-link {{ request()->routeIs('user.incomes.commission') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.commission') ? route('user.incomes.commission') : 'javascript:void(0)' }}">My Commissions</a>
            <a class="nav-link {{ request()->routeIs('user.incomes.rewards') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.rewards') ? route('user.incomes.rewards') : 'javascript:void(0)' }}">My Rewards</a>
            <a class="nav-link {{ request()->routeIs('user.earnings.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.index') ? route('user.earnings.index') : 'javascript:void(0)' }}">My Earnings</a>
            <a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart') : 'javascript:void(0)' }}">Income Chart</a>
        </div>
    </nav>
</div>
