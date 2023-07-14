<div class="col-12">
    <div class="order nav nav-tabs">
        <a class="nav-link {{ request()->routeIs('user.ranks.summery') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.summery') ? route('user.ranks.summery') : 'javascript:void(0)' }}">My Ranks & Eligibility</a>
        <a class="nav-link {{ request()->routeIs('user.team.income-levels') ? 'active' : ''  }}" href="{{ !request()->routeIs('user.team.income-levels') ? route('user.team.income-levels') : 'javascript:void(0)' }}">Income Levels</a>
        @can('viewRequirement', \App\Models\RankBonusSummery::class)
            <a class="nav-link {{ request()->routeIs('user.ranks.benefits.requirements') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.benefits.requirements') ? route('user.ranks.benefits.requirements') : 'javascript:void(0)' }}">Bonus Requirement</a>
        @endcan
        <a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart') : 'javascript:void(0)' }}">Income Chart</a>
        {{--<a class="nav-link {{ request()->routeIs('user.ranks.gifts') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.gifts') ? route('user.ranks.gifts') : 'javascript:void(0)' }}">Rank Gifts</a>--}}
    </div>
</div>
