@can('users.update')
    <a class="btn btn-xs btn-primary shadow sharp my-1" href="{{ route('super_admin.users.edit', $user) }}" title="Edit">
        <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    <a class="btn btn-xs btn-info sharp my-1" href="{{ route('super_admin.users.changePassword', $user) }}" title="Reset Password">
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
    <a href='{{ route('admin.users.profile.show', $user) }}' class='btn btn-xs btn-success sharp me-1 shadow'>
        <i class='fa fa-user' aria-hidden='true'></i>
    </a>
@endcan