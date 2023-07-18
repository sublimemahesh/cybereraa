<x-backend.layouts.app>
    @section('title', 'Purchase '. $package->name. ' | Buy Package')
    @section('header-title', 'Purchase '. $package->name )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item"><a href="{{ route('user.staking-packages.index') }}">Staking Packages</a></li>
        <li class="breadcrumb-item active">Choose Staking Plan</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                @forelse($plans as $plan)
                    <div class="col-xl-4 col-md-6 col-sm-12 col-lg-4">
                        <div class="card text-center">
                            <div class="card-header">
                                <h5 class="card-title">{{ $plan->name }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <ul class="list-group">
                                        <li class="list-group-item"><b>Duration </b>{{ $plan->duration }} Days</li>
                                        <li class="list-group-item"><b>Interest </b>{{ $plan->interest_rate }}%</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-xl-12">
                        No plans available
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <div class="mb-4">
                            <p>
                                If you want to purchase a package for <code>someone else</code>,
                                Please <code>search username in below box</code> and <code>select the
                                    username</code> you want to purchase package for.
                            </p>
                            <div>
                                Please Note:
                                <ul class="list-disc">
                                    <li class="mt-2">If you want to purchase a package for <code>Yourself</code> Please
                                        <code>keep the select box empty</code>
                                    </li>
                                    <li class="mt-2">
                                        <code>GAS FEE</code> will be added to the every order.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="mb-3 mt-2">
                                <label for="purchase_for">Deposit Amount</label>
                                <div class="form-control">USDT {{ $package->amount }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3 mt-2">
                                    <label for="staking-plan">Choose Plan <span class="text-danger">*</span></label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible"
                                            id="staking-plan">
                                        <option value="">Start Choosing staking plan</option>
                                        @forelse($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }} - {{ $plan->duration }}
                                                Days
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4 d-none">
                                <div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible"
                                            id="purchase_for">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-wallet cursor-pointer" id="main-wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-wallet fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h6>MAIN WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-topup-wallet cursor-pointer" id="topup-wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-chart-line fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h6>TOPUP WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-binance-pay cursor-pointer" id="binance-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-qrcode fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h6>BINANCE PAY</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-manual-pay cursor-pointer" id="manual-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-hand fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h6>MANUAL PAY</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="manual-pay-method-modal">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Staking Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="theme-form" enctype="multipart/form-data" id="manual-purchase-form">
                            <div class="mb-2">
                                <p>
                                    <b>Total Amount: </b>
                                    <code>{{ $package->currency }} {{ $package->amount + $package->gas_fee }}</code>
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
                                <p>Please <code>Deposit above total amount</code> to given binance wallet address and
                                    request the package with <code>payment slip (Proof)</code>.</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3 mt-2">
                                        <label for="payout_info">Binance Wallet Address</label>
                                        <div id="payout_info" disabled rows="3" placeholder="Remark"
                                             class="form-control h-auto my-2">
                                            <span class="fs-17">TLbnK7HxaasQKN67RqtAZ7t59NJ3JupmQh</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-3 mt-2">
                                        <label for="manual_staking_plan">Selected Staking Plan</label>
                                        <div class="form-control" id="manual_staking_plan">Yourself</div>
                                    </div>
                                    <div class="mb-3 mt-2">
                                        <label for="manual_purchase_for">You are Purchase this Plan For</label>
                                        <div class="form-control" id="manual_purchase_for">Yourself</div>
                                    </div>
                                    <div class="mb-3 mt-2">
                                        <label for="proof_document">Payment Slip</label>
                                        <input class="form-control" data-input='payout' type="file"
                                               name='proof_document' id='proof_document'>
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


        <div class="modal fade" id="temp-binance-pay">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Binance Pay Wallet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>
                                Please make a payment and inform us.
                            </p>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <div class="card bg-secondary cursor-pointer">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            {{--<div class="mb-3"></div>--}}
                                            {{--<img class="w-100" src="{{ asset('assets/backend/images/wallets/safe.png') }}" alt="wallet-address">--}}
                                            <div class="my-2">
                                                <span class="fs-17">TLbnK7HxaasQKN67RqtAZ7t59NJ3JupmQh</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/staking/purchase.js') }}"></script>
    @endpush
</x-backend.layouts.app>
