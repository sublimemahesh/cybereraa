<x-backend.layouts.app>
    @section('title', 'My Withdrawals')
    @section('header-title', 'My Withdrawals' )
    @section('plugin-styles')
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
                            Your Wallet Balance: <code>USDT {{ $wallet->balance }}</code>
                            Your current payout limit:
                            <code>USDT {{ $wallet->withdraw_limit }}</code> (Purchase a new package to increase your payout limit)
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form x-data="{payout_amount: '{{$minimum_payout_limit->value}}' }">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Withdrawal Amount (Balance:
                                        <code>USDT {{ $wallet->balance }}</code> / Payout limit:
                                        <code>USDT {{ $wallet->withdraw_limit }}</code>)
                                    </label>
                                    <input min="{{ $minimum_payout_limit->value }}" x-model="payout_amount" id="withdraw-amount" type="number" class="form-control">
                                    <div class="text-info">Receiving Amount:
                                        <code x-html=" 'USDT ' + (payout_amount - {{ $payout_transfer_fee->value }})"></code>
                                    </div>
                                </div>

                                <div class="coin-warpper d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <ul class="nav nav-pills" role="tablist">
                                            <li class=" nav-item wow fadeInUp" data-wow-delay="0.2s" role="presentation">
                                                <button class="nav-link bitcoin ms-0 active">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/usdt.png')}}" alt="visa">
                                                    USDT
                                                </button>
                                            </li>
                                            <li class=" nav-item wow fadeInUp" data-wow-delay="0.2s" role="presentation">
                                                <button class="nav-link bitcoin ms-0 disabled" id="nav-bitcoin-tab" data-bs-toggle="tab" data-bs-target="#nav-bitcoin" type="button" role="tab" aria-selected="true">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/bitcoin.png')}}" alt="Bitcoin">
                                                    Bitcoin
                                                </button>
                                            </li>
                                            <li class=" nav-item wow fadeInUp" data-wow-delay="0.2s" role="presentation">
                                                <button class="nav-link bitcoin ms-0 disabled" id="nav-bitcoin-tab" data-bs-toggle="tab" data-bs-target="#nav-bitcoin" type="button" role="tab" aria-selected="true">
                                                    <img width="24" src="{{asset('assets/backend/images/coins/etherium.png')}}" alt="etherium">
                                                    Etherium
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" autocomplete="new-password">
                                </div>
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