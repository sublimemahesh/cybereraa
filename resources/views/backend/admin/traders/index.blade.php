<x-backend.layouts.app>
    @section('title', 'Traders | Expenses Summery')
    @section('header-title', 'Traders | Expenses Summery' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.traders.index') }}">Traders</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.traders.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="traders">
                        <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>LAST MODIFIED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traders as $trader)
                                <tr>
                                    <td class="py-2">
                                        @can('update', $trader)
                                            <a class="btn btn-xs btn-info sharp" href="{{ route('admin.traders.edit', $trader) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $trader)
                                            <a class="btn btn-xs btn-danger sharp delete-trader" data-trader="{{ $trader->id }}" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                        @can('create', \App\Models\TraderTransaction::class)
                                            <a class="btn btn-xs btn-success sharp" href="{{ route('admin.traders.transactions.index', $trader) }}">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td>{{ $trader->name }}</td>
                                    <td>{{ $trader->email }}</td>
                                    <td>{{ $trader->phone }}</td>
                                    <td>{{ $trader->updated_at }}</td>
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
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/traders.js') }}"></script>
    @endpush
</x-backend.layouts.app>

