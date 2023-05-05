<x-backend.layouts.app>
    @section('title', 'Withdraw Requests | Payouts')
    @section('header-title', 'Withdraw Request | Reject' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Reject withdrawal request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Reject Payout</h4>
                        <p>
                            {{ $withdraw->wallet_type === 'MAIN' ? 'Withdrawal limit & ' : '' }} Balance will be increased by <code>AMOUNT + TRANSACTION</code> fee
                        </p>
                        <p>
                            If any packages are expired when requesting the payout, they will be <code>activate</code> again, only if <code>not expired date</code> is passed.
                        </p>
                        <hr>
                        <div>
                            TRANSACTION ID: <code>#{{ str_pad($withdraw->id,4,0,STR_PAD_LEFT) }}</code> <br/>
                            Wallet: <code>{{ $withdraw->wallet_type }}</code><br/>
                            Withdraw Type: <code>{{ $withdraw->type }}</code><br/>
                            <hr/>
                            User ID: <code>{{ $withdraw->user_id }}</code><br/>
                            Username: <code>{{ $withdraw->user->username }}</code><br/>
                            Full Name: <code>{{ $withdraw->user->name }}</code><br/>
                            Email: <code>{{ $withdraw->user->email }}</code>
                            <br/>
                            <hr/>
                            <p>
                                MAIN WALLET <br>
                                &emsp; Balance: <code>USDT {{ $withdraw->user->wallet->balance }}</code> <br/>
                                &emsp; Payout limit: <code>USDT {{ $withdraw->user->wallet->withdraw_limit }}</code>
                            </p>
                            <p>
                                TOPUP WALLET <br>
                                &emsp; Balance: <code>USDT {{ $withdraw->user->wallet->topup_balance }}</code>
                            </p>
                            <p>
                                STAKING WALLET <br>
                                &emsp; Balance: <code>USDT {{ $withdraw->user->wallet->staking_balance }}</code>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="reject-withdrawal-form">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Withdrawal Amount
                                    </label>
                                    <div class="form-control">{{ $withdraw->amount }}</div>
                                    <div class="text-info">
                                        Transaction Fee: <code id="show-receiving-amount">{{ $withdraw->transaction_fee }}</code> /
                                        Total: <code id="show-receiving-amount">{{ $withdraw->amount + $withdraw->transaction_fee }}</code>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Wallet Type</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->wallet_type }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <div class="form-control">{{ $withdraw->remark ?? '-' }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Email:</b> {{ $payout_info->email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $payout_info->id }}</p>
                                        <p class="mb-0"><b>Address:</b> {{ $payout_info->address }}</p>
                                        <p class="mb-0"><b>Phone:</b> {{ $payout_info->phone }}</p>
                                    </div>
                                </div>
                                @if($withdraw->expired_packages !== null)
                                    <div class="mb-3 mt-2">
                                        <label for="remark">Expired Packages</label>
                                        <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->expired_packages }}</div>
                                    </div>
                                @endif
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="repudiate_note">Reason</label>
                                    <textarea id="repudiate_note" name="repudiate_note" rows="3" placeholder="Reject Note" class="form-control h-auto">{{ $withdraw->repudiate_note }}</textarea>
                                </div>
                                <hr>
                                <button type="submit" id="reject-payout" class="btn btn-sm btn-success mb-2">Confirm & Reject</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/users/wallets/reject-withdraw.js') }}"></script>
    @endpush
</x-backend.layouts.app>
