<div class="col-12">
    <div class="card">
        <div class="card-header border-0  flex-wrap">
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.earnings.team-income') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.team-income') ? route('user.earnings.team-income') : 'javascript:void(0)' }}">Highest Income</a>
                    <a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart') : 'javascript:void(0)' }}">Income Chart</a>
                </div>
            </nav>
        </div>
    </div>
</div>
