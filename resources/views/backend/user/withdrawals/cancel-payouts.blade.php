<x-backend.layouts.app>
    @section('title', 'My Withdrawals')
    @section('header-title', 'My Withdrawals | Cancel' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Cancel withdrawal request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Cancel Payout</h4>
                        <p>
                            {{ $withdraw->wallet_type === 'MAIN' ? 'Withdrawal limit & ' : '' }} Balance will be increased by <code>AMOUNT + TRANSACTION</code> fee
                        </p>
                        <p>
                            If any packages are expired when requesting the payout, they will be <code>activate</code> again, only if <code>not expired date</code> is passed.
                        </p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="cancel-withdrawal-form">
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
                                    <label for="remark">Remark</label>
                                    <div class="form-control">{{ $withdraw->remark ?? '-' }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    {{--<div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Email:</b> {{ $payout_info->email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $payout_info->id }}</p>
                                        <p class="mb-0"><b>Address:</b> {{ $payout_info->address }}</p>
                                        <p class="mb-0"><b>Phone:</b> {{ $payout_info->phone }}</p>
                                    </div>--}}
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Wallet Address:</b> {{ $payout_info->address }}</p>
                                        <p class="mb-0"><b>Wallet Nickname:</b> {{ $payout_info->wallet_address_nickname }}</p>
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
                                    <textarea id="repudiate_note" name="repudiate_note" rows="3" placeholder="Cancel Note" class="form-control h-auto">{{ $withdraw->remark }}</textarea>
                                </div>
                                <hr>
                                <button type="submit" id="cancel-payout" class="btn btn-sm btn-success mb-2">Confirm & Cancel</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')

        <script src="{{ asset('assets/backend/js/user/wallet/cancel-withdraw.js') }}"></script>
    @endpush
</x-backend.layouts.app>
