<x-backend.layouts.app>
    @section('title', 'Withdraw Wallets | Profits')
    @section('header-title', 'Withdraw Wallets | Profits' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item"><a href="{{ route('admin.admin-wallet-profits') }}">Wallets</a></li>
        <li class="breadcrumb-item active">Withdraw Profits</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">{{ str_replace("_"," ",$wallet->wallet_type) }}</h4>
                        <p>
                            Withdraw profits from Admin Wallet. <br>
                            {{ str_replace("_"," ",$wallet->wallet_type) }} BALANCE: <code>USDT {{ number_format($wallet->balance,2) }}</code>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="withdraw-form" encryption="multipart/form-data">
                                <div class="mb-3 mt-2">
                                    <label for="amount">Amount </label>
                                    <input name="amount" min="1" id="amount" type="number" placeholder="Withdraw Amount" class="form-control">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="proof-document">Proof</label>
                                    <input name="proof_document" id="proof-document" type="file" class="form-control" accept="image/*,application/pdf">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea name="remark" id="remark" type="number" placeholder="Remark" class="form-control"> </textarea>
                                </div>
                                <hr>
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input name="password" id="password" type="password" class="form-control" autocomplete="new-password">
                                </div>
                                @if(Auth::user()?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code </label>
                                        <input name="code" id="code" type="password" class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                <button type="submit" id="confirm-topup" class="btn btn-sm btn-success mb-2">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/admin-wallets/withdraw.js') }}"></script>
    @endpush
</x-backend.layouts.app>
