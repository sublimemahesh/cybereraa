<x-backend.layouts.app>
    @section('title', 'Transaction Summery | Payments')
    @section('header-title', 'Transaction Summery')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Transaction Summery</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <h4 class="card-title">Transaction Summery</h4>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <p><b>Transaction id:</b> {{ $transaction->id }}</p>
                                <p><b>User:</b> {{ $transaction->user_id }} - {{ $transaction->user->username }}</p>
                                <p><b>Purchased By:</b> {{ $transaction->purchaser_id }} - {{ $transaction->purchaser->username }}</p>
                                <p><b>Package:</b> {{ $transaction->create_order_request_info->goods->goodsName ?? '-' }}</p>
                                <p><b>Currency:</b> {{ $transaction->currency }}</p>
                                <p><b>Amount:</b> {{ $transaction->amount }}</p>
                                <p><b>Gas Fee: </b> {{ $transaction->gas_fee }}</p>
                                <p><b>Pay Method:</b> {{ $transaction->type }}/{{ $transaction->pay_method }}</p>
                                @if($transaction->status === 'REJECTED')
                                    <p><b>Repudiate note:</b> {{ $transaction->repudiate_note }}</p>
                                @endif
                                <p><b>Status:</b> {{ $transaction->status }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 m-auto text-center">
                            <img src="{{ storage('user/manual-purchase/' . $transaction->proof_document) }}" alt="" class="img-thumbnail mw-100">
                        </div>
                    </div>
                    @if($transaction->pay_method === 'MANUAL')
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                                <div class="mt-2">
                                    <div class="text-info">
                                        <label for="proof_document">Proof:</label>
                                        <a href="{{ asset('storage/user/manual-purchase/' . $transaction->proof_document) }}" target="_blank">View Proof</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr>
                    @can('approve', $transaction)
                        <a href="{{ route('admin.transactions.approve', $transaction) }}" class="btn btn-success my-1 mr-1 shadow">
                            <i class="fa fa-check-double"></i> Approve Transaction
                        </a>
                    @endcan
                    @can('approve', $transaction)
                        <a href="{{ route('admin.transactions.reject', $transaction) }}" class="btn btn-danger my-1 mr-1 shadow">
                            <i class="fa fa-ban"></i> Reject Transaction
                        </a>
                    @endcan

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>
