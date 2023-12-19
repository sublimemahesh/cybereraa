<div class='d-flex'>
    @can('kyc.viewAny')
        <a class='btn btn-xs btn-google sharp my-1 mr-1 shadow' title="Manage Kyc Verification" href='{{ route('admin.users.kycs.index', $user) }}'>
            <i class='fas fa-check-to-slot'></i>
        </a>
    @endcan

    @can('users.genealogy')
        <a class='btn btn-xs btn-google sharp my-1 mr-1 shadow' title="Team List" href='{{ route('admin.team.users-levels', ['user' => $user, 'depth' => 1]) }}'>
            {{--        <a class='btn btn-xs btn-google sharp my-1 mr-1 shadow' title="Team List" href='{{ route('admin.team.users-list', ['user' => $user, 'filter-user' => $user->username]) }}'>--}}
            <i class='bi bi-diagram-3-fill'></i>
        </a>
    @endcan

    @can('users.update')
        <a class="btn btn-xs btn-info sharp my-1 mr-1 shadow" href="{{ route('super_admin.users.changePassword', $user) }}" title="Reset Password & Manage 2-Factor Authentication">
            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
        </a>
        <a class="btn btn-xs btn-primary sharp my-1 mr-1 shadow" href="{{ route('super_admin.users.edit', $user) }}" title="Edit User">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
    @endcan

    @can('users.view.profile')
        <a class='btn btn-xs btn-success sharp my-1 mr-1 shadow' title="View Profile" href='{{ route('admin.users.profile.show', $user)  }}'>
            <i class='fa fa-user' aria-hidden='true'></i>
        </a>
    @endcan
    @can('suspend', $user)
        <a class='btn btn-xs btn-danger sharp my-1 mr-1 shadow suspend-user' title="Suspend the user" data-user='{{  $user->id  }}' href='javascript:void(0)'>
            <i class='fa fa-ban' aria-hidden='true'></i>
        </a>
    @endcan

    @can('reActivate', $user)
        <a class='btn btn-xs btn-success sharp my-1 mr-1 shadow activate-suspended-user' data-reason="{{ $user->suspend_reason }}" title="Re-activate the user" data-user='{{  $user->id  }}' href='javascript:void(0)'>
            <i class='fa fa-check-double' aria-hidden='true'></i>
        </a>
    @endcan

    @can('changeSponsor', $user)
        <a class='btn btn-xs btn-warning sharp my-1 mr-1 shadow' data-user='{{  $user->id  }}' title="Change the sponsor" href='{{ route('super_admin.users.change-sponsor', $user) }}'>
            <i class='fa fa-exchange' aria-hidden='true'></i>
        </a>
    @endcan
</div>

