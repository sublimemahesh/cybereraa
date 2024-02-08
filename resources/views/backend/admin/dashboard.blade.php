<x-backend.layouts.app>
    @section('title', 'Admin Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Dashboard</a>
        </li>
    @endsection

    <div class="row" data-devil="mb:6" data-dxs="mb:0">
        <div class="col-xxl-12">
            <div class="overflow-hidden dz-crypto-scroll shadow-none">
                <div class="js-conveyor-example">
                    <ul class="crypto-list" id="crypto-webticker">
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="bitcoin-change"></span>
                                        </p>
                                        <h4 class="bitcoin"></h4>
                                    </div>
                                    <img src="{{asset('assets/frontend/images/coin-icon/bitcoin-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="litecoin-change"></span>
                                        </p>
                                        <h4 class="litecoin"></h4>
                                    </div>
                                    <img src="{{asset('assets/frontend/images/coin-icon/litecoin-big.png') }}"
                                         width="42" height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="ethereum-change"></span>
                                        </p>
                                        <h4 class="ethereum"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/ethereum-big.png') }}"
                                         width="42" height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="tron-change"></span>
                                        </p>
                                        <h4 class="tron"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/tron-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="cardano-change"></span>
                                        </p>
                                        <h4 class="cardano"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/cardano-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="dai-change"></span>
                                        </p>
                                        <h4 class="dai"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/dai-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="dogecoin-change"></span>
                                        </p>
                                        <h4 class="dogecoin"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/dogecoin-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="uniswap-change"></span>
                                        </p>
                                        <h4 class="uniswap"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/uniswap-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/webticker/jquery.webticker.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/coin_prices.js') }}"></script>
        <script>
            let userDash = function () {
                "use strict"
                /* Search Bar ============ */
                var screenWidth = $(window).width();
                var screenHeight = $(window).height();
                var handleWebpicker = function () {
                    $('#crypto-webticker').webTicker({
                        height: '90px',
                        duplicate: true,
                        startEmpty: false,
                        rssfrequency: 4
                    });
                }
                return {
                    init: function () {
                    },
                    resize: function () {
                    },

                    load: function () {
                        handleWebpicker();
                    },
                }
            }();


            /* Document.ready Start */
            jQuery(document).ready(function () {
                $('[data-bs-toggle="popover"]').popover();
                'use strict';
                userDash.init();

            });
            /* Document.ready END */

            /* Window Load START */
            jQuery(window).on('load', function () {
                'use strict';
                userDash.load();
            });
            /*  Window Load END */
            /* Window Resize START */
            jQuery(window).on('resize', function () {
                'use strict';
                userDash.resize();
            });

        </script>
    @endpush
</x-backend.layouts.app>

