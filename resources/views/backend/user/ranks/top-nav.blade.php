<div class="col-12">
    <div class="card">
        <div class="card-header border-0  flex-wrap">
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.ranks.team-rankers') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.team-rankers') ? route('user.ranks.team-rankers') : 'javascript:void(0)' }}">Eligibility & Team Rankers</a>
                    @can('viewRequirement', \App\Models\RankBonusSummery::class)
                        <a class="nav-link {{ request()->routeIs('user.ranks.benefits.requirements') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.benefits.requirements') ? route('user.ranks.benefits.requirements') : 'javascript:void(0)' }}">Bonus Requirement</a>
                    @endcan
                    @can('viewSummery', \App\Models\RankBonusSummery::class)
                        <a class="nav-link {{ request()->routeIs('user.ranks.benefits.summery') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.benefits.summery') ? route('user.ranks.benefits.summery') : 'javascript:void(0)' }}">Bonus Summery</a>
                    @endcan
                    <a class="nav-link {{ request()->routeIs('user.ranks.gifts') ? 'active' : '' }}" href="{{ !request()->routeIs('user.ranks.gifts') ? route('user.ranks.gifts') : 'javascript:void(0)' }}">Rank Gifts</a>
                </div>
            </nav>
        </div>
    </div>
</div>
