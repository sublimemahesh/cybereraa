<x-backend.layouts.app>
    @section('title', 'User Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name)
    @section('header-title2',Auth::user()->username)



    <div class="row">
        <div class="col-xl-12">
            <div class="row main-card">
                <div class="col-xl-12">
                    <div class="overflow-hidden dz-crypto-scroll shadow-none">
                        <div class="js-conveyor-example">
                            <ul class="crypto-list" id="crypto-webticker">
                                @foreach ($currency_carousel as $section)
                                    <li>
                                        <div class="card overflow-hidden">
                                            <div class="card-body d-flex align-items-center">
                                                <div class="me-4">
                                                    <p class="mb-2 fs-13">
                                                        <i class="fa fa-caret-up scale5 me-2 text-success"
                                                           aria-hidden="true"></i>{{ $section->change}}%
                                                    </p>
                                                    <h4 class="heading mb-0">$<?php echo number_format($section->value, 2); ?></h4>
                                                </div>
                                                <img src="{{ storage('currencies/' . $section->image_name) }}"
                                                     width="42" height="42" viewBox="0 0 42 42" fill="none">
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                                {{-- <li>
                                    <div class="card overflow-hidden">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="me-4">
                                                <p class="mb-2 fs-13">
                                                    <i class="fa fa-caret-down scale5 me-2 text-danger"
                                                        aria-hidden="true"></i>4%(30 days)
                                                </p>
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
                                                <p class="mb-2 fs-13">
                                                    <i class="fa fa-caret-down scale5 me-2 text-danger"
                                                        aria-hidden="true"></i>4%(30 days)
                                                </p>
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
                                                <p class="mb-2 fs-13">
                                                    <i class="fa fa-caret-up scale5 me-2 text-success"
                                                        aria-hidden="true"></i>4%(30 days)
                                                </p>
                                                <h4 class="heading mb-0">$65,123</h4>
                                            </div>
                                            <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.5566 23.893C21.1991 24.0359 20.8009 24.0359 20.4434 23.893L16.6064 22.3582L21 31.1454L25.3936 22.3582L21.5566 23.893Z"
                                                    fill="#AC4CBC" />
                                                <path
                                                    d="M21 20.8846L26.2771 18.7739L21 10.3304L15.7229 18.7739L21 20.8846Z"
                                                    fill="#AC4CBC" />
                                                <path
                                                    d="M21 0.00012207C9.40213 0.00012207 0.00012207 9.40213 0.00012207 21C0.00012207 32.5979 9.40213 41.9999 21 41.9999C32.5979 41.9999 41.9999 32.5979 41.9999 21C41.9871 9.40762 32.5924 0.0129395 21 0.00012207ZM29.8417 20.171L22.3417 35.171C21.9714 35.9121 21.0701 36.2124 20.3294 35.8421C20.0387 35.697 19.8034 35.4617 19.6583 35.171L12.1583 20.171C11.9253 19.7032 11.9519 19.1479 12.2284 18.7043L19.7284 6.70453C20.2269 6.00232 21.1996 5.83661 21.9018 6.33511C22.0451 6.43674 22.1701 6.56125 22.2717 6.70453L29.7712 18.7043C30.0482 19.1479 30.0747 19.7032 29.8417 20.171Z"
                                                    fill="#AC4CBC" />
                                            </svg>
                                        </div>
                                    </div>
                                </li> --}}

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card bubles">
                                <div class="card-body ref-card-body">
                                    <div class="buy-coin  bubles-down">
                                        <div>


                        <div class="input-group mb-3 input-primary ref-div">
                            <input type="text" readonly class="form-control ref-text" id="clipboard-input"
                                   value="{{ Auth::user()->referral_link }}" >
                            <span class="input-group-text border-0 clipboard-tooltip" onclick="copyToClipBoard()"
                                  onmouseout="outFunc()">
                                <span class="tooltip-text" id="clipboard-tooltip">Copy Link</span>
                            </span>
                        </div>
						<p id='p-with'>
                                                {{ Auth::user()->name }} Welcome to SafestTrades.com,<br>
                                               <code> DO NOT</code> share your credentials with anyone for your safety
                                            </p>





                                            <a href="{{ route('user.packages.index') }}" class="btn btn-primary">Buy
                                                Packages
                                            </a>
                                        </div>
                                        <div class="coin-img">
                                            <img src="{{ asset('assets/backend/images/coin.png') }}" class="img-fluid"
                                                 alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3  col-lg-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="students d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h4>{{ Auth::user()->currentRank->rank ?? 'NO Rank' }}</h4>
                                            <h5>MY RANK</h5>
                                            <span>Your highest rank</span>
                                        </div>
                                        <div>
                                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0)">
                                                    <path
                                                        d="M59.0284 17.8807L30.7862 3.81817C30.2918 3.57103 29.7082 3.57103 29.2138 3.81817L0.971632 17.8807C0.375968 18.1794 3.05176e-05 18.787 3.05176e-05 19.4531C3.05176e-05 20.1192 0.375968 20.7268 0.971632 21.0255L29.2138 35.088C29.461 35.2116 29.7305 35.2734 30 35.2734C30.2696 35.2734 30.5391 35.2116 30.7862 35.088L59.0284 21.0255C59.6241 20.7268 60 20.1192 60 19.4531C60 18.787 59.6241 18.1794 59.0284 17.8807Z"
                                                        fill="white"/>
                                                    <path
                                                        d="M56.4844 46.1441V26.2285L52.9688 27.9863V46.1441C50.9271 46.8722 49.4532 48.805 49.4532 51.0937V54.6093C49.4532 55.5809 50.2394 56.3671 51.211 56.3671H58.2422C59.2138 56.3671 60 55.5809 60 54.6093V51.0937C60 48.805 58.526 46.8722 56.4844 46.1441Z"
                                                        fill="white"/>
                                                    <path
                                                        d="M32.3587 38.2329C31.6308 38.5967 30.8154 38.789 30 38.789C29.1846 38.789 28.3692 38.5967 27.6414 38.2329L10.5469 29.7441V33.5156C10.5469 40.4147 19.1578 45.8203 30 45.8203C40.8422 45.8203 49.4532 40.4147 49.4532 33.5156V29.7441L32.3587 38.2329Z"
                                                        fill="white"/>
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
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="students d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h4>{{ Auth::user()->descendants->count() }}</h4>
                                            <h5>MEMBERS COUNT</h5>
                                            <span>Total users</span>
                                        </div>
                                        <div>
                                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M57.4998 47.5001C57.4998 48.1631 57.2364 48.799 56.7676 49.2678C56.2988 49.7367 55.6629 50.0001 54.9998 50.0001H24.9998C24.3368 50.0001 23.7009 49.7367 23.2321 49.2678C22.7632 48.799 22.4998 48.1631 22.4998 47.5001C22.4998 43.5218 24.0802 39.7065 26.8932 36.8935C29.7063 34.0804 33.5216 32.5001 37.4998 32.5001H42.4998C46.4781 32.5001 50.2934 34.0804 53.1064 36.8935C55.9195 39.7065 57.4998 43.5218 57.4998 47.5001ZM39.9998 10.0001C38.022 10.0001 36.0886 10.5866 34.4441 11.6854C32.7996 12.7842 31.5179 14.346 30.761 16.1732C30.0041 18.0005 29.8061 20.0112 30.192 21.951C30.5778 23.8908 31.5302 25.6726 32.9288 27.0711C34.3273 28.4697 36.1091 29.4221 38.0489 29.8079C39.9887 30.1938 41.9994 29.9957 43.8267 29.2389C45.6539 28.482 47.2157 27.2003 48.3145 25.5558C49.4133 23.9113 49.9998 21.9779 49.9998 20.0001C49.9998 17.3479 48.9463 14.8044 47.0709 12.929C45.1955 11.0536 42.652 10.0001 39.9998 10.0001ZM17.4998 10.0001C15.522 10.0001 13.5886 10.5866 11.9441 11.6854C10.2996 12.7842 9.0179 14.346 8.26102 16.1732C7.50415 18.0005 7.30611 20.0112 7.69197 21.951C8.07782 23.8908 9.03022 25.6726 10.4287 27.0711C11.8273 28.4697 13.6091 29.4221 15.5489 29.8079C17.4887 30.1938 19.4994 29.9957 21.3267 29.2389C23.1539 28.482 24.7157 27.2003 25.8145 25.5558C26.9133 23.9113 27.4998 21.9779 27.4998 20.0001C27.4998 17.3479 26.4463 14.8044 24.5709 12.929C22.6955 11.0536 20.152 10.0001 17.4998 10.0001ZM17.4998 47.5001C17.4961 44.8741 18.0135 42.2735 19.0219 39.8489C20.0304 37.4242 21.5099 35.2238 23.3748 33.3751C21.8487 32.7989 20.2311 32.5025 18.5998 32.5001H16.3998C12.7153 32.5067 9.18366 33.9733 6.57833 36.5786C3.97301 39.1839 2.50643 42.7156 2.49982 46.4001V47.5001C2.49982 48.1631 2.76321 48.799 3.23205 49.2678C3.70089 49.7367 4.33678 50.0001 4.99982 50.0001H17.9498C17.6588 49.1984 17.5066 48.3529 17.4998 47.5001Z"
                                                    fill="white"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3  col-lg-6 col-sm-6">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="students d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h4>{{ Auth::user()->pending_direct_sales_count }}</h4>
                                            <h5>PENDING USER COUNT</h5>
                                            <span>Waiting to assign in genealogy</span>
                                        </div>
                                        <div>
                                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M57.4998 47.5001C57.4998 48.1631 57.2364 48.799 56.7676 49.2678C56.2988 49.7367 55.6629 50.0001 54.9998 50.0001H24.9998C24.3368 50.0001 23.7009 49.7367 23.2321 49.2678C22.7632 48.799 22.4998 48.1631 22.4998 47.5001C22.4998 43.5218 24.0802 39.7065 26.8932 36.8935C29.7063 34.0804 33.5216 32.5001 37.4998 32.5001H42.4998C46.4781 32.5001 50.2934 34.0804 53.1064 36.8935C55.9195 39.7065 57.4998 43.5218 57.4998 47.5001ZM39.9998 10.0001C38.022 10.0001 36.0886 10.5866 34.4441 11.6854C32.7996 12.7842 31.5179 14.346 30.761 16.1732C30.0041 18.0005 29.8061 20.0112 30.192 21.951C30.5778 23.8908 31.5302 25.6726 32.9288 27.0711C34.3273 28.4697 36.1091 29.4221 38.0489 29.8079C39.9887 30.1938 41.9994 29.9957 43.8267 29.2389C45.6539 28.482 47.2157 27.2003 48.3145 25.5558C49.4133 23.9113 49.9998 21.9779 49.9998 20.0001C49.9998 17.3479 48.9463 14.8044 47.0709 12.929C45.1955 11.0536 42.652 10.0001 39.9998 10.0001ZM17.4998 10.0001C15.522 10.0001 13.5886 10.5866 11.9441 11.6854C10.2996 12.7842 9.0179 14.346 8.26102 16.1732C7.50415 18.0005 7.30611 20.0112 7.69197 21.951C8.07782 23.8908 9.03022 25.6726 10.4287 27.0711C11.8273 28.4697 13.6091 29.4221 15.5489 29.8079C17.4887 30.1938 19.4994 29.9957 21.3267 29.2389C23.1539 28.482 24.7157 27.2003 25.8145 25.5558C26.9133 23.9113 27.4998 21.9779 27.4998 20.0001C27.4998 17.3479 26.4463 14.8044 24.5709 12.929C22.6955 11.0536 20.152 10.0001 17.4998 10.0001ZM17.4998 47.5001C17.4961 44.8741 18.0135 42.2735 19.0219 39.8489C20.0304 37.4242 21.5099 35.2238 23.3748 33.3751C21.8487 32.7989 20.2311 32.5025 18.5998 32.5001H16.3998C12.7153 32.5067 9.18366 33.9733 6.57833 36.5786C3.97301 39.1839 2.50643 42.7156 2.49982 46.4001V47.5001C2.49982 48.1631 2.76321 48.799 3.23205 49.2678C3.70089 49.7367 4.33678 50.0001 4.99982 50.0001H17.9498C17.6588 49.1984 17.5066 48.3529 17.4998 47.5001Z"
                                                    fill="white"/>
                                            </svg>
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
                                            <p class="mb-1">WALLET BALANCE</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ number_format($wallet->balance,2) }}</h4>
                                            <small> </small>
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
                                            <p class="mb-1">TOTAL INVESTMENT</p>
                                            <h4 class="text-white  user-dashboard-card-font-size-change"> USDT {{ $total_investment }}</h4>
                                            <br>
                                            <small> Active/Expired </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3  col-lg-6 col-sm-6">
                            <div class="widget-stat card bg-green">
                                <div class="card-body  p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="la la-upload"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">ACTIVE INVESTMENT</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $active_investment }}</h4>
                                            <br>
                                            <small> Currently active total </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3  col-lg-6 col-sm-6">
                            <div class="widget-stat card bg-danger">
                                <div class="card-body  p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="la la-close"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">EXPIRED INVESTMENT</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $expired_investment }}</h4>
                                            <br>
                                            <small> Inactive (expired) total </small>
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
                                            <i class="la la-money-check-alt"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">TOTAL EARNED</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $income }}</h4>
                                            <br>
                                            <small> Total Earnings</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3  col-lg-6 col-sm-6">
                            <div class="widget-stat card bg-gradient">
                                <div class="card-body  p-4">
                                    <div class="media">
                                        <span class="me-3">
                                            <i class="la la-dollar-sign"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">PACKAGE INCOME</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $invest_income }}</h4>
                                            <br>
                                            <small> Total investment profit </small>
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
                                            <i class="la la-money-bill-wave"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">COMMISSIONS</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $qualified_commissions }}</h4>
                                            <br>
                                            <small> Direct / Indirect </small>
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
                                            <i class="la la-money-bill"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">LOSTs</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $lost_commissions }}</h4>
                                            <br>
                                            <small> Disqualified </small>
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
                                            <i class="la la-user"></i>
                                        </span>
                                        <div class="media-body text-white">
                                            <p class="mb-1">Total P2P & Withdrawal</p>
                                            <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $withdraw }}</h4>
                                            <br>
                                            <small>Payout limit USDT {{ $wallet->withdraw_limit }}</small>
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
                            <div class="card">
                                <div class="card-header py-2">
                                    <h2 class="heading">Income Book <span>(USDT)</span></h2>
                                </div>
                                <div class="card-body pt-0 pb-3 px-2">
                                    <nav class="buy-sell style-1">
                                        <div class="nav nav-tabs" id="nav-tab1" role="tablist">
                                            <button class="nav-link active" id="nav-openorder-tab"
                                                    data-bs-toggle="tab" data-bs-target="#nav-openorder" type="button"
                                                    role="tab" aria-controls="nav-openorder"
                                                    aria-selected="true">Direct Sales
                                            </button>
                                            <button class="nav-link" id="nav-orderhistory-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-orderhistory" type="button" role="tab"
                                                    aria-controls="nav-orderhistory" aria-selected="false">In-Direct Sales
                                            </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent3">
                                        <div class="tab-pane fade show active" id="nav-openorder" role="tabpanel"
                                             aria-labelledby="nav-openorder-tab">
                                            <div class="list-row-head text-nowrap text-left px-3">
                                                <span class="px-0">Received</span>
                                                <span class="px-0">Paid</span>
                                                <span class="px-0">User</span>
                                                <span class="px-0">Next Pay</span>
                                            </div>
                                            <div class="list-table success">
                                                @foreach ($direct as $sale)
                                                    <div class="list-row px-3">
                                                        <span class="p-0">{{ $sale->amount }}</span>
                                                        <span class="p-0">{{ $sale->paid }}</span>
                                                        <span class="p-0">{{ $sale->purchasedPackage->user->username }}</span>
                                                        <span class="p-0">{{ Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>
                                                        <div class="bg-layer"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-orderhistory" role="tabpanel"
                                             aria-labelledby="nav-orderhistory-tab">
                                            <div class="list-row-head text-nowrap text-left px-3">
                                                <span class="px-0">Received</span>
                                                <span class="px-0">Paid</span>
                                                <span class="px-0">User</span>
                                                <span class="px-0">Next Pay</span>
                                            </div>
                                            <div class="list-table success">
                                                @foreach ($indirect as $sale)
                                                    <div class="list-row px-3">
                                                        <span class="p-0">{{ $sale->amount }}</span>
                                                        <span class="p-0">{{ $sale->paid }}</span>
                                                        <span class="p-0">{{ $sale->purchasedPackage->user->username }}</span>
                                                        <span class="p-0">{{ Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Top 10 Rankers</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                    <tr>
                                        <th><strong>User ID.</strong></th>
                                        <th><strong>NAME</strong></th>
                                        <th><strong>Email</strong></th>
                                        <th><strong>ACTIVATED</strong></th>
                                        <th><strong>Rank</strong></th>
                                        <th><strong>TOTAL RANKERS</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($top_rankers as $ranker)
                                        <tr>
                                            <td>{{ $ranker->user_id }}</td>
                                            <td class="text-success">{{ $ranker->user->username }}</td>
                                            <td>{{ $ranker->user->email }}</td>
                                            <td>{{ Carbon::parse($ranker->activated_at)->format('Y-m-d H:i:s') }}</td>
                                            <td class="text-success">Rank 0{{ $ranker->rank }}</td>
                                            <td class="text-center">{{ $ranker->total_rankers }}</td>
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

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/webticker/jquery.webticker.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/dashboard.js') }}"></script>

		   <script>

		   function copyToClipBoard() {

                const copyText = document.getElementById("clipboard-input");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);

                const tooltip = document.getElementById("clipboard-tooltip");
                tooltip.innerHTML = "Copied: ";
            }

			   function outFunc() {
                const tooltip = document.getElementById("clipboard-tooltip");
                //tooltip.innerHTML = "Copied";
            }


		   </script>



    @endpush
</x-backend.layouts.app>
