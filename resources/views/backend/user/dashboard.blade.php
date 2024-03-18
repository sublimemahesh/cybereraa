<x-backend.layouts.app>
    @section('title', 'User Dashboard')
    @section('header-title', 'Welcome to  Cyber Eraa Family')
    @section('header-title2',Auth::user()->username)

    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/rank-timeline.css') }}">
    @endsection

    <div class="row">
        {{-- <div class="dashboard-title">
            <h2 class="text-center mx-auto">
                Welcome to Coin 1M Family
            </h2>
        </div> --}}

        <div class="container" data-devil="dis:none" data-dxs="dis:block mt:-20">
            <div class="alert welome-calert-info  text-center" data-dxs="c:#fff">
                <h5 data-dxs="pt:6"> Welcome to Cyber Eraa Family.</h5>
            </div>
        </div>


        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">{{ number_format($total_investment,2) }} $</h4>
                        <p class="mb-2 fs-13">My Investment</p>

                    </div>
                    <div class="float-end">
                        <img src="{{ asset('assets/backend/images/icon/investment.png') }}" alt=""/>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">{{ $total_withdraws }} $</h4>
                        <p class="mb-2 fs-13">My Withdrawal</p>

                    </div>
                    <img src="{{ asset('assets/backend/images/icon/withdrawal.png') }}" alt=""/>
                </div>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">{{ number_format($wallet->balance, 2) }} $</h4>
                        <p class="mb-2 fs-13">Wallet Balance</p>

                    </div>
                    <img src="{{ asset('assets/backend/images/icon/wallet.png') }}" alt=""/>
                </div>
            </div>

        </div>

        {{-- <div class="col-xl-3 col-lg-6 col-sm-6 ">

             <div class="card overflow-hidden br-dashboard-card">
                 <div class="card-body d-flex align-items-center justify-content-between">
                     <div class="me-4 card-mt-10">
                         <h4 class="heading mb-0">{{ $descendants_count }}</h4>
                         <p class="mb-2 fs-13">My Team</p>

                     </div>

                     <img src="{{ asset('assets/backend/images/icon/team.png') }}" alt=""/>
                 </div>
             </div>

         </div>--}}
        <div class="col-xl-3 col-lg-6 col-sm-6 ">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">{{ $today_income }} $</h4>
                        <p class="mb-2 fs-13">Today Income</p>

                    </div>

                    <img src="{{ asset('assets/backend/images/icon/calendar.png') }}" alt=""/>
                </div>
            </div>

        </div>

    </div>

    <div class="row" data-devil="mb:6" data-dxs="mb:0">
        <div class="col-xxl-12">
            {{-- <div class="overflow-hidden bg-transparent dz-crypto-scroll shadow-none">
                <div class="js-conveyor-example">
                    <ul class="crypto-list" id="crypto-webticker">
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-up scale5 me-2 text-success"
                                                                 aria-hidden="true"></i>4%(30 days)
                                        </p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M28.5 16.5002C28.4986 14.844 27.156 13.5018 25.5003 13.5H16.5002V19.4999H25.5003C27.156 19.4985 28.4986 18.1559 28.5 16.5002Z"
                                            fill="#FFAB2D"/>
                                        <path
                                            d="M16.5002 28.5H25.5003C27.1569 28.5 28.5 27.157 28.5 25.5003C28.5 23.8432 27.1569 22.5001 25.5003 22.5001H16.5002V28.5Z"
                                            fill="#FFAB2D"/>
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9866 9.40762 32.5924 0.0133972 21 0.00012207ZM31.5002 25.4998C31.4961 28.8122 28.8122 31.4961 25.5003 31.4998V32.9998C25.5003 33.8284 24.8283 34.4999 24.0002 34.4999C23.1716 34.4999 22.5001 33.8284 22.5001 32.9998V31.4998H19.5004V32.9998C19.5004 33.8284 18.8284 34.4999 18.0003 34.4999C17.1717 34.4999 16.5002 33.8284 16.5002 32.9998V31.4998H12.0004C11.1718 31.4998 10.5003 30.8282 10.5003 30.0001C10.5003 29.1716 11.1718 28.5 12.0004 28.5H13.5V13.5H12.0004C11.1718 13.5 10.5003 12.8285 10.5003 11.9999C10.5003 11.1714 11.1718 10.4998 12.0004 10.4998H16.5002V9.00021C16.5002 8.17166 17.1717 7.50012 18.0003 7.50012C18.8288 7.50012 19.5004 8.17166 19.5004 9.00021V10.4998H22.5001V9.00021C22.5001 8.17166 23.1716 7.50012 24.0002 7.50012C24.8287 7.50012 25.5003 8.17166 25.5003 9.00021V10.4998C28.7998 10.4861 31.486 13.1494 31.5002 16.4489C31.5075 18.1962 30.7499 19.8593 29.4265 21C30.7375 22.128 31.4942 23.77 31.5002 25.4998Z"
                                            fill="#FFAB2D"/>
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-down scale5 me-2 text-danger"
                                                                 aria-hidden="true"></i>4%(30 days)
                                        </p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM12.3281 19.4999H18.328C19.1566 19.4999 19.8281 20.1715 19.8281 21C19.8281 21.8286 19.1566 22.5001 18.328 22.5001H12.3281C11.4996 22.5001 10.828 21.8286 10.828 21C10.828 20.1715 11.5 19.4999 12.3281 19.4999ZM31.0841 17.3658L29.28 26.392C28.8552 28.4872 27.0155 29.9951 24.8777 30.0001H12.3281C11.4996 30.0001 10.828 29.3286 10.828 28.5C10.828 27.6715 11.5 26.9999 12.3281 26.9999H24.8777C25.5868 26.9981 26.197 26.4982 26.338 25.8033L28.1425 16.7772C28.3027 15.9715 27.7799 15.1887 26.9747 15.0285C26.8791 15.0097 26.782 15.0001 26.685 15.0001H15.3283C14.4998 15.0001 13.8282 14.3286 13.8282 13.5C13.8282 12.6715 14.4998 11.9999 15.3283 11.9999H26.685C29.1633 12.0009 31.1715 14.01 31.1711 16.4883C31.1711 16.7827 31.1418 17.0765 31.0841 17.3658Z"
                                            fill="#3693FF"/>
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-down scale5 me-2 text-danger"
                                                                 aria-hidden="true"></i>4%(30 days)
                                        </p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM26.9999 30.0001H22.5001V34.4999C22.5001 35.3285 21.8286 36 21 36C20.1714 36 19.4999 35.3285 19.4999 34.4999V30.0001H15.0001C14.1715 30.0006 13.4995 29.3295 13.4991 28.5009C13.4991 28.1599 13.6149 27.8289 13.8282 27.5625L23.8784 15.0001H15.0001C14.1715 15.0001 13.5 14.3286 13.5 13.5C13.5 12.6715 14.1715 11.9999 15.0001 11.9999H19.4999V7.50012C19.4999 6.67157 20.1714 6.00003 21 6.00003C21.8286 6.00003 22.5001 6.67203 22.5001 7.50012V11.9999H26.9999C27.8294 12.0013 28.5005 12.6747 28.4995 13.5037C28.4991 13.8429 28.3833 14.1725 28.1718 14.4375L18.1216 26.9999H26.9999C27.8285 26.9999 28.5 27.6719 28.5 28.5C28.5 29.3286 27.8285 30.0001 26.9999 30.0001Z"
                                            fill="#5B5D81"/>
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-up scale5 me-2 text-success"
                                                                 aria-hidden="true"></i>4%(30 days)
                                        </p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.5566 23.893C21.1991 24.0359 20.8009 24.0359 20.4434 23.893L16.6064 22.3582L21 31.1454L25.3936 22.3582L21.5566 23.893Z"
                                            fill="#AC4CBC"/>
                                        <path d="M21 20.8846L26.2771 18.7739L21 10.3304L15.7229 18.7739L21 20.8846Z"
                                              fill="#AC4CBC"/>
                                        <path
                                            d="M21 0.00012207C9.40213 0.00012207 0.00012207 9.40213 0.00012207 21C0.00012207 32.5979 9.40213 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM29.8417 20.171L22.3417 35.171C21.9714 35.9121 21.0701 36.2124 20.3294 35.8421C20.0387 35.697 19.8034 35.4617 19.6583 35.171L12.1583 20.171C11.9253 19.7032 11.9519 19.1479 12.2284 18.7043L19.7284 6.70453C20.2269 6.00232 21.1996 5.83661 21.9018 6.33511C22.0451 6.43674 22.1701 6.56125 22.2717 6.70453L29.7712 18.7043C30.0482 19.1479 30.0747 19.7032 29.8417 20.171Z"
                                            fill="#AC4CBC"/>
                                    </svg>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}

            <div class="overflow-hidden dz-crypto-scroll shadow-none">
                <div class="js-conveyor-example">
                    <ul class="crypto-list" id="crypto-webticker">


                        <li>
                            <div class="card overflow-hidden  coin-sider-dashboard">
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
                            <div class="card overflow-hidden coin-sider-dashboard">
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
                            <div class="card overflow-hidden coin-sider-dashboard">
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

                        {{-- <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13">
                                            <span class="tether-change"></span>
                                        </p>
                                        <h4 class="tether"></h4>
                                    </div>
                                    <img src="{{ asset('assets/frontend/images/coin-icon/tether-big.png') }}" width="42"
                                         height="42" viewBox="0 0 42 42" fill="none">
                                </div>
                            </div>
                        </li> --}}

                        <li>
                            <div class="card overflow-hidden  coin-sider-dashboard">
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
                            <div class="card overflow-hidden coin-sider-dashboard">
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
                            <div class="card overflow-hidden  coin-sider-dashboard">
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
                            <div class="card overflow-hidden  coin-sider-dashboard">
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
                            <div class="card overflow-hidden  coin-sider-dashboard">
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

    <div class='row'>
        <!-- Column -->
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-money-bill-wave"></i>
                                            </span>
                                </div>
                            </div>

                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">My Package Income <br> <b>${{ number_format($invest_income,2) }}</b></p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la bi-hourglass-split"></i>
                                            </span>
                                </div>
                            </div>

                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">Direct Sales Commission <br> <b>${{ number_format($direct_comm_income,2) }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-landmark"></i>
                                            </span>
                                </div>
                            </div>
                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">
                                        Indirect Sales <br> <b>${{ number_format($indirect_comm_income,2) }}</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body  p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-money-check-alt"></i>
                                            </span>
                                </div>
                            </div>
                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">Direct Trade Income <br> <b>${{ number_format($trade_income,2) }}</b></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-donate"></i>
                                            </span>
                                </div>
                            </div>

                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">Indirect Trade Income <br> <b>${{ number_format($trade_team_income,2) }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-stat card rounded-3">
                        <div class="card-body p-4">

                            <div class="col-mb-12 ">
                                <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="fa-solid fa-coins"></i>
                                            </span>
                                </div>
                            </div>

                            <div class="col-mb-12 ">
                                <div class="media-body text-white dash-p">
                                    <p class="mb-1">Reward Commissions <br> <b> $0</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-9">
             <div class="card">
                 <div class="card-body justify-content-center d-flex flex-column">
                     <h6>Total Investment: {{ number_format($total_investment,2) }}
                         <span class="float-end">Total Profit: {{ $total_avg_investment_profit }}%</span>
                     </h6>
                     @php
                         //                        $total_investment_avg_earned_profit = 0.01;
                                                  $total_investment_avg_earned_profit /= 100;
                                                 $no_of_bars = $total_avg_investment_profit/100;
                     @endphp
                     @for($i = 1; $i <= $no_of_bars; $i++)
                         @php
                             $filled_percent = 0;
                             if(($i - 1) <= $total_investment_avg_earned_profit && $i >= $total_investment_avg_earned_profit){
                                 $filled_percent = ($total_investment_avg_earned_profit - floor($total_investment_avg_earned_profit)) * 100 ;
                             }
                             if($i <= $total_investment_avg_earned_profit){
                                 $filled_percent = 100;
                             }
                         @endphp

                         <h6 class="mt-4">{{ round($filled_percent,2) }}%
                             <span class="float-end">{{ ($i)*100 }}%</span>
                         </h6>

                         <div class="progress ">
                             <div class="progress-bar bg-progress progress-animated" style="width:  {{ $filled_percent }}%; height:10px;" role="progressbar">
                                 <span class="sr-only">{{ round($filled_percent,2) }}% Complete</span>
                             </div>
                         </div>
                     @endfor


                 </div>
             </div>
         </div>--}}
        <!-- Column -->
        <!-- Column -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="grey-color-override">
                        <div class="col-xl-12" data-devil="mt:20">
                            <div>
                                <div class="card-body d-flex align-items-center p-none">
                                <span class="progress-right-card-icon" data-devil="bgc:#b62d82">
                                    <img src="{{ asset('assets/backend/images/icon/investment-dash.png') }}" alt="">
                                </span>
                                    <div data-devil='ml:22'>
                                        <h4 class="heading mb-0">
                                            {{ number_format($invest_income + $trade_income + $trade_team_income + $direct_comm_income + $indirect_comm_income,2) }} $
                                        </h4>
                                        <h4 class="  mb-2 fs-13 color-grey">Total Investment Profit</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12" data-devil="mt:40">
                            <div>
                                <div class="card-body d-flex align-items-center p-none">
                                <span class="progress-right-card-icon" data-devil="bgc:#b62d82">
                                    <img src="{{ asset('assets/backend/images/icon/dollar.png') }}" alt=""/>
                                </span>
                                    <div data-devil='ml:22'>
                                        <h4 class="heading mb-0">{{ number_format($total_package_payable,2)}} $</h4>
                                        <h4 class="mb-2 fs-13 color-grey">Package Earning Total Payout</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12" data-devil="mt:40">
                            <div>
                                <div class="card-body d-flex align-items-center p-none">
                                <span class="progress-right-card-icon" data-devil="bgc:#b62d82">
                                    <img src="{{ asset('assets/backend/images/icon/totalpayout.png') }}" alt=""/>
                                </span>
                                    <div data-devil='ml:22'>
                                        <h4 class="heading mb-0">{{ number_format($wallet->withdraw_limit,2)  }} $</h4>
                                        <h4 class="mb-2 fs-13 color-grey">Package Earning & Referrals Commission Total Payout</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12"></div>
                    </div>


                </div>
            </div>
        </div>
        <!-- Column -->
    </div>

    <div class="row">

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0 pb-0 d-flex mx-auto">
                    <h5 class="card-title">Referral Details</h5>
                </div>
                <div class="card-body" id='referral'>

                    <?php

                    if (Auth::user()->active_date !== null) {
                        $url_ref = Auth::user()->referral_link;
                    } else {
                        $url_ref = 'Please activate the package.';
                    }

                    ?>


                    <div class="copy-text">
                        <input type="text" class="text w-100" readonly value="{{$url_ref }}"/>
                        <button><i class="fa fa-clone"></i></button>
                    </div>

                    <div class="row" data-devil="mt:25">
                        <div class="col-xl-4">
                            <a id="whatsapp-button" href="whatsapp://send?text={{$url_ref}}" data-action="share/whatsapp/share" target="_blank">
                                <button type="button" class="btn btn-width" data-devil="bgc:#25D366 c:#fff">
                                    <i class="bi bi-whatsapp" data-devil='fs:12'></i> Whatsapp
                                </button>
                            </a>
                        </div>

                        <div class=" col-xl-4" data-dxs="mt:10 mb:10">
                            <a id="messenger-button" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode($url_ref)}}" target="_blank">
                                <button type="button" class="btn btn-width" data-devil="bgc:#0084FF c:#fff">
                                    <i class="bi bi-messenger" data-devil='fs:12'></i> Messenger
                                </button>
                            </a>
                        </div>


                        <div class=" col-xl-4">
                            <a id="telegram-button" href="#" onclick="shareOnTelegram()">
                                <button type="button" class="btn  btn-width" data-devil="bgc:#0088cc c:#fff">
                                    <i class="bi bi-telegram" data-devil='fs:12'></i> Telegram
                                </button>
                            </a>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="text-center dashboard-refferal-direct">
                                <h5>
                                    Active Direct Sales
                                    <span>- {{ Auth::user()->active_direct_sales }}</span>
                                    <span data-devil="f:right" data-dxs="dis:none">|</span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-xl-6" data-dxs="mt:-15">

                            <div class="text-center dashboard-refferal-direct">
                                <h5>
                                    InActive Direct Sales <span>- {{ Auth::user()->direct_sales_count - Auth::user()->active_direct_sales }}</span>
                                </h5>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header ">
                    <div class="text-center mx-auto">
                        <h5 class="card-title">Other Details</h5>
                    </div>
                </div>
                <div class="card-body dashboard-Other-deatils">
                    <h5>Referral Username <span>- {{ Auth::user()->sponsor->username }}</span></h5>
                    <h5>Register Date <span>- {{ Auth::user()->created_at->format('Y-m-d') }}</span></h5>
                    <h5>Active Date <span>- {{ Auth::user()->active_date }}</span></h5>
                    <h5>KYC <span>- </span>
                        @if(Auth::user()->profile->is_kyc_verified)
                            <span class='txt-dark-green'>Verified</span>
                        @else
                            <span class='text-warning'>Not Verified</span>
                        @endif
                    </h5>
                    <h5>Package Plus <span>-</span>
                        @php
                            $investment_start_at = \App\Models\Strategy::where('name', 'level_commission_requirement')->firstOrNew();
                        @endphp
                        @if(Auth::user()->direct_sales_count >= ($investment_start_at->value ?? 5))
                            <span class='txt-dark-green'>Active</span>
                        @else
                            <span class='text-warning'>InActive</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>

    </div>

    <div class="row d-none">

        <div class="col-sm-12">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="timeline">
                        <div class="rank {{ $highestRank >= 1 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 1</div>
                            <div class="status">{{ $highestRank >= 1 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="rank {{ $highestRank >= 2 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 2</div>
                            <div class="status">{{ $highestRank >= 2 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="line"></div>
                        <div class="rank {{ $highestRank >= 3 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 3</div>
                            <div class="status">{{ $highestRank >= 3 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                        <div class="line"></div>
                        <div class="rank {{ $highestRank >= 4 ? 'unlocked' : 'locked'  }}">
                            <div class="rank-name">Rank 4</div>
                            <div class="status">{{ $highestRank >= 4 ? 'Unlocked' : 'Locked'  }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-sm-6">
            <div class="card rounded-3">
                <div class="border-0 card-header pb-2 pt-3">
                    <h2 class="heading mb-0">Latest Incomes <span>(USDT)</span></h2>
                </div>
                <div class="card-body pt-0 pb-3 mt-2">
                    <nav class="buy-sell style-1 ">
                        <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                            <button class="last-income-round nav-link border border-right  active"
                                    id="nav-package-earning-tab last-income-round" data-bs-toggle="tab"
                                    data-bs-target="#nav-package-earning" type="button" role="tab"
                                    aria-controls="nav-package-earning" aria-selected="true">Latest Package Earnings
                            </button>
                            <button class="nav-link border border-left" id="nav-direct-sale-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-direct-sale" type="button"
                                    role="tab" aria-controls="nav-direct-sale" aria-selected="false">Direct/indirect Sales
                            </button>
                            <button class="nav-link border border-left " id="nav-indirect-sale-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-indirect-sale" type="button"
                                    role="tab" aria-controls="nav-indirect-sale"
                                    aria-selected="false">Trade Income
                            </button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent3">
                        <div class="tab-pane fade show active" id="nav-package-earning" role="tabpanel"
                             aria-labelledby="package-earning-tab">
                            <div class="list-row-head text-nowrap text-left px-3">
                                <span class="px-0">Received</span>
                                <span class="px-0">Package</span>
                                <span class="px-0">Paid Percentage</span>
                                <span class="px-0">Date</span>
                            </div>
                            <div class="list-table success">
                                @foreach ($package_latest as $day_earn)
                                    <div class="list-row px-3">
                                        <span class="p-0">$ {{ number_format($day_earn->amount,2) }}</span>
                                        <span class="p-0">{{ $day_earn->earnable->package_info_json->name
                                        }}</span>
                                        <span class="p-0">
                                            {{ $day_earn->payed_percentage ??  $day_earn->earnable->payable_percentage }}%
                                        </span>
                                        <span class="p-0">{{ $day_earn->created_at->format('Y-m-d') }}</span>
                                        <div class="bg-layer"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-direct-sale" role="tabpanel"
                             aria-labelledby="nav-direct-sale-tab">
                            <div class="list-row-head text-nowrap text-left px-3">
                                <span class="px-0">Received</span>
                                <span class="px-0">Already Paid</span>
                                <span class="px-0">User</span>
                                <span class="px-0">Income Level</span>
                                {{--<span class="px-0">Paid Percentage</span>--}}
                                {{--<span class="px-0">Next Pay</span>--}}
                            </div>
                            <div class="list-table success">
                                @foreach ($direct_indirect as $sale)
                                    <div class="list-row px-3">
                                        <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                        <span class="p-0">$ {{ number_format($sale->paid,2) }}</span>
                                        <span class="p-0">{{ $sale->purchasedPackage->user->username }}</span>
                                        <span class="p-0">{{ \App\Enums\ReferralLevelEnum::level()[$sale->commission_level] ?? '-' }}</span>
                                        {{--<span class="p-0">{{ $sale->payed_percentage }}%</span>--}}
                                        {{--<span class="p-0">{{ Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>--}}
                                        <div class="bg-layer"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-indirect-sale" role="tabpanel"
                             aria-labelledby="nav-indirect-sale-tab">
                            <div class="list-row-head text-nowrap text-left px-3">
                                <span class="px-0">Received</span>
                                <span class="px-0">Type</span>
                                <span class="px-0">User</span>
                                <span class="px-0">Income Level</span>
                                <span class="px-0">Paid Percentage</span>
                                {{--<span class="px-0">Next Pay</span>--}}
                            </div>
                            <div class="list-table success">
                                @foreach ($trade_incomes as $sale)
                                    <div class="list-row px-3">
                                        <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                        <span class="p-0"> {{ $sale->type }}</span>
                                        <span class="p-0">{{ $sale->tradeIncomePackage->user->username }}</span>
                                        <span class="p-0">{{ \App\Enums\ReferralLevelEnum::level()[$sale->income_level] ?? '-' }}</span>
                                        <span class="p-0">{{ $sale->payed_percentage }}%</span>
                                        <div class="bg-layer"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="row">
        <div class="col-xl-4  col-sm-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h2 class="heading">Income Chart</h2>
                </div>

                <div class="card-body text-center pt-0 pb-2 justify-content-center d-flex flex-column" data-devil="mb:15">
                    <div id="total_income_pie_chart" class="custome-donut"></div>
                    <div class="chart-items mt-5">
                        <div class="row">
                            <div class=" col-xl-12 col-sm-12">
                                <div class="text-start">
                                    <div class="color-picker">
                                        <span class="mb-0 col-9 fs-14">
                                            <svg class="me-2" width="16" height="16" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect width="14" height="14" rx="4" fill="#027f7f"/>
                                            </svg>
                                            My Trade Income
                                        </span>
                                        <h5>${{ number_format($invest_income,2) }}</h5>
                                    </div>
                                    <div class="color-picker">
                                        <span class="mb-0 col-9 fs-14">
                                            <svg class="me-2" width="16" height="16" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect width="14" height="14" rx="4" fill="#fbd5cb"/>
                                            </svg>
                                            Direct Trade Income
                                        </span>
                                        <h5>${{ number_format($trade_income,2) }}</h5>
                                    </div>
                                    <div class="color-picker">
                                        <span class="mb-0 col-9 fs-14">
                                            <svg class="me-2" width="16" height="16" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect width="14" height="14" rx="4" fill="#4a4a65"/>
                                            </svg>
                                            Indirect Trade Income
                                        </span>
                                        <h5>${{ number_format($trade_team_income,2) }}</h5>
                                    </div>
                                    <div class="color-picker">
                                        <span class="mb-0 col-9 fs-14">
                                            <svg class="me-2" width="16" height="16" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect width="14" height="14" rx="4" fill="#937f25"/>
                                            </svg>
                                            Direct Referral Commission
                                        </span>
                                        <h5>${{ number_format($direct_comm_income,2) }}</h5>
                                    </div>
                                    <div class="color-picker">
                                        <span class="mb-0 col-9 fs-14">
                                            <svg class="me-2" width="16" height="16" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect width="14" height="14" rx="4" fill="#983042"/>
                                            </svg>
                                            Indirect Referral Commission
                                        </span>
                                        <h5>${{ number_format($indirect_comm_income,2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-sm-12">
            <div class="card">
                <div class="card-body p-1">
                    <canvas id="lineChart_1"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            {{--<div class="row">
                <div class="col-xl-12">
                    <div class="row">

                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body  p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-money-bill-wave"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">My Package Income <br> <b>${{ number_format($invest_income,2) }}</b></p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body  p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la bi-hourglass-split"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">Direct Sales Commission <br> <b>${{ number_format($direct_comm_income,2) }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body  p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-landmark"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">
                                                Indirect Sales <br> <b>${{ number_format($indirect_comm_income,2) }}</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body  p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-money-check-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">Direct Trade Income <br> <b>${{ number_format($trade_income,2) }}</b></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="la la-donate"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">Indirect Trade Income <br> <b>${{ number_format($trade_team_income,2) }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-sm-6">
                            <div class="widget-stat card rounded-3">
                                <div class="card-body p-4">

                                    <div class="col-mb-12 ">
                                        <div class="media justify-content-center dash-p-10">
                                            <span class="me-3">
                                                <i class="fa-solid fa-coins"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-mb-12 ">
                                        <div class="media-body text-white dash-p">
                                            <p class="mb-1">Reward Commissions <br> <b> $0</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>--}}
            <div class="row">

                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        @foreach ($banners as $section)
                            <div class="item">
                                <img class="img-round" src="{{ storage('pages/' . $section->image) }}">
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <br>
                </div>

                <div class="col-lg-12">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title">Recent Bonus Reward List</h4>
                        </div>
                        <div class="card-body py-1">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th><strong>User ID.</strong></th>
                                            <th><strong>NAME</strong></th>
                                            <th><strong>SPONSOR</strong></th>
                                            <th><strong>AMOUNT</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center"> No Rewards</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('modals')

        {{-- popups--}}
        <div class="modal fade" id="popup-modal">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center w-100"> {{ $popup->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card rounded-3 bg-secondary cursor-pointer">
                                    <div class="text-center">
                                        <div class="my-4" id="show-note">
                                            {!! $popup->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- popups--}}
        <div class="modal fade" id="birthday-modal">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img src="{{ asset('assets/backend/images/bday-wish.jpeg') }}" alt="Happy Birthday"
                             class="rounded-2 w-100">
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/webticker/jquery.webticker.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/morris/morris.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/dashboard.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/coin_prices.js') }}"></script>



        <script>

            /*const pending_assign_count = parseInt("{{--{{ Auth::user()->pending_direct_sales_count }}--}}")
            if (pending_assign_count > 0) {
                const notificationNoteModal = new bootstrap.Modal('#notification-modal', {
                    backdrop: 'static',
                })
                notificationNoteModal.show()
            }*/
            const popup_exists = !!parseInt('{{ $popup->exists }}');
            if (popup_exists > 0) {
                const popupModal = new bootstrap.Modal('#popup-modal', {
                    backdrop: 'static',
                })
                popupModal.show()
            }

            @php
                $birthday = auth()->user()->profile?->dob ? auth()->user()->profile->dob : null;
            @endphp

            const is_birthday = !!parseInt('{{ !empty($birthday) && Carbon::parse($birthday)->isBirthday() }}');
            if (is_birthday > 0) {
                const birthdayModal = new bootstrap.Modal('#birthday-modal')
                birthdayModal.show()
            }


            jQuery(window).on('load', function () {
                if (jQuery('#lineChart_1').length > 0) {
                    //basic line chart
                    const lineChart_1 = document.getElementById("lineChart_1").getContext('2d');

                    lineChart_1.height = 800;

                    new Chart(lineChart_1, {
                        type: 'line',
                        data: {!! json_encode($yearlyIncomeChartData,JSON_THROW_ON_ERROR) !!},
                        options: {
                            layout: {
                                padding: {
                                    left: 20,  // Set the left padding to 30px
                                }
                            },
                            scales: {
                                y: {
                                    border: {
                                        dash: [5],
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.3)',
                                        tickLength: 1,
                                    },
                                    display: true,
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#ffffff', // Set the Y axis label font color directly
                                        font: {
                                            size: 16 // Set the Y axis label font size
                                        },
                                    }
                                },
                                x: {
                                    border: {
                                        dash: [5],
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.3)',
                                        tickLength: 1,
                                    },
                                    display: true,
                                    ticks: {
                                        color: '#ffffff', // Set the X axis label font color directly
                                        font: {
                                            size: 16 // Set the X axis label font size
                                        }
                                    },
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    align: 'end',
                                },
                                title: {
                                    display: true,
                                    text: 'My Business Growth',
                                    position: 'top',
                                    align: 'start',
                                    color: '#ffffff',
                                    padding: {
                                        left: 100,
                                        top: 20,
                                    },
                                    font: {
                                        size: 16 // Set the title font size
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    borderWidth: 2, // Set the line thickness to 2 pixels
                                }
                            }
                        },
                    });

                }
            });

            let chartEl = document.getElementById("lineChart_1");
            chartEl.height = 235;


            Morris.Donut({
                element: 'total_income_pie_chart',
                data: [
                    {
                        label: "\xa0 \xa0 Trade Income \xa0 \xa0",
                        value: {{ $invest_income }},

                    },
                    {
                        label: "\xa0 \xa0 Trade Direct Income \xa0 \xa0",
                        value: {{ $trade_income }}
                    },
                    {
                        label: "\xa0 \xa0 Trade Team Income \xa0 \xa0",
                        value: {{ $trade_team_income }}
                    },
                    {
                        label: "\xa0 \xa0 Direct Commission \xa0 \xa0",
                        value: {{ $direct_comm_income }}
                    },
                    {
                        label: "\xa0 \xa0 Team Commission \xa0 \xa0",
                        value: {{ $indirect_comm_income }}
                    }
                ],
                resize: true,
                redraw: true,
                colors: ['#027f7f', '#fbd5cb', '#4a4a65', '#937f25', '#983042'],
                //responsive:true,

            });

            // Pass the Laravel variable to JavaScript
            var urlToShare = '{{ $url_ref }}';


            function shareOnTelegram() {
                var telegramLink = 'https://t.me/share/url?url=' + encodeURIComponent(urlToShare);
                window.open(telegramLink, '_blank');
            }


        </script>
    @endpush
</x-backend.layouts.app>
