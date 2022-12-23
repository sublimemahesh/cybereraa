<x-backend.layouts.app>
    @section('title', 'My KYC')
    @section('header-title', 'My KYC' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Users</li>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile Datatable</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users" class="display dataTable table header-border table-responsive-sm" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th></th>
                                <th>USERNAME</th>
                                <th>NAME</th>
                                <th>MOBILE</th>
                                <th>EMAIL</th>
                                <th>JOINED DATE</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-2">
                                        <img class="rounded-circle" width="35" src="{{ $user->profile_photo_url }}" alt="">
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.users.kycs.index', $user) }}" class="btn btn-success shadow btn-xs sharp me-1">
                                                <i class="fas fa-check-to-slot"></i>
                                            </a>
                                        </div>
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
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script !src="">
            // dataTable3
            var table = $('#users').DataTable({
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        </script>
    @endpush
</x-backend.layouts.app>