<x-backend.layouts.app>
    @section('title', 'Purchase '. $package->name. ' | Buy Package')
    @section('header-title', 'Purchase '. $package->name )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item"><a href="{{ route('user.packages.index') }}">Buy Packages</a></li>
        <li class="breadcrumb-item active">Manual Purchase</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="manual-purchase-form">
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
                                <b>Up to {{ $package->daily_leverage }}% </b>Daily Leverage
                            </p>
                            <hr>
                            <p>Please <code>Deposit above total amount</code> to given binance wallet address and request the package with <code>payment slip (Proof)</code>.</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Binance Wallet</label>
                                    <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto my-2">
                                        <span class="fs-17">TMovRiofAPRMr4uZHXS9gJuwMxbWvHW9Sq</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select data-input='payout' class="single-select-placeholder js-states select2-hidden-accessible" id="purchase_for">
                                        <option disabled>Start typing username</option>
                                        @if($purchase_for !== null)
                                            <option value="{{ $purchase_for->id }}">{{ $purchase_for->id . ' - ' . $purchase_for->name . " - " . $purchase_for->username }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="proof_document">Payment Slip</label>
                                    <input class="form-control" data-input='payout' type="file" name='proof_document' id='proof_document'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="package" value="{{ $package->slug }}" id="package_slug">
                        <button type="submit" class="btn btn-primary" id="requestManualPurchase">REQUEST</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/manual-purchase.js') }}"></script>
    @endpush
</x-backend.layouts.app>
