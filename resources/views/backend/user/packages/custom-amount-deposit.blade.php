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

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <div class="form-group mt-3">
                                <label for="custom-deposit-amount"> Enter the amount</label>
                                <input type="number" name="amount" step="0.1"
                                       value="{{ $min_custom_investment->value }}"
                                       min="{{ $min_custom_investment->value }}" max="{{ $max_custom_investment->value }}"
                                       id="custom-deposit-amount" class="form-control " data-devil='fs:16'>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>

                    <div data-devil="dis:none">

                        <div class="range-slider">
                            <span id="rs-bullet" class="rs-label">10</span>
                            <input id="rs-range-line" class="rs-range" type="range"
                                   value="{{ $min_custom_investment->value }}" min="{{ $min_custom_investment->value }}"
                                   max="{{ $max_custom_investment->value }}">

                        </div>

                        <div class="box-minmax">
                            <span>{{ $min_custom_investment->value }}</span><span>{{ $max_custom_investment->value
                                }}</span>
                        </div>

                    </div>
                    <br>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary bp-price-btn no-hover-style" data-devil='mt:2'>
                            TOTAL AMOUNT: <span id="total-amount">USDT {{ $package->amount + ($package->amount *
                                $package->gas_fee) /100 }}</span>
                        </button>
                        <br>
                        <button type="button" class="btn   mb-2" id="{{ $package->slug }}-choose"
                                data-devil="ml:20 mt:30 bgc:#18998f c:#fff w:150">Deposit
                        </button>
                    </div>


                    <div class="basic-list-group" data-devil="mt:60">
                        <div class="row">


                            <div class="col-xl-4 col-lg-3 col-sm-2">
                                <div class="widget-stat card rounded-3" data-devil='bgc:#22223c'>
                                    <div class="card-body  p-4">
                                        <div class="col-mb-12 ">
                                            <div class="media justify-content-center dash-p-10">
                                                <span class="me-3 justify-content-center"><i
                                                        class="fa-solid fa-dollar-sign"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-mb-12">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1 dash-p">
                                                        <b>Price </b>
                                                        <span id="pkg-price">USDT {{ $package->amount }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-4 col-lg-3 col-sm-2">
                                <div class="widget-stat card rounded-3" data-devil='bgc:#22223c'>
                                    <div class="card-body  p-4">
                                        <div class="col-mb-12 ">
                                            <div class="media justify-content-center dash-p-10">
                                                <span class="me-3 justify-content-center"><i
                                                        class="fa-solid fa-fire-flame-simple"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-mb-12">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1 dash-p">
                                                        <b>Gas Fee ({{ $package->gas_fee }}%)</b>
                                                        <span id="pkg-gas-fee">USDT {{ ($package->amount *
                                                            $package->gas_fee) /100 }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="col-xl-2 col-lg-3 col-sm-2">
                                <div class="widget-stat card rounded-3 " data-devil='bgc:#22223c'>
                                    <div class="card-body  p-4">
                                        <div class="col-mb-12 ">
                                            <div class="media justify-content-center dash-p-10">
                                                <span class="me-3 justify-content-center"><i
                                                        class="fa-solid fa-box-archive"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-mb-12">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1 dash-p"><b>Package </b>{{ $package->name }} </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> --}}


                            {{-- <div class="col-xl-2 col-lg-3 col-sm-2">
                                <div class="widget-stat card rounded-3 " data-devil='bgc:#22223c'>
                                    <div class="card-body  p-4">
                                        <div class="col-mb-12 ">
                                            <div class="media justify-content-center dash-p-10">
                                                <span class="me-3 justify-content-center"><i
                                                        class="fa-solid fa-sack-dollar"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-mb-12">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1 dash-p"> Within Investment Period</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-xl-4 col-lg-3 col-sm-2">
                                <div class="widget-stat card rounded-3 " data-devil='bgc:#22223c'>
                                    <div class="card-body  p-4">
                                        <div class="col-mb-12 ">
                                            <div class="media justify-content-center dash-p-10">
                                                <span class="me-3 justify-content-center"><i
                                                        class="fa-solid fa-money-bill-trend-up"></i></span></center>
                                            </div>
                                        </div>

                                        <div class="col-mb-12">
                                            <div class="media">
                                                <div class="media-body text-white">
                                                    <p class="mb-1 dash-p"><b> 0.3% - 0.7% </b> Daily Profit </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>


                </div>
                <div class="card-footer">

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
                                Please <code>search username in the below box</code> and <code>select the username</code>
                                you want to purchase the package If you want to purchase a package for
                                <code>someone else</code>.
                            </p>
                            <div>
                                Please Note:
                                <ul class="list-disc">
                                    <li class="mt-2">
                                        If you want to purchase a package for <code>Yourself</code>. Please
                                        <code>keep the select box empty</code>
                                    </li>
                                    <li class="mt-2">
                                        <code>GAS FEE</code> will be added to every order.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-4" data-devil="dis:none">
                                <div class="mb-3 mt-2">
                                    <label for="purchase_for">Purchase For</label>
                                    <select class="single-select-placeholder js-states select2-hidden-accessible"
                                            id="purchase_for">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 d-none">
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
                            <div class="col-sm-6 d-none">
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
                            <div class="col-sm-6 d-none">
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
                                            <img class="w-100 img-thumbnail"
                                                 src="{{ asset('assets/images/binance-qr.jpg') }}" alt="wallet-address">
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
                let gas_fee = (amount * parseFloat({{ $package->gas_fee }})) / 100
                let total_amount = amount + gas_fee;
                $('#total-amount').html('USDT ' + total_amount)
                $('#pkg-price').html('USDT ' + amount)
                $('#pkg-gas-fee').html('USDT ' + gas_fee)
            })

            $('#rs-range-line').change(function (e) {
                let amount = parseFloat($(this).val())
                let gas_fee = (amount * parseFloat({{ $package->gas_fee }})) / 100
                let total_amount = amount + gas_fee;
                $('#total-amount').html('USDT ' + total_amount)
                $('#pkg-price').html('USDT ' + amount)
                $('#pkg-gas-fee').html('USDT ' + gas_fee)
            })


        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/custom-package.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/range.js') }}"></script>
    @endpush
</x-backend.layouts.app>
