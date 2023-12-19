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
                            <div class="swiper-slide">
                                <div class="card card-wiget">
                                    <div class="card-body">
                                        <div class="card-wiget-info">
                                            <h4 class="count-num">${{ number_format($total_qualified_commissions,2) }}</h4>
                                            <p class="sm-chart">Total Qualified Commission</p>
                                        </div>
                                        <div id="TotaldipositChart"></div>
                                    </div>
                                    <div class="back-icon">
                                        <svg width="138" height="113" viewBox="0 0 138 113" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.05">
                                                <path d="M119.285 -15.4771H113.59V4.77299H133.524V-1.23874C133.524 -9.08974 127.136 -15.4771 119.285 -15.4771Z" fill="#9568FF"/>
                                                <path d="M99.3521 -49.0015H42.3988C39.7777 -49.0015 37.6527 -46.8765 37.6527 -44.2554V4.77188H104.098V-44.2554C104.098 -46.8765 101.973 -49.0015 99.3521 -49.0015Z" fill="#9568FF"/>
                                                <path d="M28.1602 -15.4771H14.8711C10.898 -15.4771 7.16314 -13.9305 4.35502 -11.122C1.5466 -8.31391 0 -4.57905 0 -0.605927V4.77299H28.1602V-15.4771Z" fill="#9568FF"/>
                                                <path d="M108.211 59.8423C108.211 66.8647 113.998 75.3463 121.183 75.3463H157.254C159.875 75.3463 162 73.2213 162 70.6002V49.0845C162 46.4634 159.875 44.3384 157.254 44.3384H121.183C113.998 44.3384 108.211 52.82 108.211 59.8423ZM128.777 59.8414C128.777 62.4628 126.652 64.5875 124.031 64.5875C121.41 64.5875 119.285 62.4628 119.285 59.8414C119.285 57.2203 121.41 55.0953 124.031 55.0953C126.652 55.0953 128.777 57.2203 128.777 59.8414Z"
                                                      fill="#9568FF"/>
                                                <path d="M105.012 76.6807C101.013 71.8922 98.719 65.7555 98.719 59.8437C98.719 53.932 101.013 47.7953 105.012 43.0068C109.406 37.7452 115.15 34.8476 121.184 34.8476H153.774V20.6093C153.774 19.8236 153.719 19.0516 153.615 18.2966C153.293 15.9761 151.277 14.2656 148.935 14.2656H0V96.7621C0 105.716 6.38731 113 14.2383 113H139.535C147.386 113 153.774 105.716 153.774 96.7621V84.8399H121.184C115.15 84.8399 109.406 81.9422 105.012 76.6807Z"
                                                      fill="#9568FF"/>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card card-wiget">
                                    <div class="card-body">
                                        <div class="card-wiget-info rewards">
                                            <h4 class="count-num">${{ number_format($total_commissions,2) }}</h4>
                                            <p>Total Commissions</p>
                                            <div>
                                                <span class="text-primary">-${{ number_format($lost_commissions,2) }} Disqualified </span>
                                            </div>
                                            <div class="d-flex align-items-baseline reward-earn">
                                                <h2 class="me-2">{{ $total_commissions > 0 ? round(($lost_commissions/ $total_commissions) *100) : 0 }}%</h2>
                                                {{-- <span>Level 2</span>--}}
                                            </div>
                                            <div class="progress-box">
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary" style="width:{{ $total_commissions > 0 ? round(($lost_commissions/ $total_commissions) *100) : 0 }}%; height:7px; border-radius:4px;" role="progressbar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="back-icon">
                                        <svg width="115" height="123" viewBox="0 0 115 123" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.05">
                                                <path d="M15.3627 66.1299L0.487194 95.8762C-0.228022 97.3054 -0.151221 99.0034 0.687599 100.362C1.52882 101.719 3.00965 102.546 4.60689 102.546H26.9838L40.4097 120.447C41.2821 121.614 42.6514 122.29 44.0926 122.29C46.0066 122.29 47.5151 121.148 48.2159 119.744L62.2334 91.7073C43.2814 89.8952 26.5722 80.2854 15.3627 66.1299Z" fill="#9568FF"/>
                                                <path d="M137.06 95.8762L122.184 66.1299C110.975 80.2854 94.2658 89.8952 75.3137 91.7073L89.3324 119.744C90.0321 121.148 91.5405 122.29 93.4545 122.29C94.8958 122.29 96.2662 121.614 97.1386 120.447L110.563 102.546H132.94C134.537 102.546 136.018 101.719 136.86 100.362C137.698 99.0034 137.775 97.3054 137.06 95.8762Z" fill="#9568FF"/>
                                                <path d="M76.4862 10.3573L68.7736 -1.96338L61.0634 10.3573C60.431 11.3677 59.4314 12.0937 58.2758 12.383L44.1766 15.9098L53.5105 27.0509C54.2761 27.9641 54.6577 29.1389 54.5749 30.3282L53.5705 44.8269L67.0504 39.3932C67.6912 39.1352 69.0016 38.7908 70.4956 39.3932L83.9768 44.8269L82.9735 30.3282C82.8919 29.1389 83.2735 27.9641 84.0392 27.0509L93.373 15.9098L79.2738 12.383C78.1182 12.0937 77.1186 11.3677 76.4862 10.3573Z" fill="#9568FF"/>
                                                <path
                                                    d="M127.676 23.9022C127.676 -8.57659 101.252 -35 68.7736 -35C36.2949 -35 9.87146 -8.57659 9.87146 23.9022C9.87146 56.3797 36.2949 82.8043 68.7736 82.8043C101.252 82.8043 127.676 56.3809 127.676 23.9022ZM105.166 16.1848L92.2966 31.5451L93.679 51.5352C93.7882 53.1192 93.0754 54.6481 91.7914 55.5817C90.5061 56.5141 88.8321 56.7205 87.3596 56.1277L68.7736 48.6359L50.1876 56.1277C49.6896 56.3281 47.7059 56.9977 45.7559 55.5817C44.4719 54.6481 43.759 53.1192 43.8682 51.5352L45.2531 31.5451L32.384 16.186C31.364 14.968 31.0424 13.3119 31.5332 11.8023C32.024 10.2926 33.2576 9.14062 34.7984 8.75541L54.2365 3.8929L64.8675 -13.0935C65.71 -14.4387 67.186 -15.2559 68.7736 -15.2559C70.3613 -15.2559 71.8373 -14.4387 72.6797 -13.0935L83.3132 3.8929L102.751 8.75541C104.292 9.14062 105.526 10.2926 106.016 11.8023C106.507 13.3119 106.186 14.968 105.166 16.1848Z"
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
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL PACKAGE EARNINGS</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_package_earnings }}</h4>
                                    <br>
                                    <small> Package daily income </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL DIRECT TRADE</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_trade_earnings }}</h4>
                                    <br>
                                    <small> Package Direct Trade income </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL INDIRECT TRADE</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_indirect_earnings }}</h4>
                                    <br>
                                    <small> Package Indirect Trade income </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL DIRECT SALES COMMISSIONS</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_direct_commission_earnings }}</h4>
                                    <br>
                                    <small> Daily direct commissions </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL INDIRECT SALE COMMISSION</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_indirect_commission_earnings }}</h4>
                                    <br>
                                    <small> Daily indirect commission </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL SPECIAL BONUSES</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_special_bonus_earnings }}</h4>
                                    <br>
                                    <small> Special Bonus </small>
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
                                    <p class="mb-1">INTERNAL WALLET BALANCE</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_available_wallet_balance }}</h4>
                                    <br>
                                    <small> Total main Wallets balance </small>
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
                                    <p class="mb-1">EXTERNAL WALLET BALANCE</p>
                                    <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_available_wallet_topup_balance }}</h4>
                                    <br>
                                    <small>Total topup Wallets balance </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-3  col-lg-6 col-sm-6">
                     <div class="widget-stat card bg-green">
                         <div class="card-body  p-4">
                             <div class="media">
                                 <span class="me-3">
                                     <i class="la la-arrows-h"></i>
                                 </span>
                                 <div class="media-body text-white">
                                     <p class="mb-1">WALLET TRANSACTIONS</p>
                                     <h4 class="text-white  dashboard-card-font-size-change"> $ {{ $total_between_wallet_transactions }}</h4>
                                     <br>
                                     <small>Transactions between wallets </small>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>--}}
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL PACKAGE PENDING</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ number_format($total_package_payable,2) }}</h4>
                                    <br>
                                    <small>Package pending return liability </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL PAYABLE</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_withdraw_limit_wallet_balance }}</h4>
                                    <br>
                                    <small>Current total liability </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="col-xl-3  col-lg-6 col-sm-6">
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
                </div>--}}
                {{--<div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">WALLET TOPUPS</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_wallet_topup }}</h4>
                                    <br>
                                    <small> Total wallet top-ups </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}

                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-green">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL ACTIVE SALES</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_active_package_balance }}</h4>
                                    <br>
                                    <small>Current total Active packages </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-danger">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL EXPIRED SALES</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_expired_package_balance }}</h4>
                                    <br>
                                    <small>Current total Inactive packages </small>
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
                {{-- <div class="col-xl-3  col-lg-6 col-sm-6">
                     <div class="widget-stat card">
                         <div class="card-body p-4">
                             <div class="media">
                                 <span class="me-3">
                                     <i class="la la-coins"></i>
                                 </span>
                                 <div class="media-body text-white">
                                     <p class="mb-1">TOTAL P2P TRANSACTIONS</p>
                                     <h4 class="text-white dashboard-card-font-size-change"> $ {{ $total_p2p_transfers }}</h4>
                                     <br>
                                     <small>Total P2P Transactions </small>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>--}}
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
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-coins"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">TOTAL TRANSACTION FEES</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ number_format(/*$total_p2p_transaction_fees +*/ $total_withdraws_transaction_fees,2) }}</h4>
                                    <br>
                                    <small> {{--P2P: $ {{ $total_p2p_transaction_fees }} /Withdraw: $ {{ $total_withdraws_transaction_fees }} --}} Total withdrawal transaction fees </small>
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
                                    <p class="mb-1"> DISQUALIFIED COMMISSION</p>
                                    <h4 class="text-white dashboard-card-font-size-change"> $ {{ $lost_commissions }}</h4>
                                    <br>
                                    <small>Total disqualified commissions </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bgl-primary text-primary">
                                    <!-- <i class="ti-user"></i> -->
                                    <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">Active Users</p>
                                    <h4 class="mb-0">{{ $active_users }}</h4>
                                    {{--<span class="badge badge-success">+3.5%</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bgl-warning text-warning">
                                    <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">InActive Users</p>
                                    <h4 class="mb-0">{{ $inactive_users }}</h4>
                                    {{--<span class="badge badge-warning">+3.5%</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body  p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bgl-danger text-danger">
                                    <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">Total Special Reward Users</p>
                                    <h4 class="mb-0">{{ $total_special_bonus_users }}</h4>
                                    {{--<span class="badge badge-danger">-3.5%</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="me-3 bgl-success text-success">
                                    <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                        <ellipse cx="12" cy="5" rx="9" ry="3">
                                        </ellipse>
                                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">Pending TO Assign</p>
                                    <h4 class="mb-0">{{ $pending_sales_count }}</h4>
                                    --}}{{--<span class="badge badge-success">-3.5%</span>--}}{{--
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}

                {{--<div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="students d-flex align-items-center justify-content-between flex-wrap">
                                <div>
                                    <h4>9,825</h4>
                                    <h5>Total Members</h5>
                                    <span>+0,5% than last month</span>
                                </div>
                                <div>
                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M57.4998 47.5001C57.4998 48.1631 57.2364 48.799 56.7676 49.2678C56.2988 49.7367 55.6629 50.0001 54.9998 50.0001H24.9998C24.3368 50.0001 23.7009 49.7367 23.2321 49.2678C22.7632 48.799 22.4998 48.1631 22.4998 47.5001C22.4998 43.5218 24.0802 39.7065 26.8932 36.8935C29.7063 34.0804 33.5216 32.5001 37.4998 32.5001H42.4998C46.4781 32.5001 50.2934 34.0804 53.1064 36.8935C55.9195 39.7065 57.4998 43.5218 57.4998 47.5001ZM39.9998 10.0001C38.022 10.0001 36.0886 10.5866 34.4441 11.6854C32.7996 12.7842 31.5179 14.346 30.761 16.1732C30.0041 18.0005 29.8061 20.0112 30.192 21.951C30.5778 23.8908 31.5302 25.6726 32.9288 27.0711C34.3273 28.4697 36.1091 29.4221 38.0489 29.8079C39.9887 30.1938 41.9994 29.9957 43.8267 29.2389C45.6539 28.482 47.2157 27.2003 48.3145 25.5558C49.4133 23.9113 49.9998 21.9779 49.9998 20.0001C49.9998 17.3479 48.9463 14.8044 47.0709 12.929C45.1955 11.0536 42.652 10.0001 39.9998 10.0001ZM17.4998 10.0001C15.522 10.0001 13.5886 10.5866 11.9441 11.6854C10.2996 12.7842 9.0179 14.346 8.26102 16.1732C7.50415 18.0005 7.30611 20.0112 7.69197 21.951C8.07782 23.8908 9.03022 25.6726 10.4287 27.0711C11.8273 28.4697 13.6091 29.4221 15.5489 29.8079C17.4887 30.1938 19.4994 29.9957 21.3267 29.2389C23.1539 28.482 24.7157 27.2003 25.8145 25.5558C26.9133 23.9113 27.4998 21.9779 27.4998 20.0001C27.4998 17.3479 26.4463 14.8044 24.5709 12.929C22.6955 11.0536 20.152 10.0001 17.4998 10.0001ZM17.4998 47.5001C17.4961 44.8741 18.0135 42.2735 19.0219 39.8489C20.0304 37.4242 21.5099 35.2238 23.3748 33.3751C21.8487 32.7989 20.2311 32.5025 18.5998 32.5001H16.3998C12.7153 32.5067 9.18366 33.9733 6.57833 36.5786C3.97301 39.1839 2.50643 42.7156 2.49982 46.4001V47.5001C2.49982 48.1631 2.76321 48.799 3.23205 49.2678C3.70089 49.7367 4.33678 50.0001 4.99982 50.0001H17.9498C17.6588 49.1984 17.5066 48.3529 17.4998 47.5001Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="card bg-success overflow-hidden">
                        <div class="card-body">
                            <div class="students d-flex align-items-center justify-content-between flex-wrap">
                                <div>
                                    <h4>653</h4>
                                    <h5>Top Rankers</h5>
                                    <span>-2% than last month</span>
                                </div>
                                <div>
                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0)">
                                            <path d="M59.0284 17.8807L30.7862 3.81817C30.2918 3.57103 29.7082 3.57103 29.2138 3.81817L0.971632 17.8807C0.375968 18.1794 3.05176e-05 18.787 3.05176e-05 19.4531C3.05176e-05 20.1192 0.375968 20.7268 0.971632 21.0255L29.2138 35.088C29.461 35.2116 29.7305 35.2734 30 35.2734C30.2696 35.2734 30.5391 35.2116 30.7862 35.088L59.0284 21.0255C59.6241 20.7268 60 20.1192 60 19.4531C60 18.787 59.6241 18.1794 59.0284 17.8807Z" fill="white"/>
                                            <path d="M56.4844 46.1441V26.2285L52.9688 27.9863V46.1441C50.9271 46.8722 49.4532 48.805 49.4532 51.0937V54.6093C49.4532 55.5809 50.2394 56.3671 51.211 56.3671H58.2422C59.2138 56.3671 60 55.5809 60 54.6093V51.0937C60 48.805 58.526 46.8722 56.4844 46.1441Z" fill="white"/>
                                            <path d="M32.3587 38.2329C31.6308 38.5967 30.8154 38.789 30 38.789C29.1846 38.789 28.3692 38.5967 27.6414 38.2329L10.5469 29.7441V33.5156C10.5469 40.4147 19.1578 45.8203 30 45.8203C40.8422 45.8203 49.4532 40.4147 49.4532 33.5156V29.7441L32.3587 38.2329Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath>
                                                <rect width="60" height="60" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-primary">
                        <div class="card-body  p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-users"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Members</p>
                                    <h3 class="text-white">3280</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar progress-animated bg-white" style="width: 80%"></div>
                                    </div>
                                    <small>80% Increase in 20 Days</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3  col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-warning">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="me-3">
                                    <i class="la la-user"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">New Members</p>
                                    <h3 class="text-white">245</h3>
                                    <div class="progress mb-2 bg-primary">
                                        <div class="progress-bar progress-animated bg-white" style="width: 50%"></div>
                                    </div>
                                    <small>50% Increase in 25 Days</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Top 10 Highest Income</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th><strong>USER ID.</strong></th>
                                            <th><strong>USER NAME</strong></th>
                                            <th><strong>NAME</strong></th>
                                            <th><strong>EMAIL</strong></th>
                                            <th><strong>TOTAL EARNED</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($highestEarners as $ranker)
                                            <tr>
                                                <td>{{ $ranker->id }}</td>
                                                <td class="text-success">{{ $ranker->username }}</td>
                                                <td class="text-success">{{ $ranker->name }}</td>
                                                <td>{{ $ranker->email }}</td>
                                                <td>{{ $ranker->earnings_sum_amount }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center"> No Users</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
