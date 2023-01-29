<x-backend.layouts.app>
    @section('title', 'Users')
    @section('header-title', 'Users')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Users</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title">
                        Add Users
                    </h5>

                    <a href="{{ route('super_admin.users.addRoleForm') }}" type="button" class="btn btn-success">Add Users</a>


                    <hr>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap " id="tickets">
                        <thead>
                            <tr>
                                    <th>ACTIONS</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Email Verfied at</th>
                                    <th>Roles</th>
                                    <th>Direct Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td class="py-2">
                                        <a class="btn btn-xs btn-info" href="{{ route('super_admin.users.edit', $user->id) }}">
                                            {{ trans('Edit') }}
                                        </a>
                                        <a class="btn btn-xs btn-info" href="{{ route('super_admin.users.manage', $user->id) }}">
                                            {{ trans('Manage') }}
                                        </a>
                                        <a class="btn btn-xs btn-info" href="{{ route('super_admin.users.show', $user->id) }}">
                                            {{ trans('View') }}
                                        </a>
                                        <a class="btn btn-xs btn-info" href="{{ route('super_admin.users.roleEdit', $user->id) }}">
                                            {{ trans('Role Edit') }}
                                        </a>
                                        <form action="{{ route('super_admin.users.destroy', $user->id) }}" method="get" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}">
                                        </form>
                                    </td>
                                    <td>
                                        {{ $user->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user->email ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user->email_verified_at ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($user->roles as $key => $item)
                                            <span class="badge badge-info">{{ $item->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>
