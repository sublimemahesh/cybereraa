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
                            User ID: <code>{{ $withdraw->user_id }}</code><br/>
                            Username: <code>{{ $withdraw->user->username }}</code><br/>
                            Full Name: <code>{{ $withdraw->user->name }}</code><br/>
                            Email: <code>{{ $withdraw->user->email }}</code><br/>
                            Phone: <code>{{ $withdraw->user->phone }}</code>
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

                            <hr/>
                            Please note this <code class="text-uppercase">process cannot be reversed</code>.
                            <hr/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Requested Withdrawal Amount
                                    </label>
                                    <div class="form-control">{{ $withdraw->amount }}</div>
                                    <div class="text-info">
                                        Transactions Fee: <code>{{ number_format($withdraw->transaction_fee,2) }}</code> /
                                        Total: <code>{{ number_format($withdraw->amount + $withdraw->transaction_fee,2) }}</code>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Wallet Type</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->wallet_type }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->remark }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Email:</b> {{ $payout_info->email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $payout_info->id }}</p>
                                        <p class="mb-0"><b>Address:</b> {{ $payout_info->address }}</p>
                                        <p class="mb-0"><b>Phone:</b> {{ $payout_info->phone }}</p>
                                    </div>
                                    <div class="text-info">View Profile Details:
                                        <a href="{{ route('admin.users.profile.show', $withdraw->user) }}">View Profile</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="proof_document">Proof</label>
                                    <input class="form-control" data-input='payout' type="file" name='proof_document' id='proof_document'>
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
                        <button type="submit" class="btn btn-primary" id="approveWithdraw">APPROVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/transfers/withdraw_form.js') }}"></script>
    @endpush
</x-backend.layouts.app>
