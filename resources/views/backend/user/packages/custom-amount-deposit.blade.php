<x-backend.layouts.app>
    @section('title', 'Buy Package')
    @section('header-title', 'Packages' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/custom-range.css') }}">

    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Buy Package</li>
    @endsection


    <div class="row">
        @include('backend.user.transactions.top-nav')

        <div class="col-xl-12 col-md-12 col-sm-12 col-lg-12">
            <div class="card text-center">
                <div class="card-header bp-header-txt">
                    <h5 class="card-title">{{ $package->name }} Invest Your Own Amount</h5>
                </div>
                <div class="card-body">
                    <div class="basic-list-group">





                        <div class="row">
                            <div class="col-2" >
                                <div class="card text-center" data-devil="bgc:#aa1195 c:white">
                                    <div class="card-body" >
                                <b>Price </b>USDT {{ $package->amount }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="card text-center" data-devil="bgc:#aa1195 c:white">
                                    <div class="card-body">
                                        <b>Gas Fee </b>USDT {{ $package->gas_fee }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card text-center" data-devil="bgc:#aa1195 c:white">
                                    <div class="card-body">
                                        <b>Package </b>{{ $package->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card text-center" data-devil="bgc:#aa1195 c:white">
                                    <div class="card-body">
                                        Within Investment Period
                                    </div>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="card text-center" data-devil="bgc:#aa1195 c:white">
                                    <div class="card-body">
                                        <b> 0.4% - 1.3% </b> Daily Profit
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <div class="form-group mt-5">
                                <label for="custom-deposit-amount"> Enter the amount</label>
                                <input type="number" name="amount" step="0.1" value="5" min="5" max="50000" id="custom-deposit-amount" class="form-control no-hover-style"/>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>

                    <div>

                        <div class="range-slider">
                          <span id="rs-bullet" class="rs-label">10</span>
                          <input id="rs-range-line" class="rs-range" type="range" value="10" min="10" max="2500">

                        </div>

                        <div class="box-minmax">
                          <span>10</span><span>2500</span>
                        </div>

                    </div>




                    <button type="button" class="btn btn-primary bp-price-btn no-hover-style" id="total-amount" data-devil='mt:4'>
                        USDT {{ 5 + $package->gas_fee }}
                    </button>

                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary mb-2" id="{{ $package->slug }}-choose">Deposit</button>
                </div>
            </div>
        </div>

    </div>

    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="pay-method-modal">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Payment method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>
                                Please <code>search username in the below box</code> and <code>select the username</code> you want to purchase the package If you want to purchase a package for <code>someone else</code>.
                            </p>
                            <div>
                                Please Note:
                                <ul class="list-disc">
                                    <li class="mt-2">
                                        If you want to purchase a package for <code>Yourself</code>. Please <code>keep the select box empty</code>
                                    </li>
                                    <li class="mt-2">
                                        <code>GAS FEE</code> will be added to every order.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible" id="purchase_for">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-wallet cursor-pointer" id="wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/main-wallet.png') }}" alt="">
                                            <div class="mb-3"></div>
                                            <h6> INTERNAL WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-topup-wallet cursor-pointer" id="topup-wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/topup-wallet.png') }}" alt="logo"/>
                                            <div class="mb-3"></div>
                                            {{-- <h6>TOPUP WALLET</h6> --}}
                                            <h6> EXTERNAL WALLET</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-binance-pay cursor-pointer" id="binance-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/binance.png') }}" alt="logo"/>
                                            <div class="mb-3"></div>
                                            <h6>BINANCE PAY</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-secondary pay-method-manual-pay cursor-pointer" id="manual-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/manual.png') }}" alt="logo"/>
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
                                            <div class="mb-3"></div>
                                            <img class="w-100 img-thumbnail" src="{{ asset('assets/images/binance-qr.jpg') }}" alt="wallet-address">
                                            <div class="mt-4">
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
        <script !src="">
            $('#custom-deposit-amount').change(function (e) {
                let amount = parseFloat($(this).val())
                let total_amount = parseFloat({{ $package->gas_fee }}) + amount;
                $('#total-amount').html('USDT ' + total_amount)
            })

            $('#rs-range-line').change(function (e) {
                let amount = parseFloat($(this).val())
                let total_amount = parseFloat({{ $package->gas_fee }}) + amount;
                $('#total-amount').html('USDT ' + total_amount)
            })

        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/custom-package.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/range.js') }}"></script>
    @endpush
</x-backend.layouts.app>
