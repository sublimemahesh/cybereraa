<x-backend.layouts.app>
    @section('title', 'Transfer Funds')
    @section('header-title', 'Transfer Funds' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Peer To Peer Transfer Funds</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">P2P Transfer</h4>
                        <p>
                            Please note that
                            <code>USDT {{ $p2p_transfer_fee->value }}</code>
                            transaction fee will be added with the every transfer.
                            Your Wallet Balance: <code>USDT {{ $wallet->balance }}</code>
                            Your current payout limit:
                            <code>USDT {{ $wallet->withdraw_limit }}</code> (Purchase a new package to increase your payout limit)
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form x-data="{transfer_amount: '{{$minimum_payout_limit->value}}' }">
                                <div class="mb-3 mt-2">
                                    <label for="p2p-transfer">Select User</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="p2p-transfer">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Transfer Amount (Balance:
                                        <code>USDT {{ $wallet->balance }}</code> / Payout limit:
                                        <code>USDT {{ $wallet->withdraw_limit }}</code>)</label>
                                    <input min="{{ $minimum_payout_limit->value }}" x-model="transfer_amount" id="transfer-amount" type="number" class="form-control">
                                    <div class="text-info">Receiving Amount:
                                        <code id="show-receiving-amount" x-html=" 'USDT ' + (transfer_amount - {{ $p2p_transfer_fee->value }})"></code>
                                    </div>
                                </div>

                                <hr>
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" autocomplete="new-password">
                                </div>
                                @if(optional(Auth::user())->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code </label>
                                        <input id="code" type="password" class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                <button type="submit" id="confirm-transfer" class="btn btn-sm btn-success mb-2">Confirm & Transfer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const MINIMUM_PAYOUT_LIMIT = "{{ $minimum_payout_limit->value }}";
            const P2P_TRANSFER_FEE = "{{ $p2p_transfer_fee->value }}";
            const MAX_WITHDRAW_LIMIT = "{{ $max_withdraw_limit }}";
        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/wallet/p2p-transfer.js') }}"></script>
    @endpush
</x-backend.layouts.app>