<x-backend.layouts.app>
    @section('title', 'User Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name)
    @section('header-title2',Auth::user()->username)

    <div class="row">

        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">1,000 CMT</h4>
                        <p class="mb-2 fs-13">My Insvestment</p>

                    </div>
                    <img src="{{ asset('assets/backend/images/icon/investment.png') }}"/>
                </div>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">750 CMT</h4>
                        <p class="mb-2 fs-13">My Withdrawal</p>

                    </div>
                    <img src="{{ asset('assets/backend/images/icon/withdrawal.png') }}"/>
                </div>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">325 CMT</h4>
                        <p class="mb-2 fs-13">Wallet Balance</p>

                    </div>
                    <img src="{{ asset('assets/backend/images/icon/wallet.png') }}"/>
                </div>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6 ">

            <div class="card overflow-hidden br-dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-4 card-mt-10">
                        <h4 class="heading mb-0">115</h4>
                        <p class="mb-2 fs-13">My Team</h4>

                    </div>

                    <img src="{{ asset('assets/backend/images/icon/team.png') }}"/>
                </div>
            </div>

        </div>

    </div>



    <div class="row">
        <div class="col-xxl-12">
            <div class="overflow-hidden bg-transparent dz-crypto-scroll shadow-none">
                <div class="js-conveyor-example">
                    <ul class="crypto-list" id="crypto-webticker">
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-up scale5 me-2 text-success"
                                                aria-hidden="true"></i>4%(30 days)</p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M28.5 16.5002C28.4986 14.844 27.156 13.5018 25.5003 13.5H16.5002V19.4999H25.5003C27.156 19.4985 28.4986 18.1559 28.5 16.5002Z"
                                            fill="#FFAB2D" />
                                        <path
                                            d="M16.5002 28.5H25.5003C27.1569 28.5 28.5 27.157 28.5 25.5003C28.5 23.8432 27.1569 22.5001 25.5003 22.5001H16.5002V28.5Z"
                                            fill="#FFAB2D" />
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9866 9.40762 32.5924 0.0133972 21 0.00012207ZM31.5002 25.4998C31.4961 28.8122 28.8122 31.4961 25.5003 31.4998V32.9998C25.5003 33.8284 24.8283 34.4999 24.0002 34.4999C23.1716 34.4999 22.5001 33.8284 22.5001 32.9998V31.4998H19.5004V32.9998C19.5004 33.8284 18.8284 34.4999 18.0003 34.4999C17.1717 34.4999 16.5002 33.8284 16.5002 32.9998V31.4998H12.0004C11.1718 31.4998 10.5003 30.8282 10.5003 30.0001C10.5003 29.1716 11.1718 28.5 12.0004 28.5H13.5V13.5H12.0004C11.1718 13.5 10.5003 12.8285 10.5003 11.9999C10.5003 11.1714 11.1718 10.4998 12.0004 10.4998H16.5002V9.00021C16.5002 8.17166 17.1717 7.50012 18.0003 7.50012C18.8288 7.50012 19.5004 8.17166 19.5004 9.00021V10.4998H22.5001V9.00021C22.5001 8.17166 23.1716 7.50012 24.0002 7.50012C24.8287 7.50012 25.5003 8.17166 25.5003 9.00021V10.4998C28.7998 10.4861 31.486 13.1494 31.5002 16.4489C31.5075 18.1962 30.7499 19.8593 29.4265 21C30.7375 22.128 31.4942 23.77 31.5002 25.4998Z"
                                            fill="#FFAB2D" />
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-down scale5 me-2 text-danger"
                                                aria-hidden="true"></i>4%(30 days)</p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM12.3281 19.4999H18.328C19.1566 19.4999 19.8281 20.1715 19.8281 21C19.8281 21.8286 19.1566 22.5001 18.328 22.5001H12.3281C11.4996 22.5001 10.828 21.8286 10.828 21C10.828 20.1715 11.5 19.4999 12.3281 19.4999ZM31.0841 17.3658L29.28 26.392C28.8552 28.4872 27.0155 29.9951 24.8777 30.0001H12.3281C11.4996 30.0001 10.828 29.3286 10.828 28.5C10.828 27.6715 11.5 26.9999 12.3281 26.9999H24.8777C25.5868 26.9981 26.197 26.4982 26.338 25.8033L28.1425 16.7772C28.3027 15.9715 27.7799 15.1887 26.9747 15.0285C26.8791 15.0097 26.782 15.0001 26.685 15.0001H15.3283C14.4998 15.0001 13.8282 14.3286 13.8282 13.5C13.8282 12.6715 14.4998 11.9999 15.3283 11.9999H26.685C29.1633 12.0009 31.1715 14.01 31.1711 16.4883C31.1711 16.7827 31.1418 17.0765 31.0841 17.3658Z"
                                            fill="#3693FF" />
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-down scale5 me-2 text-danger"
                                                aria-hidden="true"></i>4%(30 days)</p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 0.00012207C9.4021 0.00012207 9.15527e-05 9.40213 9.15527e-05 21C9.15527e-05 32.5979 9.4021 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM26.9999 30.0001H22.5001V34.4999C22.5001 35.3285 21.8286 36 21 36C20.1714 36 19.4999 35.3285 19.4999 34.4999V30.0001H15.0001C14.1715 30.0006 13.4995 29.3295 13.4991 28.5009C13.4991 28.1599 13.6149 27.8289 13.8282 27.5625L23.8784 15.0001H15.0001C14.1715 15.0001 13.5 14.3286 13.5 13.5C13.5 12.6715 14.1715 11.9999 15.0001 11.9999H19.4999V7.50012C19.4999 6.67157 20.1714 6.00003 21 6.00003C21.8286 6.00003 22.5001 6.67203 22.5001 7.50012V11.9999H26.9999C27.8294 12.0013 28.5005 12.6747 28.4995 13.5037C28.4991 13.8429 28.3833 14.1725 28.1718 14.4375L18.1216 26.9999H26.9999C27.8285 26.9999 28.5 27.6719 28.5 28.5C28.5 29.3286 27.8285 30.0001 26.9999 30.0001Z"
                                            fill="#5B5D81" />
                                    </svg>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card overflow-hidden">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        <p class="mb-2 fs-13"><i class="fa fa-caret-up scale5 me-2 text-success"
                                                aria-hidden="true"></i>4%(30 days)</p>
                                        <h4 class="heading mb-0">$65,123</h4>
                                    </div>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.5566 23.893C21.1991 24.0359 20.8009 24.0359 20.4434 23.893L16.6064 22.3582L21 31.1454L25.3936 22.3582L21.5566 23.893Z"
                                            fill="#AC4CBC" />
                                        <path d="M21 20.8846L26.2771 18.7739L21 10.3304L15.7229 18.7739L21 20.8846Z"
                                            fill="#AC4CBC" />
                                        <path
                                            d="M21 0.00012207C9.40213 0.00012207 0.00012207 9.40213 0.00012207 21C0.00012207 32.5979 9.40213 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM29.8417 20.171L22.3417 35.171C21.9714 35.9121 21.0701 36.2124 20.3294 35.8421C20.0387 35.697 19.8034 35.4617 19.6583 35.171L12.1583 20.171C11.9253 19.7032 11.9519 19.1479 12.2284 18.7043L19.7284 6.70453C20.2269 6.00232 21.1996 5.83661 21.9018 6.33511C22.0451 6.43674 22.1701 6.56125 22.2717 6.70453L29.7712 18.7043C30.0482 19.1479 30.0747 19.7032 29.8417 20.171Z"
                                            fill="#AC4CBC" />
                                    </svg>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">






            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            {{-- <div class="card bubles rounded-3 profile-card-bg-image">
                                <div class="card-body ref-card-body">
                                    <div class="bubles-down buy-coin d-flex justify-content-between mb-0 mx-0">
                                        <div class="w-100">
                                            <h1 class="mb-0 lh-1 text-uppercase">{{ Auth::user()->username }}</h1>
                                            <p class="fs-26 mb-1 mx-0 text-muted w-100 text-uppercase">{{
                                                Auth::user()->name }}</p>
                                            <p class="fs-16 fw-bold text-warning">{{ Auth::user()->currentRank->rank ??
                                                'NO' }} STAR </p>

                                            <div>
                                                <label href="#" class="btn btn btn-user  profile-card-btn">
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    Pending User Count: {{ auth()->user()->pending_direct_sales_count }}
                                                </label>

                                                <label href="#" class="btn btn btn-user profile-card-btn">
                                                    <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                                    Loss sale count: USDT {{ $lost_commissions }}
                                                </label>
                                            </div>
                                            @if (Auth::user()->id === config('fortify.super_parent_id') ||
                                            (Auth::user()->parent_id !== null && Auth::user()->position !== null))
                                            <div class="btn-genealogy btn-genealogy mt-2">
                                                <a href="{{ route('user.genealogy.position.register') }}"
                                                    class="btn btn-info rounded-3 profile-card-btn">
                                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                    Registration new user
                                                </a>

                                                <a href="{{ route('user.genealogy') }}"
                                                    class="btn btn-info rounded-3 profile-card-btn">
                                                    <i class="fa fa-sitemap" aria-hidden="true"></i>
                                                    My genealogy
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="float-left width-295  rounded-3">
                                            <img src="{{ Auth::user()->profile_photo_url }}"
                                                class=" w-100 profile-img-border img-round profile-pic-m" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card rounded-3">
                                <div class="card-body">
                                    <canvas id="overlapping-bars"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card rounded-3">
                                <div class="card-body d-flex flex-column justify-content-center px-2">
                                    <canvas id="earnings-pie-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <div class="widget-stat card rounded-3 bg-info-dark">
                                <div class="card-body  p-4">
                                    <div class="media">
                                        <span class="me-3"><i class="la la-wallet"></i></span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">INCOME BALANCE</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change">
                                                USDT {{number_format($wallet->balance,2) }}
                                            </h4>
                                            <small> </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <div class="widget-stat card rounded-3 bg-warning-dark ">
                                <div class="card-body  p-4">
                                    <div class="media">
                                        <span class="me-3"><i class="la la-wallet"></i></span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">PAYOUT BALANCE</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change">
                                                USDT {{number_format($wallet->withdraw_limit,2) }}
                                            </h4>
                                            <small> </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-sm-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="la la-coins"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">TOTAL INVESTMENT</p>
                                                    <h4 class="text-white  user-dashboard-card-font-size-change">
                                                        USDT {{$total_investment }}</h4>
                                                    <br>
                                                    <small>
                                                        <a href="{{ route('user.transactions.index') }}">Details</a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3 bg-green-dark">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-upload"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">ACTIVE PLAN</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change">
                                                        USDT {{$active_investment }}</h4>
                                                    <br>
                                                    <small>
                                                        <a href="{{ route('user.packages.active') }}">Details</a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3  bg-danger-dark">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3">
                                                    <i class="la la-diamond"></i>
                                                </span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">EXPIRED PLAN</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change">
                                                        USDT {{$expired_investment }}
                                                    </h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3 bg-gradient">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-dollar-sign"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">PLAN INCOME</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{
                                                        number_format($invest_income,2) }}</h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-money-bill-wave"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">TOTAL COMMISSIONS</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT
                                                        {{$qualified_commissions }}</h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la bi-hourglass-split"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">PENDING COMMISSIONS</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT
                                                        {{$pending_commissions }}</h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">TOTAL EARNED</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{
                                                        $income }}</h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body  p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-money-check-alt"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">TODAY INCOME</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{
                                                        $today_income }}</h4>
                                                    <br>
                                                    <small> </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-sm-6">
                                    <div class="widget-stat card rounded-3">
                                        <div class="card-body p-4">
                                            <div class="media">
                                                <span class="me-3"><i class="la la-users"></i></span>
                                                <div class="media-body text-white">
                                                    <p class="mb-1">TEAM COUNT</p>
                                                    <h4 class="text-white user-dashboard-card-font-size-change">
                                                        {{$descendants_count }}</h4>
                                                    <br>
                                                    <small> </small>
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
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
                                                aria-controls="nav-package-earning" aria-selected="true">Latest Package
                                                Earnings
                                            </button>
                                            <button class="nav-link border border-left" id="nav-direct-sale-tab"
                                                data-bs-toggle="tab" data-bs-target="#nav-direct-sale" type="button"
                                                role="tab" aria-controls="nav-direct-sale" aria-selected="false">Direct
                                                Sales
                                            </button>
                                            <button class="nav-link border border-left " id="nav-indirect-sale-tab"
                                                data-bs-toggle="tab" data-bs-target="#nav-indirect-sale" type="button"
                                                role="tab" aria-controls="nav-indirect-sale"
                                                aria-selected="false">In-Direct Sales
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
                                                    <span class="p-0">{{ $day_earn->payed_percentage ??
                                                        $day_earn->earnable->payable_percentage }}%</span>
                                                    <span class="p-0">{{ $day_earn->created_at->format('Y-m-d')
                                                        }}</span>
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
                                                <span class="px-0">Next Pay</span>
                                            </div>
                                            <div class="list-table success">
                                                @foreach ($direct as $sale)
                                                <div class="list-row px-3">
                                                    <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                                    <span class="p-0">$ {{ number_format($sale->paid,2) }}</span>
                                                    <span class="p-0">{{ $sale->purchasedPackage->user->username
                                                        }}</span>
                                                    <span class="p-0">{{
                                                        Carbon::parse($sale->next_payment_date)->format('Y-m-d')
                                                        }}</span>
                                                    <div class="bg-layer"></div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-indirect-sale" role="tabpanel"
                                            aria-labelledby="nav-indirect-sale-tab">
                                            <div class="list-row-head text-nowrap text-left px-3">
                                                <span class="px-0">Received</span>
                                                <span class="px-0">Already Paid</span>
                                                <span class="px-0">User</span>
                                                <span class="px-0">Next Pay</span>
                                            </div>
                                            <div class="list-table success">
                                                @foreach ($indirect as $sale)
                                                <div class="list-row px-3">
                                                    <span class="p-0">$ {{ number_format($sale->amount,2) }}</span>
                                                    <span class="p-0">$ {{ number_format($sale->paid,2) }}</span>
                                                    <span class="p-0">{{ $sale->purchasedPackage->user->username
                                                        }}</span>
                                                    <span class="p-0">{{
                                                        Carbon::parse($sale->next_payment_date)->format('Y-m-d')
                                                        }}</span>
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
                </div>

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
                            <h4 class="card-title">Latest {{ count($top_rankers) }} Rankers</h4>
                        </div>
                        <div class="card-body py-1">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th><strong>User ID.</strong></th>
                                            <th><strong>NAME</strong></th>
                                            <th><strong>SPONSOR</strong></th>
                                            <th><strong>ACTIVATED</strong></th>
                                            <th><strong>Rank</strong></th>
                                            <th class="text-center"><strong>TOTAL RANKERS</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($top_rankers as $ranker)
                                        <tr>
                                            <td class="py-1">{{ $ranker->user_id }}</td>
                                            <td class="py-1 text-info text-truncate" style="max-width:130px">
                                                {{--{{ $ranker->user->name }}<br>--}}
                                                {{ $ranker->user->username }}
                                            </td>
                                            <td class="py-1 text-truncate" style="max-width:130px">
                                                {{--{{ $ranker->user->sponsor->name }}<br>--}}
                                                {{ $ranker->user->sponsor->username }}
                                            </td>
                                            <td class="py-1">{{ Carbon::parse($ranker->activated_at)->format('Y-m-d h:i
                                                A') }}</td>
                                            <td class="py-1 text-info">Rank 0{{ $ranker->rank }}</td>
                                            <td class="py-1 text-center">{{ $ranker->total_rankers }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center"> No Rankers</td>
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

    @push('modals')
    <div class="modal fade" id="notification-modal">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pending DownLiners ({{ Auth::user()->pending_direct_sales_count }})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card rounded-3 bg-secondary cursor-pointer">
                                <div class="text-center">
                                    <div class="my-4" id="show-note">
                                        <div>
                                            You have pending downline requests to approve.
                                            Please approve the requests to place your downlines in the genealogy.
                                        </div>
                                        <a href="{{ route('user.genealogy') }}" class="btn btn-primary mt-3">
                                            Place Now
                                        </a>
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
    <script src="{{ asset('assets/backend/js/user/dashboard.js') }}"></script>
    <script src="{{ asset('assets/backend/js/user/coin_prices.js') }}"></script>



    <script>
        const pending_assign_count = parseInt("{{ Auth::user()->pending_direct_sales_count }}")
            if (pending_assign_count > 0) {
                const notificationNoteModal = new bootstrap.Modal('#notification-modal', {
                    backdrop: 'static',
                })
                notificationNoteModal.show()
            }
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


            const myChart = new Chart(document.getElementById('overlapping-bars'), {
                type: 'bar',
                data: {!! json_encode($yearlyIncomeChartData,JSON_THROW_ON_ERROR) !!},
                responsive: true,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: `Income Chart {{ date('Y') }}`
                        }
                    }
                },
            });

            @php
                $pii_chart_data = [$invest_income,$direct_comm_income,$indirect_comm_income,$rank_bonus_income]
            @endphp

            new Chart(document.getElementById('earnings-pie-chart'), {
                type: 'pie',
                data: {
                    labels: ['PACKAGE', 'DIRECT', 'INDIRECT', 'RANK BONUS'],
                    datasets: [
                        {
                            label: 'Total Earnings',
                            data: {!! json_encode($pii_chart_data, JSON_THROW_ON_ERROR) !!},
                            borderWidth: 0.5,
                            borderColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(75, 192, 192)', 'rgb(255, 205, 86 )',],
                            backgroundColor: ['rgb(255, 99, 132,0.5)', 'rgb(54, 162, 235,0.5)', 'rgb(75, 192, 192,0.5)', 'rgb(255, 205, 86,0.5)',],
                        }
                    ]
                },
                plugins: [ChartDataLabels],
                options: {
                    tooltips: {
                        enabled: true
                    },
                    responsive: true,
                    plugins: {
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                return (value * 100 / sum).toFixed(2) <= 0 ? null : (value * 100 / sum).toFixed(2) + "%";
                            },
                            color: '#fff',
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: 10
                                },
                                usePointStyle: true,
                                boxWidth: 15,
                            },
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'My Earnings Summary',
                        },
                    }
                },
            })




    </script>
    @endpush
</x-backend.layouts.app>
