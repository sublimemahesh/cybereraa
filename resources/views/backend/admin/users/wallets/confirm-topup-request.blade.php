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
                            User ID: <code>{{ $topupHistory->receiver_id }}</code><br/>
                            Username: <code>{{ $topupHistory->receiver->username }}</code><br/>
                            Full Name: <code>{{ $topupHistory->receiver->name }}</code><br/>
                            Email: <code>{{ $topupHistory->receiver->email }}</code><br/>
                            Phone: <code>{{ $topupHistory->receiver->phone }}</code>
                            <br/>
                            <hr/>
                            Please note this <code class="text-uppercase">process cannot be reversed</code>.
                            <hr/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Requested Topup Amount
                                    </label>
                                    <div class="form-control">{{ $topupHistory->amount }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $topupHistory->remark }}</div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <div class="text-info">View Proof Document:
                                        <a href="{{ storage('wallets/topup/' . $topupHistory->proof_documentation) }}" target="_blank">View Proof</a>
                                    </div>
                                    <hr>
                                    <div class="text-info">View Profile Details:
                                        <a href="{{ route('admin.users.profile.show', $topupHistory->receiver) }}" target="_blank">View Profile</a>
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
                        <button type="submit" class="btn btn-info" id="approveRequest">APPROVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/users/wallets/confirm-topup-request.js') }}"></script>
    @endpush
</x-backend.layouts.app>
