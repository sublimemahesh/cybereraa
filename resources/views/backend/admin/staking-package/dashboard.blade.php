<x-backend.layouts.app>
    @section('title', 'Admin Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name)
    @section('styles')
    @endsection

    <div class="row">
        <div class="col-xl-12">
            <div class="row main-card">
                <div class="col-xl-12">
                    <div class="swiper crypto-Swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card card-wiget">
                                    <div class="card-body">
                                        <div class="card-wiget-info">
                                            <h4 class="count-num">${{ number_format($total_sale_amount,2) }}</h4>
                                            <p>Total Sales <small>(GAS FEES: $ {{ $total_sale_gas_fees }}) </small></p>
                                        </div>
                                        <div id="NewCustomers"></div>
                                    </div>
                                    <div class="back-icon">
                                        <svg width="64" height="127" viewBox="0 0 64 127" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.05">
                                                <path
                                                    d="M70.1991 32.0409C63.3711 28.2675 56.1119 25.3926 48.9246 22.4098C44.7559 20.6849 40.7669 18.6724 37.2451 15.8694C30.3093 10.3351 31.639 1.3509 39.7607 -2.20684C42.0606 -3.21307 44.4684 -3.5365 46.9121 -3.68024C56.3275 -4.18336 65.2758 -2.4584 73.7928 1.63839C78.0333 3.68679 79.4349 3.03993 80.8723 -1.38029C82.3817 -6.05207 83.6395 -10.7957 85.041 -15.5034C85.9753 -18.6659 84.8254 -20.7502 81.8426 -22.0799C76.3802 -24.4876 70.7741 -26.2126 64.8805 -27.1469C57.19 -28.3329 57.19 -28.3688 57.1541 -36.0952C57.1181 -46.984 57.1181 -46.984 46.1934 -46.984C44.6122 -46.984 43.0309 -47.02 41.4497 -46.984C36.3467 -46.8403 35.4842 -45.9419 35.3405 -40.8029C35.2686 -38.503 35.3405 -36.203 35.3045 -33.8671C35.2686 -27.0391 35.2327 -27.1469 28.6922 -24.7751C12.88 -19.0252 3.1052 -8.24421 2.06304 9.00543C1.12868 24.2785 9.10664 34.5924 21.6486 42.1032C29.375 46.739 37.9279 49.4702 46.1215 53.0998C49.3199 54.5014 52.3745 56.1185 55.0338 58.3466C62.904 64.8512 61.4665 75.6681 52.1229 79.7649C47.1277 81.957 41.845 82.4961 36.4186 81.8133C28.0453 80.7711 20.0314 78.579 12.4847 74.6619C8.06447 72.3619 6.77075 72.9729 5.2614 77.7524C3.96768 81.8852 2.81771 86.0538 1.66773 90.2225C0.122451 95.8286 0.697435 97.1583 6.05201 99.7817C12.88 103.088 20.1752 104.777 27.6141 105.963C33.4358 106.897 33.6155 107.149 33.6874 113.186C33.7233 115.917 33.7233 118.684 33.7593 121.416C33.7952 124.866 35.4483 126.878 39.006 126.95C43.0309 127.022 47.0918 127.022 51.1167 126.914C54.4229 126.842 56.1119 125.045 56.1119 121.703C56.1119 117.966 56.2916 114.192 56.1478 110.455C55.9682 106.646 57.6213 104.705 61.2868 103.699C69.7319 101.399 76.9193 96.8708 82.4535 90.1147C97.8345 71.4276 91.9768 44.0797 70.1991 32.0409Z"
                                                    fill="#9568FF"/>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-wiget">
                                    <div class="card-body">
                                        <div class="card-wiget-info">
                                            <h4 class="count-num">${{ $total_earnings }}</h4>
                                            <p>Total User Earnings</p>
                                            <div>
                                                {{--<span class="text-success">+3.02%</span>--}}
                                            </div>
                                        </div>
                                        <div id="ProfitlossChart"></div>
                                    </div>
                                    <div class="back-icon">
                                        <svg width="157" height="114" viewBox="0 0 157 114" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.05">
                                                <path d="M12.1584 84.1906V110.157C12.1584 111.737 13.5953 113.053 15.4007 113.053H37.8751C39.6436 113.053 41.1173 111.77 41.1173 110.157V64.4771L24.7957 79.0565C21.3324 82.1172 16.9112 83.8944 12.1584 84.1906Z" fill="#9568FF"/>
                                                <path d="M52.3177 64.1484V110.158C52.3177 111.737 53.7546 113.054 55.56 113.054H78.0344C79.8029 113.054 81.2766 111.77 81.2766 110.158V83.0721C76.1554 82.9734 71.3657 81.1633 67.7551 77.938L52.3177 64.1484Z" fill="#9568FF"/>
                                                <path d="M92.4769 80.2078V110.157C92.4769 111.736 93.9138 113.053 95.7191 113.053H118.194C119.962 113.053 121.436 111.769 121.436 110.157V54.8994L95.6823 77.904C94.6875 78.7926 93.6191 79.5496 92.4769 80.2078Z" fill="#9568FF"/>
                                                <path d="M159.421 20.9355L132.636 44.8617V110.157C132.636 111.736 134.073 113.053 135.878 113.053H158.353C160.121 113.053 161.595 111.769 161.595 110.157V22.7456C160.858 22.1862 160.306 21.6925 159.9 21.3634L159.421 20.9355Z" fill="#9568FF"/>
                                                <path
                                                    d="M177.806 -21.4532C176.737 -22.4734 175.116 -23 173.053 -23C172.869 -23 172.648 -23 172.464 -23C162 -22.5722 151.573 -22.1114 141.11 -21.6836C139.71 -21.6177 137.794 -21.5519 136.283 -20.2026C135.804 -19.7747 135.436 -19.2811 135.141 -18.6887C133.594 -15.6938 135.768 -13.7521 136.799 -12.8306L139.415 -10.461C141.22 -8.81546 143.063 -7.16992 144.905 -5.55729L81.6816 50.9505L53.2754 25.5763C51.5806 24.0624 49.2964 23.2067 46.8647 23.2067C44.433 23.2067 42.1856 24.0624 40.4908 25.5763L2.65272 59.3427C-0.88424 62.5022 -0.88424 67.6033 2.65272 70.7628L4.34751 72.2767C6.0423 73.7906 8.32659 74.6462 10.7582 74.6462C13.1899 74.6462 15.4374 73.7906 17.1321 72.2767L46.8647 45.7177L75.2709 71.0919C76.9657 72.6058 79.25 73.4615 81.6816 73.4615C84.1133 73.4615 86.3607 72.6058 88.0924 71.0919L159.421 7.37663L167.49 14.5512C168.448 15.4069 169.774 16.5916 171.8 16.5916C172.648 16.5916 173.495 16.3942 174.379 15.9663C174.969 15.6702 175.485 15.341 175.927 14.9461C177.511 13.5309 177.806 11.7209 177.88 10.3057C178.174 4.25011 178.506 -1.80547 178.837 -7.89396L179.316 -17.0102C179.427 -18.9191 178.948 -20.4001 177.806 -21.4532Z"
                                                    fill="#9568FF"/>
                                            </g>
                                        </svg>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-warning">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-wallet"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">STAKING WALLET BALANCE</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_available_wallet_balance }}</h4>
                                    <br>
                                    <small> Total main Wallets balance </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">MANUAL TRANSACTIONS</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_manual_transactions }}</h4>
                                    <br>
                                    <small> Gas Fee: $ {{ $total_manual_transactions_gas_fees }} </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">PENDING WITHDRAWALS</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_pending_withdrawal_balance }}</h4>
                                    <br>
                                    <small>Pending to accept </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL WITHDRAWALS</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_withdraws }}</h4>
                                    <br>
                                    <small>Total Withdrawal amount </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/dashboard/dashboard.js') }}"></script>
    @endpush
</x-backend.layouts.app>
