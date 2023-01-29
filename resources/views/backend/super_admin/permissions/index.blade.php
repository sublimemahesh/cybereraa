<x-backend.layouts.app>
    @section('title', 'Permissions | Manage Privileges')
    @section('header-title', 'Permissions | Manage Privileges')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Permissions</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body  ">
                    <h5 class="card-title">
                        Permissions
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap " id="tickets">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Guard</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($permissions as $key => $permission)
                                <tr>
                                    <td>{{ $permission->id  ?? '' }}</td>
                                    <td>{{ $permission->name ?? '' }}</td>
                                    <td>{{ $permission->guard_name ?? '' }}</td>
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
