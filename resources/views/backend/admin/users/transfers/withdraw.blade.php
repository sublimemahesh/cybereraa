<x-backend.layouts.app>
    @section('title', 'Withdraw USDT | Payouts')
    @section('header-title', 'Withdraw USDT')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Withdraw</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="approval-form">
                        <div class="mb-2">
                            TRANSACTION ID: <code>#{{ str_pad($withdraw->id,4,0,STR_PAD_LEFT) }}</code> <br/>
                            Wallet: <code>{{ $withdraw->wallet_type }}</code><br/>
                            Withdraw Type: <code>{{ $withdraw->type }}</code><br/>
                            <hr/>
                            <div>
                                <div class="mb-2">User ID: <code class="fs-15">{{ $withdraw->user_id }}</code></div>
                                <div class="mb-2">Username: <code class="fs-15">{{ $withdraw->user->username }}</code></div>
                                <div class="mb-2">Full Name: <code class="fs-15">{{ $withdraw->user->name }}</code></div>
                                <div class="mb-2">Email: <code class="fs-15">{{ $withdraw->user->email }}</code></div>
                                Phone: <code class="fs-15">{{ $withdraw->user->phone }}</code>
                            </div>
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

                            <hr/>
                            Please note this <code class="text-uppercase">process cannot be reversed</code>.
                            <hr/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2 text-center ">
                                    <label for="withdraw-amount">
                                        Requested Withdrawal Amount
                                    </label>
                                    {{--<div class="form-control">{{ $withdraw->amount }}</div>--}}
                                    <div class="fs-20">
                                        Amount : <code>{{ number_format($withdraw->amount,2) }}</code> <br>
                                        Transactions Fee: <code>{{ number_format($withdraw->transaction_fee,2) }}</code>
                                    </div>
                                    <div class="text-info text-center font-w600 fs-30 mt-3">
                                        Total: <code>{{ number_format($withdraw->amount + $withdraw->transaction_fee,2) }}</code>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Wallet Type</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->wallet_type }}</div>
                                </div>
                                <div class="mb-3 mt-2 d-none">
                                    <label for="remark">Remark</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->remark }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="h-auto">
                                        {{--<p class="mb-0"><b>Email:</b> {{ $payout_info->email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $payout_info->id }}</p>--}}
                                        <label class="form-label"><b>Wallet Address:</b></label>
                                        <div class="form-control mb-0">
                                            <div class="text-truncate copy-to-clipboard cursor-pointer" data-clipboard-text="{{ $payout_info->address }}">
                                                {{ $payout_info->address }}
                                                <i class="fa fa-clone" style="font-size: 17px;"></i>
                                            </div>
                                        </div>
                                        {{--<p class="mb-0"><b>Phone:</b> {{ $payout_info->phone }}</p>--}}
                                    </div>
                                    <div class="text-info mt-2">View Profile Details:
                                        <a href="{{ route('admin.users.profile.show', $withdraw->user) }}">View Profile</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2 d-none">
                                    <label for="proof_document">Proof</label>
                                    <input class="form-control" data-input='payout' type="file" name='proof_document' id='proof_document'>
                                </div>
                                {{--<hr>--}}
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <p>You'll need to provide a password only when approving the request.</p>

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
                        <div class="d-flex justify-content-evenly mt-2">
                            <button type="submit" class="btn btn-success" id="approveWithdraw">APPROVE</button>
                            <button type="submit" id="reject-payout" class="btn btn-danger">Confirm & Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/transfers/withdraw_form.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>
        <script !src="">
            const APPROVE_URL = "{{ route('admin.transfers.withdrawals.approve', $withdraw->id) }}";
            const REJECT_URL = "{{ route('admin.transfers.withdrawals.reject', $withdraw->id) }}";
            const REJECT_REASONS = {!! json_encode(App\Enums\WithdrawalRejectReasonsEnum::reasons(),JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT) !!};

            const REJECT_NOTE_HTML = `
                    <div>
                        <p>
                            {{ $withdraw->wallet_type === 'MAIN' ? 'Withdrawal limit & ' : '' }} Balance will be increased by <code>AMOUNT + TRANSACTION FEE</code>
                            <br>
                            USDT {{ number_format($withdraw->amount + $withdraw->transaction_fee,2) }}
            </p>
@if($withdraw->expired_packages !== null)
            <p>
                If any packages are expired when requesting the payout, they will be <code>activate</code> again, only if <code>not expired date</code> is passed.
            </p>
<div class="mb-3 mt-2">
    <label for="remark">Expired Packages</label>
    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->expired_packages }}</div>
                            </div>
                        @endif
            </div> `;
            let clipboard = new ClipboardJS('.copy-to-clipboard');

            // Handle copy success
            clipboard.on('success', function (e) {
                Toast.fire({
                    icon: 'success', title: 'Address copied to clipboard!',
                })
                e.clearSelection();
            });
        </script>
        <script src="{{ asset('assets/backend/js/admin/users/wallets/reject-withdraw.js') }}"></script>
    @endpush
</x-backend.layouts.app>
