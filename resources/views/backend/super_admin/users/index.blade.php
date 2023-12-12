<x-backend.layouts.app>
    @section('title', 'Users')
    @section('header-title', 'Users')
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Users</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @can('users.add-new')
                        <a href="{{ route('super_admin.users.create') }}" type="button" class="btn btn-success">Add User</a>
                    @endcan
                    <hr>
                    <div class="table-responsive">
                        <table class="table display table-responsive-my" style="width: 100%;table-layout: fixed" id="users">
                            <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>ID</th>
                                <th>USERNAME</th>
                                <th>NAME</th>
                                <th>PHONE</th>
                                <th>EMAIL</th>
                                <th>ROLES</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/super_admin/users/main.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/suspend-users.js') }}"></script>
        {{--<script src="{{ asset('assets/backend/js/admin/users/suspend.js') }}"></script>--}}
    @endpush
</x-backend.layouts.app>
