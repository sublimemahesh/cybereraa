<x-backend.layouts.app>
    @section('title', 'Purchase '. $package->name. ' | Buy Package')
    @section('header-title', 'Purchase '. $package->name. ' Package' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.packages.index') }}">Buy Packages</a>
        </li>
        <li class="breadcrumb-item active">Manual Purchase</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="manual-purchase-edit-form">
                        <div class="mb-2">
                            <h4 class="card-title">Request {{ $package->name }} package</h4>
                            <hr>
                            <p>
                                <b>Total Amount: </b> <code>{{ $package->currency }} {{ $package->amount + $package->gas_fee }}</code>
                            </p>
                            <p>
                                <b>Price: </b><code>USDT {{ $package->amount }}</code>
                            </p>
                            <p>
                                <b>Gas Fee: </b><code>USDT {{ $package->gas_fee }}</code>
                            </p>
                            <p>
                                <b>Package: </b>{{ $package->name }}
                            </p>
                            <p>
                                <b>During {{ $package->month_of_period }} </b> Month Of Period
                            </p>
                            <p>
                                <b> 0.3% - 0.7% </b>Daily Leverage
                            </p>
                            <hr>
                            <p>
                                Please <code>Deposit the above total amount</code> to the given Binance wallet address and request the package with <code> a payment slip (Proof)</code>.
                            </p>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Binance Wallet</label>
                                    <div class="row mb-3">
                                        <div class="col-md-12 col-lg-5">
                                            <img class="w-100 img-thumbnail" src="{{ storage("pages/{$wallet_page->image}") }}" alt="wallet-address">
                                        </div>
                                    </div>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto my-2  copy-to-clipboard cursor-pointer" data-clipboard-text="{{ strip_tags($wallet_page->content) }}" title="Copy Text">
                                        {{ strip_tags($wallet_page->content) }}
                                        <i class="fa fa-clone copy-binance" data-devil="fs:17 "></i>
                                    </div>
                                    <code id='copy-result'></code>

                                </div>
                                <hr>

                                <div class="form-group mt-3">
                                    <label for="custom-deposit-amount"> Enter the amount</label>
                                    <input type="number" name="amount" step="0.1"
                                           value="{{ $min_custom_investment->value }}"
                                           min="{{ $min_custom_investment->value }}" max="{{ $max_custom_investment->value }}"
                                           id="custom-deposit-amount" class="form-control " data-devil='fs:16'>
                                </div>
                                <div>
                                    <div class="fs-30 text-center font-w600" data-devil="c:#fff">
                                        Total Amount: <span id="total-amount">{{ $package->amount + $package->gas_fee }} USDT</span>
                                    </div>
                                    <div class="text-center">Without network fee</div>
                                </div>
                                <hr>
                                {{--<div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select data-input='payout' class="single-select-placeholder js-states select2-hidden-accessible" id="purchase_for">
                                        <option disabled>Start typing username</option>
                                        @if($purchase_for !== null)
                                            <option value="{{ $purchase_for->id }}">{{ $purchase_for->id . ' - ' . $purchase_for->name . " - " . $purchase_for->username }}</option>
                                        @endif
                                    </select>
                                </div>--}}
                                <div class="mb-3 mt-2">
                                    <label for="transaction_id">Transaction ID <sup class="text-danger">*</sup></label>
                                    <input class="form-control" value="{{ $transaction->transaction_id }}" data-input='payout' type="text" name='transaction_id' id='transaction_id' placeholder="Enter the transaction id mentioned in payment slip">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="proof_document">Payment Slip <sup class="text-danger">*</sup></label>
                                    <input class="form-control" data-input='payout' type="file" name='proof_document' id='proof_document'>
                                    <img src="{{ storage('user/manual-purchase/' . $transaction->proof_document) }}" class="img-thumbnail mt-3 w-25" alt="">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="package" value="{{ $package->slug }}" id="package_slug">
{{--                        <input type="hidden" name="amount" value="{{ $package->amount }}" id="custom-deposit-amount">--}}
                        <div class="d-flex justify-content-evenly">
                            <a href="{{ route('user.transactions.purchased.history') }}" class="btn btn-primary">GO BACK</a>
                            <button type="submit" class="btn btn-success" id="updateTransaction">REQUEST</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/manual-purchase-edit.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>
        <script !src="">
            $('#custom-deposit-amount').change(function (e) {
                let amount = parseFloat($(this).val())
                let gas_fee = (amount * parseFloat({{ $custom_investment_gas_fee->value }})) / 100
                let total_amount = amount + gas_fee;
                $('#total-amount').html('USDT ' + total_amount)
                $('#pkg-price').html('USDT ' + amount)
                $('#pkg-gas-fee').html('USDT ' + gas_fee)


            })
        </script>
        <script !src="">
            let clipboard = new ClipboardJS('.copy-to-clipboard');

            // Handle copy success
            clipboard.on('success', function (e) {
                Toast.fire({
                    icon: 'success', title: 'Address copied to clipboard!',
                })
                e.clearSelection();
            });
        </script>
    @endpush
</x-backend.layouts.app>
