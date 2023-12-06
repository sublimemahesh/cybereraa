<x-backend.layouts.app>
    @section('title', 'Traders Transactions | Expenses Summery')
    @section('header-title', 'Traders Transactions | Expenses Summery' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.traders.transactions.index', $trader) }}">Traders Transactions</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.traders.transactions.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="traders_transactions">
                        <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>OUT USDT</th>
                                <th>USDT OUT TIME</th>
                                <th>IN USDT</th>
                                <th>USDT IN TIME</th>
                                <th>REFERENCE</th>
                                <th>LAST MODIFIED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="py-2">
                                        @can('update', $transaction)
                                            <a class="btn btn-xs btn-info sharp" href="{{ route('admin.transactions.edit', $transaction) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('delete', $transaction)
                                            <a class="btn btn-xs btn-danger sharp delete-transaction" data-transaction="{{ $transaction->id }}" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td>{{ $transaction->out_usdt }}</td>
                                    <td>{{ $transaction->usdt_out_time }}</td>
                                    <td>{{ $transaction->in_usdt }}</td>
                                    <td>{{ $transaction->usdt_in_time }}</td>
                                    <td>{{ $transaction->reference }}</td>
                                    <td>{{ $transaction->updated_at }}</td>
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
        <script src="{{ asset('assets/backend/js/admin/cms/traders_transaction.js') }}"></script>
    @endpush
</x-backend.layouts.app>

