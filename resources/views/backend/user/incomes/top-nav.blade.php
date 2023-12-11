<div class="col-12">
    <div class="order nav nav-tabs">
        <a class="nav-link {{ request()->routeIs('user.earnings.summary-report') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.summary-report') ? route('user.earnings.summary-report') : 'javascript:void(0)' }}">Earnings Summary</a>
        <a class="nav-link {{ request()->routeIs('user.incomes.commission') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.commission') ? route('user.incomes.commission') : 'javascript:void(0)' }}">My Commissions</a>
{{--        <a class="nav-link {{ request()->routeIs('user.incomes.rewards') ? 'active' : '' }}" href="{{ !request()->routeIs('user.incomes.rewards') ? route('user.incomes.rewards') : 'javascript:void(0)' }}">My Rewards</a>--}}
        <a class="nav-link {{ request()->routeIs('user.earnings.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.index') ? route('user.earnings.index') : 'javascript:void(0)' }}">My Earnings</a>
        @can('viewSummery', \App\Models\RankBonusSummery::class)
            <a class="nav-link {{ request()->routeIs('user.ranks.benefits.summery') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.benefits.summery') ? route('user.ranks.benefits.summery') : 'javascript:void(0)' }}">Bonus Summery</a>
        @endcan
        {{--<a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart') : 'javascript:void(0)' }}">Income Chart</a>--}}
    </div>
</div>
