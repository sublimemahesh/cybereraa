<x-backend.layouts.app>
    @section('title', 'Staking Plan | CMS')
    @section('header-title', 'Staking Plan | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-packages.plans.index', $package) }}">Staking Plan</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @can('update', \App\Models\StakingPlan::class)
                        <div class="mb-4">
                            <a class="btn btn-dark btn-xs btn-rounded"
                               href="{{ route('admin.staking-packages.plans.arrange', $package) }}">
                                Arrange
                            </a>
                        </div>
                        <hr>
                    @endcan
                    @include('backend.admin.staking-package.plans.save', ['btn_id' => 'create'])
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
                            <th>DURATION (DAYS)</th>
                            <th>INTEREST RATE</th>
                            <th>IS ACTIVE</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($plans as $plan)
                            <tr>
                                <td class="py-2">
                                    @can('update', $plan)
                                        <a class="btn btn-xs btn-info sharp"
                                           href="{{ route('admin.plans.edit', $plan) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $plan)
                                        <a class="btn btn-xs btn-danger sharp delete-package"
                                           data-package="{{ $plan->id }}" href="javascript:void(0)">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->duration }}</td>
                                <td>{{ $plan->interest_rate }}%</td>
                                <td>{{ $plan->is_active }}</td>
                                <td>{{ $plan->updated_at }}</td>
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
        <script src="{{ asset('assets/backend/js/admin/cms/staking_plan.js') }}"></script>
    @endpush
</x-backend.layouts.app>

