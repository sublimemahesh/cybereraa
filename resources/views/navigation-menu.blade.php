<li class="{{ Str::contains(Route::currentRouteName(), 'profile') ? 'mm-active' : '' }}">
    <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
        <i class="material-icons">person</i>
        <span class="nav-text">My Account</span>
    </a>
    <ul aria-expanded="false">
        {{-- <li>
             <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'mm-active' : '' }}">
                 {{ __('My Profile') }}
             </a>
         </li> --}}
        <li>
            <a class="{{ request()->routeIs('profile.show') ? 'mm-active' : '' }}" href="{{ route('profile.show') }}">
                <span>Account Settings</span>
            </a>
        </li>
    </ul>
</li>

@if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && !empty(@Auth::user()->currentTeam))
    <li class="{{ Str::contains(Route::currentRouteName(), 'teams') ? 'mm-active' : '' }}">
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-icons">group</i>
            <span class="nav-text">{{ __('Manage Team') }} </span>
        </a>
        <ul aria-expanded="false">
            <li>
                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                    class="{{ request()->routeIs('teams.show') ? 'mm-active' : '' }}">
                    {{ __('Team Settings') }}
                </a>
            </li>
            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <li>
                    <a href="{{ route('teams.create') }}"
                        class="{{ request()->routeIs('teams.create') ? 'mm-active' : '' }}">
                        {{ __('Create New Team') }}
                    </a>
                </li>
            @endcan
            <li class="{{ request()->routeIs('current-team.update') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">{{ __('Switch Teams') }}</a>
                <ul aria-expanded="false">
                    @foreach (Auth::user()->allTeams() as $team)
                        <li>
                            <form class="sidebar-header" method="POST" action="{{ route('current-team.update') }}">
                                @csrf
                                <input type="hidden" name="_method" value="PUT" />
                                <input type="hidden" name="team_id" value="{{ $team->id }}">
                                <a href="{{ route('current-team.update') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="align-items-center d-inline-flex text-truncate">
                                    @if (Auth::user()->isCurrentTeam($team))
                                        <svg class="text-success pr-1" style="width:14px; height:14px" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <i data-feather="circle"></i>
                                    @endif
                                    {{ $team->name }}
                                </a>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </li>
@endif
@if (Laravel\Jetstream\Jetstream::hasApiFeatures())
    <li class="{{ request()->routeIs('api-tokens.index') ? 'mm-active' : '' }}">
        <a href="{{ route('api-tokens.index') }}">
            <i class="bi bi-code"></i>
            <span class="nav-text"> {{ __('API Tokens') }} </span>
        </a>
    </li>
@endif
