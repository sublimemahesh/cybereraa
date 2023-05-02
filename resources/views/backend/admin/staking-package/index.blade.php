<x-backend.layouts.app>
    @section('title', 'Staking Package | CMS')
    @section('header-title', 'Staking Package | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-packages.index') }}">Staking Package</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @can('update', \App\Models\StakingPackage::class)
                        <div class="mb-4">
                            <a class="btn btn-dark btn-xs btn-rounded"
                               href="{{ route('admin.staking-packages.arrange') }}">
                                Arrange
                            </a>
                        </div>
                        <hr>
                    @endcan
                    @include('backend.admin.staking-package.save', ['btn_id' => 'create'])
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
                            <th>GAS FEE</th>
                            <th>DESCRIPTION</th>
                            <th>IS ACTIVE</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($packages as $package)
                            <tr>
                                <td class="py-2">
                                    @can('update', $package)
                                        <a class="btn btn-xs btn-info sharp"
                                           href="{{ route('admin.staking-packages.edit', $package) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $package)
                                        <a class="btn btn-xs btn-danger sharp delete-package"
                                           data-package="{{ $package->id }}" href="javascript:void(0)">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                    @can('create', \App\Models\StakingPlan::class)
                                        <a class="btn btn-xs btn-success sharp"
                                           href="{{ route('admin.staking-packages.plans.index', $package) }}">
                                            <i class="fa fa-shuffle"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->slug }}</td>
                                <td>{{ $package->currency }}</td>
                                <td class="text-end">{{ $package->amount }}</td>
                                <td class="text-end">{{ $package->gas_fee }}</td>
                                <td>{{ $package->description }}</td>
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
        <script src="{{ asset('assets/backend/js/admin/cms/staking_package.js') }}"></script>
    @endpush
</x-backend.layouts.app>

