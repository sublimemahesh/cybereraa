<x-backend.layouts.app>
    @section('title', 'My Withdrawals')
    @section('header-title', 'My Withdrawals' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Make withdrawal request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Binance Payout</h4>
                        <p>
                            Please note that
                            <code>USDT {{ $payout_transfer_fee->value }}</code>
                            transaction fee will be added with the every withdrawal request.
                        </p>
                        <p>
                            Your Wallet Balance: <code>USDT {{ $wallet->balance }}</code>
                            Your current payout limit:
                            <code>USDT {{ $wallet->withdraw_limit }}</code> (Purchase a new package to increase your payout limit)
                        </p>
                        <p>When payout limit is reached 0, All the active packages will be expired. (The withdrawal limit is reduced only when withdrawing money using the main wallet)</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form x-data="{payout_amount: {{$minimum_payout_limit->value}} }">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Withdrawal Amount (Balance:
                                        <code>USDT {{ $wallet->balance }}</code> / Payout limit:
                                        <code>USDT {{ $wallet->withdraw_limit }}</code>)
                                    </label>
                                    <input min="{{ $minimum_payout_limit->value }}" x-model="payout_amount" id="withdraw-amount" type="number" class="form-control">
                                    <div class="text-info">Total Amount:
                                        <code id="show-receiving-amount" x-html=" 'USDT ' + (parseFloat(payout_amount) + {{ (float) $payout_transfer_fee->value }})"></code>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" name="remark" rows="3" placeholder="Remark" class="form-control h-auto"></textarea>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                        <p class="mb-0"><b>Email:</b> {{ $profile->binance_email }}</p>
                                        <p class="mb-0"><b>Id:</b> {{ $profile->binance_id }}</p>
                                        <p class="mb-0"><b>Address:</b> {{ $profile->wallet_address }}</p>
                                        <p class="mb-0"><b>Phone:</b> {{ $profile->binance_phone }}</p>
                                    </div>
                                    <div class="text-info">Change Details:
                                        <a href="{{ route('profile.show') }}">Edit Profile</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="payout-container">
                                    <div class="title">Choose a Wallet</div>
                                    <div class="plans row">
                                        <label class="plan basic-plan col-sm-4" for="main">
                                            <input checked value="main" type="radio" name="wallet_type" id="main"/>
                                            <div class="plan-content">
                                                <img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/life-saver-img.svg" alt=""/>
                                                <div class="plan-details">
                                                    <span>Main Wallet</span>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="plan complete-plan col-sm-4" for="topup" title="Coming soon...">
                                            <input type="radio" id="topup" name="wallet_type" value="topup" disabled/>
                                            <div class="plan-content">
                                                <img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/potted-plant-img.svg" alt=""/>
                                                <div class="plan-details">
                                                    <span>Topup Wallet</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="coin-warpper d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <ul class="nav nav-pills">
                                            <li class="nav-item wow fadeInUp">
                                                <a href="javascript:void(0)" class="nav-link bitcoin ms-0 active">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/usdt.png')}}" alt="visa">
                                                    USDT
                                                </a>
                                            </li>
                                            <li class=" nav-item wow fadeInUp">
                                                <button class="nav-link bitcoin ms-0 disabled">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/bitcoin.png')}}" alt="Bitcoin">
                                                    Bitcoin
                                                </button>
                                            </li>
                                            <li class=" nav-item wow fadeInUp">
                                                <button class="nav-link bitcoin ms-0 disabled">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/etherium.png')}}" alt="etherium">
                                                    Etherium
                                                </button>
                                            </li>
                                        </ul>
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
                                @if(Auth::user()?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code </label>
                                        <input id="code" type="password" class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                <button type="submit" id="confirm-payout" class="btn btn-sm btn-success mb-2">Confirm & Withdraw</button>
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
            const P2P_TRANSFER_FEE = "{{ $payout_transfer_fee->value }}";
            const MAX_WITHDRAW_LIMIT = "{{ $max_withdraw_limit }}";
        </script>
        <script src="{{ asset('assets/backend/js/user/wallet/binance-payout.js') }}"></script>
    @endpush
</x-backend.layouts.app>
