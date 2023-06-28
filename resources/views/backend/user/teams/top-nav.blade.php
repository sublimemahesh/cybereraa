<div class="col-12">
    <nav>
        <div class="order nav nav-tabs">
            <a class="nav-link {{ request()->routeIs('user.genealogy') ? 'active' : '' }}" href="{{ !request()->routeIs('user.genealogy') ? route('user.genealogy') : 'javascript:void(0)' }}">Genealogy</a>
            <a class="nav-link {{--{{ request()->routeIs('user.earnings.team-income') ? 'active' : ''  }}--}}" href="{{--{{ !request()->routeIs('user.earnings.team-income') ? route('user.earnings.team-income') : 'javascript:void(0)' }}--}}">Team List</a>
            <a class="nav-link {{ request()->routeIs('user.earnings.team-income') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.team-income') ? route('user.earnings.team-income') : 'javascript:void(0)' }}">Highest Earnings</a>
            <a class="nav-link {{ request()->routeIs('user.team.incomes.commission') ? 'active' : '' }}" href="{{ !request()->routeIs('user.team.incomes.commission') ? route('user.team.incomes.commission') : 'javascript:void(0)' }}">Team Incomes</a>
            <a class="nav-link {{ request()->routeIs('user.earnings.yearly-income-chart') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.yearly-income-chart') ? route('user.earnings.yearly-income-chart', ['team' => true]).'#team-income-chart' : 'javascript:void(0)' }}">Income Chart</a>
        </div>
    </nav>
</div>
