@can('users.update')
    <a class="btn btn-xs btn-primary shadow sharp my-1" href="{{ route('super_admin.users.edit', $user) }}" title="Edit">
        <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    <a class="btn btn-xs btn-info sharp my-1" href="{{ route('super_admin.users.changePassword', $user) }}" title="Reset Password & Manage 2-Factor Authentication">
        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
    </a>
@endcan
@can('users.manage-permissions')
    <a class="btn btn-xs btn-google sharp my-1" href="{{ route('super_admin.users.manage', $user) }}" title="Direct permission">
        <i class="fa fa-shield-halved" aria-hidden="true"></i>
    </a>
    <a class="btn btn-xs btn-warning sharp my-1" href="{{ route('super_admin.users.show-permissions', $user) }}" title="Assigned roles & permissions">
        <i class="fa fa-eye" aria-hidden="true"></i>
    </a>
@endcan
@can('users.view.profile')
    <a href='{{ route('admin.users.profile.show', $user) }}' title="View Profile" class='btn btn-xs btn-success sharp me-1 shadow'>
        <i class='fa fa-user' aria-hidden='true'></i>
    </a>
@endcan
@can('suspend', $user)
    <a class='btn btn-xs btn-danger sharp my-1 mr-1 shadow suspend-user' title="Suspend the user" data-user='{{ $user->id }}' href='javascript:void(0)'>
        <i class='fa fa-ban' aria-hidden='true'></i>
    </a>
@endcan
@can('reActivate', $user)
    <a class='btn btn-xs btn-success sharp my-1 mr-1 shadow activate-suspended-user' data-reason="{{ $user->suspend_reason }}" title="Re-activate the user" data-user='{{ $user->id }}' href='javascript:void(0)'>
        <i class='fa fa-check-double' aria-hidden='true'></i>
    </a>
@endcan
