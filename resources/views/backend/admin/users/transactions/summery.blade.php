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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <h4 class="card-title">Transaction Summery </h4>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="mb-2">
                                        <p data-devil="fs:15"><b>Payment id:</b> {{ $transaction->id }}</p>
                                        <p data-devil="fs:15"><b>User:</b> {{ $transaction->user_id }} - {{ $transaction->user->username }}</p>
                                        <p data-devil="fs:15"><b>Purchased By:</b> {{ $transaction->purchaser_id }} -
                                            {{ $transaction->purchaser->username }}</p>
                                        <p data-devil="fs:15"><b>Package:</b>
                                            {{ $transaction->create_order_request_info->goods->goodsName ?? '-' }}</p>
                                        <p data-devil="fs:15"><b>Currency:</b> {{ $transaction->currency }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <p data-devil="fs:15"><b>Amount:</b> {{ $transaction->amount }}</p>
                                        <p data-devil="fs:15"><b>Gas Fee: </b> {{ $transaction->gas_fee }}</p>
                                        <p data-devil="fs:15"><b>Pay Method:</b> {{ $transaction->type }}/{{ $transaction->pay_method }}</p>
                                        @if ($transaction->status === 'REJECTED')
                                            <p data-devil="fs:15"><b>Repudiate note:</b> {{ $transaction->repudiate_note }}</p>
                                        @endif
                                        <p data-devil="fs:15"><b>Status:</b> {{ $transaction->status }}</p>
                                    </div>

                                </div>

                            </div>







                            @if ($transaction->pay_method === 'MANUAL')
                                <div class="row">
                                    <div>
                                        <hr>
                                        <div class="mt-2">
                                            <div class="text-info">
                                                <label for="proof_document">Proof:</label>
                                                <a href="{{ asset('storage/user/manual-purchase/' . $transaction->proof_document) }}"
                                                    target="_blank">View Proof</a>
                                            </div>
                                        </div>
                                        <div class=" mt-1">
                                            <div class="text-info">
                                                <label for="proof_document">Transaction ID:</label>
                                                <a href="javascript:void(0)" data-clipboard-text="{{ $transaction->transaction_id }}" id="copy-to-clipboard" class="copy-to-clipboard">{{ $transaction->transaction_id }} <i class="fa fa-clone my-auto" style="font-size: 17px;" data-devil="ml:5"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <hr>

                        </div>
                        <div class="col-sm-5 m-auto text-center">
                            <img src="{{ storage('user/manual-purchase/' . $transaction->proof_document) }}"
                                alt="" class="img-thumbnail mw-100">
                        </div>
                    </div>

                    {{-- @can('approve', $transaction)
                        <a href="{{ route('admin.transactions.approve', $transaction) }}" class="btn btn-success my-1 mr-1 shadow">
                            <i class="fa fa-check-double"></i> Approve Transaction
                        </a>
                    @endcan
                    @can('approve', $transaction)
                        <a href="{{ route('admin.transactions.reject', $transaction) }}" class="btn btn-danger my-1 mr-1 shadow">
                            <i class="fa fa-ban"></i> Reject Transaction
                        </a>
                    @endcan --}}

                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>

    <script !src="">
        // document.getElementById('approveModal').addEventListener('shown.bs.modal', event => {
        let clipboard = new ClipboardJS('#copy-to-clipboard');
        // Handle copy success
        clipboard.on('success', function (e) {
            console.log(e)
            Toast.fire({
                icon: 'success', title: 'Transaction ID copied to clipboard!',
            })
            e.clearSelection();

            let textarea = document.createElement('textarea');
            textarea.value = e.text;
            document.body.appendChild(textarea);
            textarea.select();
            textarea.focus()
            document.execCommand('copy');
            document.body.removeChild(textarea);
        });
        // })
    </script>



    @endpush
</x-backend.layouts.app>
