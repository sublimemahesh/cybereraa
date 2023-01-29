<x-backend.layouts.app>
    @section('title', 'Show')
    @section('header-title', 'Show')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('super_admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="">Show</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title">
                        User Roles & Permissions
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap " id="tickets">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>{{ $user->name ?? '' }}</th>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <th>
                                    @foreach($user->roles as $key => $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                        <hr>
                                        Permissions:
                                        @foreach($role->permissions as $key => $permission)
                                            <span class="badge badge-primary">{{ $permission->name }}</span>
                                        @endforeach
                                    @endforeach
                                </th>
                            </tr>
                            <tr>
                                <th>Direct Permissions</th>
                                <th>
                                    @foreach($directPermissionsNames as $key => $name)
                                        <span class="badge badge-primary">{{ $name }}</span>
                                    @endforeach
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>
