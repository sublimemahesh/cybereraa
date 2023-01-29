<x-backend.layouts.app>
    @section('title', 'Roles')
    @section('header-title', 'Roles')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Roles</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('super_admin.roles.create') }}" type="button" class="btn btn-success">Add New Role</a>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap " id="tickets">
                            <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Role</th>
                                <th>Permissions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td class="py-2">
                                        {{-- @can('update', $blog) --}}
                                        @can('default.roles.permissions', $role)

                                            <a class="btn btn-xs btn-info" href="{{ route('super_admin.roles.edit', $role->id) }}" title="Edit">
                                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                            </a>
                                            @can('default.roles.manage', $role)
                                                <form action="{{ route('super_admin.roles.destroy', $role->id) }}" method="post" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" value="{{ trans('Delete') }}" title="Delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endcan
                                    </td>
                                    <td>{{ $role->name ?? '' }}</td>
                                    <td class="text-wrap w-75">
                                        @foreach ($role->permissions as $key => $item)
                                            <span class="my-1 badge badge-info">{{ $item->name }}</span>
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
