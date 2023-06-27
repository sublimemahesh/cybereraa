<x-backend.layouts.app>
    @section('title', 'Wallet Transfer Funds')
    @section('header-title', 'Wallet Transfer Funds' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Own account Transfer</li>
    @endsection
    <div class="row">
        @include('backend.user.wallet.top-nav')
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Transfer Between wallet</h4>
                        <p>
                            When payout limit is reached 0, All the active packages will be expired. <br>
                            (The withdrawal limit is reduced only when withdrawing money using the main wallet)
                        </p>
                        <p>
                            Purchase a new package to increase your payout limit
                        </p>
                        <p>
                            MAIN WALLET <br>
                            &emsp; Balance: <code>USDT {{ $wallet->balance }}</code> <br>
                            &emsp; Payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code>
                        </p>

                        <p>
                            TOPUP WALLET <br>
                            &emsp; Balance: <code>USDT {{ $wallet->topup_balance }}</code>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form>
                                <div class="mb-3 mt-2">
                                    <label>From</label>
                                    <div class="form-control">
                                        Main Wallet
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="to-wallet">Send To</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="to-wallet">
                                        <option value="topup">Topup Wallet</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">
                                        Transfer Amount
                                        (Balance: <code>USDT {{ $wallet->balance }}</code> /
                                        Payout limit: <code>USDT {{ $wallet->withdraw_limit }}</code>)
                                    </label>
                                    <input min="1" max="{{ $max_withdraw_limit }}" id="transfer-amount" type="number" class="form-control">
                                </div>

                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" name="remark" rows="3" placeholder="Remark" class="form-control h-auto"></textarea>
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
                                @if(auth()->user()?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(auth()->user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code</label>
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

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header justify-content-between border-0">
                    <h2 class="heading mb-0">Latest Transaction</h2>
                </div>
                <div class="card-body pt-0 px-4">
                    <div class="table-responsive">
                        <table class="table-responsive table shadow-hover mb-4 dataTable no-footer" id="example6" style="table-layout: fixed;width:100%">
                            <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>AMOUNT</th>
                                <th>FEE</th>
                                <th>REMARK</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transfer_histories as $history)
                                <tr>
                                    <td class="fs-16 font-w700 py-2">{{ $history->from }} Wallet</td>
                                    <td class="fs-14 font-w400">{{ $history->to }} Wallet</td>
                                    <td class="fs-14 font-w400">USDT {{ number_format($history->amount,2) }}</td>
                                    <td class="fs-14 font-w400">USDT {{ number_format($history->fee,2) }}</td>
                                    <td class="fs-14 font-w400">{{ $history->remark }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center">No Transaction Available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-pagenation d-flex align-items-center justify-content-end">
                        {{--<p>Showing <span> {{ $transfer_histories->firstItem() }}-{{ $transfer_histories->lastItem() }} </span> from <span> {{ $transfer_histories->total() }} </span> data </p>--}}
                        {{ $transfer_histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const MAX_WITHDRAW_LIMIT = "{{ $max_withdraw_limit }}";
        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/wallet/between-wallet-transfer.js') }}"></script>
    @endpush
</x-backend.layouts.app>
