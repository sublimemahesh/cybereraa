<div class="col-12">
    <div class="order nav nav-tabs">
        {{--<a class="nav-link {{ request()->routeIs('user.genealogy') ? 'active' : '' }}" href="{{ !request()->routeIs('user.genealogy') ? route('user.genealogy') : 'javascript:void(0)' }}">Genealogy</a>--}}
        {{--<a class="nav-link {{ request()->routeIs('user.team.users-list') ? 'active' : ''  }}" href="{{ !request()->routeIs('user.team.users-list') ? route('user.team.users-list') : 'javascript:void(0)' }}">Team List</a>--}}
        <a class="nav-link {{ request()->routeIs('user.earnings.team-income') ? 'active' : '' }}" href="{{ !request()->routeIs('user.earnings.team-income') ? route('user.earnings.team-income') : 'javascript:void(0)' }}">Highest Earnings</a>
        <a class="nav-link {{ request()->routeIs('user.team.incomes.commission') ? 'active' : '' }}" href="{{ !request()->routeIs('user.team.incomes.commission') ? route('user.team.incomes.commission') : 'javascript:void(0)' }}">Team Income</a>
       {{-- <a class="nav-link {{ request()->routeIs('user.ranks.team-rankers') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.team-rankers') ? route('user.ranks.team-rankers') : 'javascript:void(0)' }}">Rankers List</a> --}}
    </div>
</div>
