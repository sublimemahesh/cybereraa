<x-backend.layouts.app>
    @section('title', 'Buy Package')
    @section('header-title', 'Packages' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Buy Package</li>
    @endsection


    <div class="row">
        @include('backend.user.transactions.top-nav')
        @foreach($packages as $package)
            {{--@php
                $gas_fee = $is_gas_fee_added ? $package->gas_fee : 0;
            @endphp--}}
            <div class="col-xl-3 col-md-6 col-sm-12 col-lg-3">
                <div class="card text-center">
                    <div class="card-header bp-header-txt">
                        <h5 class="card-title">{{ $package->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <ul class="list-group">

                                <li class="list-group-item"><b>Price </b>USDT {{ $package->amount }}</li>
                                <li class="list-group-item">
                                    {{--@if(!$is_gas_fee_added)
                                        <del><b>Gas Fee </b>USDT {{ $package->gas_fee }}</del>
                                    @endif
                                    @if($is_gas_fee_added)--}}
                                    <b>Gas Fee </b>USDT {{ $package->gas_fee }}
                                    {{--@endif--}}
                                </li>
                                <li class="list-group-item"><b>Package </b>{{ $package->name }}</li>
                                <li class="list-group-item">
                                    Within Investment Period
                                </li>
                                <li class="list-group-item">
                                    <b> {{--{{ $package->daily_leverage }} %--}} 0.4% - 1.3% </b> Daily Profit
                                </li>
                            </ul>
                        </div>

                        <button type="button" class="btn btn-primary bp-price-btn no-hover-style"> {{ $package->currency }} {{ $package->amount + $package->gas_fee }}</button>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary mb-2" id="{{ $package->slug }}-choose">Choose</button>
                    </div>
                </div>
            </div>
        @endforeach

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
        <script>
            const ALLOWED_PACKAGES = {!! json_encode($packages->pluck('slug'),JSON_THROW_ON_ERROR) !!};
        </script>
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/packages/choose.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="{{ asset('assets/backend/js/packages/gift_slider.js') }}"></script>
    @endpush
</x-backend.layouts.app>
