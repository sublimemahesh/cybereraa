<x-backend.layouts.app>
    @section('title', 'Transfer Funds')
    @section('header-title', 'Transfer Funds' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Peer To Peer Transfer Funds</li>
    @endsection
    <div class="row">
        @include('backend.user.wallet.top-nav')
        <div class="col-xl-8 col-sm-6">
            {{--<div class="alert alert-warning">P2P transactions are temporarily suspended for 24 hours from 4.00 Pm on 6th April 2023 to 4.00 pm on 7th April 2023!</div>--}}
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">P2P Transfer</h4>
                        <p>
                            Please note that
                            <code>USDT {{ $p2p_transfer_fee->value }}</code>
                            transaction fee will be added for every transfer.
                        </p>
                        <p>
                            Your Wallet Balance: <code>USDT {{ $wallet->balance }}</code>. <br>
                            Your current payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code> <br>
                            (Purchase a new package to increase your payout limit)
                        </p>

                        <p>All active packages will be expired when the payout limit is reached 0<br>
                            (Your withdrawal limit is reduced when withdrawing money using the internal wallet {{--main wallet--}})
                        </p>
                        <p>
                            INTERNAL WALLET
                            {{-- MAIN WALLET  --}}

                            <br>
                            &emsp; Balance: <code>USDT {{ $wallet->balance }}</code> <br>
                            &emsp; Payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code>
                        </p>

                        <p>
                            EXTERNAL WALLET <br>
                            {{-- TOPUP WALLET <br> --}}
                            &emsp; Balance: <code>USDT {{ $wallet->topup_balance }}</code>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form x-data="{transfer_amount: '{{$minimum_p2p_transfer_limit->value}}' }">
                                <div class="mb-3 mt-2">
                                    <label for="p2p-transfer">Select User</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="p2p-transfer">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Transfer Amount (Balance:
                                        <code>USDT {{ $wallet->balance }}</code> / Payout limit:
                                        <code>USDT {{ $wallet->withdraw_limit }}</code>)
                                    </label>
                                    <input min="{{ $minimum_p2p_transfer_limit->value }}" x-model="transfer_amount" id="transfer-amount" type="number" class="form-control">
                                    <div class="text-info">Total Amount:
                                        <code id="show-receiving-amount" x-html=" 'USDT ' + (parseFloat(transfer_amount) + {{ (float) $p2p_transfer_fee->value }})"></code>
                                    </div>
                                </div>
                                <hr>
                                <div class="payout-container">
                                    <div class="title">Choose a Wallet</div>
                                    <div class="plans row">
                                        <label class="plan basic-plan col-sm-4" for="main">
                                            <input checked value="main" type="radio" name="wallet_type" id="main"/>
                                            <div class="plan-content">
                                                <img loading="lazy"
                                                     src="{{ asset('assets/images/main-wallet.png') }}"
                                                     alt=""/>
                                                <div class="plan-details">
                                                    <span> Internal Wallet</span>
                                                    {{-- <span>Main Wallet</span> --}}
                                                </div>
                                            </div>
                                        </label>

                                        <label class="plan complete-plan col-sm-4" for="topup">
                                            <input type="radio" id="topup" name="wallet_type" value="topup"/>
                                            <div class="plan-content">
                                                <img loading="lazy"
                                                     src="{{ asset('assets/images/topup-wallet.png') }}"
                                                     alt=""/>
                                                <div class="plan-details">
                                                    <span>External Wallet</span>
                                                    {{-- <span>Topup Wallet</span> --}}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" name="remark" rows="3" placeholder="Remark"
                                              class="form-control h-auto"></textarea>
                                </div>
                                <hr>
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control"
                                           autocomplete="new-password">
                                </div>
                                @if(auth()->user()?->two_factor_secret && in_array(\Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(auth()->user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code</label>
                                        <input id="code" type="password" class="form-control"
                                               autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                <p>
                                    OTP code will be sent to Email: {{ substr(auth()->user()?->email, 0, 2) }}
                                    *****{{ substr(auth()->user()?->email, -9) }}
                                    @if(str_starts_with(auth()->user()?->phone, '+94'))
                                        and Phone:  {{ substr(auth()->user()?->phone, 0, 5) }}
                                        *****{{ substr(auth()->user()?->phone, -2) }}
                                    @endif
                                </p>
                                <div id="2ft-section">
                                    <button type="submit" id="send-2ft-code" class="btn btn-sm btn-google mb-2">Send
                                        Verification Code
                                    </button>
                                </div>
                                {{--<button type="submit" id="confirm-transfer" class="btn btn-sm btn-success mb-2">Confirm & Transfer</button>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const MINIMUM_PAYOUT_LIMIT = parseFloat("{{ $minimum_p2p_transfer_limit->value }}");
            const P2P_TRANSFER_FEE = parseFloat("{{ $p2p_transfer_fee->value }}");
            const MAX_WITHDRAW_LIMIT = parseFloat("{{ $max_withdraw_limit }}");
        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/wallet/p2p-transfer.js') }}"></script>
    @endpush
</x-backend.layouts.app>
