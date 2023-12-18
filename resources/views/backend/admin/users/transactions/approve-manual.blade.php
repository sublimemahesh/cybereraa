<x-backend.layouts.app>
    @section('title', 'Approve Manual Transaction | Payments')
    @section('header-title', 'Approve Manual Transaction')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Approve Transaction</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="approval-form">
                        <div class="mb-2">
                            <h4 class="card-title">Approve Transaction</h4>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                                <div class="mb-3 mt-2">
                                    <div class="text-info">
                                        <label for="proof_document">Proof:</label>
                                        <a href="{{ asset('storage/user/manual-purchase/' . $transaction->proof_document) }}" target="_blank">View Proof</a>
                                    </div>
                                </div>
                                <hr>
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" name="password" data-input='payout' class="form-control" autocomplete="new-password">
                                </div>
                                @if(Auth::user()?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code</label>
                                        <input id="code" name="code" type="password" data-input='payout' class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" id="approveTrx">APPROVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/transactions/manual-trx.js') }}"></script>
    @endpush
</x-backend.layouts.app>
