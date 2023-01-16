<x-backend.layouts.app>
    @section('title', 'Packages | CMS')
    @section('header-title', 'Packages | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.packages.index') }}">Packages</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.packages.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="packages">
                        <thead>
                        <tr>
                            <th>ACTIONS</th>
                            <th>NAME</th>
                            <th>SLUG</th>
                            <th>CURRENCY</th>
                            <th>AMOUNT</th>
                            <th>MONTH OF PERIOD</th>
                            <th>DAILY LEVERAGE</th>
                            <th>IS ACTIVE</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr>
                                <td class="py-2">
                                    {{-- @can('update', $package) --}}
                                    <a class="btn btn-xs btn-info sharp" href="{{ route('admin.packages.edit', $package) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-xs btn-danger sharp delete-package" data-package="{{ $package->id }}" href="javascript:void(0)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    {{-- @endcan --}}
                                </td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->slug }}</td>
                                <td>{{ $package->currency }}</td>
                                <td>{{ $package->amount }}</td>
                                <td>{{ $package->month_of_period }}</td>
                                <td>{{ $package->daily_leverage }}</td>
                                <td>{{ $package->is_active }}</td>
                                <td>{{ $package->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/package.js') }}"></script>
    @endpush
</x-backend.layouts.app>

