<x-backend.layouts.app>
    @section('title', 'User Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name)
    @section('header-title2',Auth::user()->username)



    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6">
            <div class="card card-box bg-warning">
                <div class="card-header border-0 pb-0">
                    <div class="chart-num-days">
                        <p>
                            <i class="fa-solid fa-sort-down me-2"></i>
                            4%(30 days)
                        </p>
                        <h2 class="count-num text-white">$65,123</h2>
                    </div>
                    <svg width="50" height="50" viewBox="0 0 137 137" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M92.9644 53.8221C92.9599 48.4197 88.5804 44.0417 83.1795 44.0357H53.822V63.6069H83.1795C88.5804 63.6024 92.9599 59.2229 92.9644 53.8221Z" fill="#FFF"/>
                    <path d="M53.822 92.9645H83.1795C88.5834 92.9645 92.9644 88.5835 92.9644 83.1796C92.9644 77.7743 88.5834 73.3933 83.1795 73.3933H53.822V92.9645Z" fill="#FFF"/>
                    <path d="M68.5001 9.15527e-05C30.6687 9.15527e-05 0.00012207 30.6687 0.00012207 68.5001C0.00012207 106.332 30.6687 137 68.5001 137C106.332 137 137 106.332 137 68.5001C136.957 30.6866 106.314 0.0433939 68.5001 9.15527e-05V9.15527e-05ZM102.751 83.1781C102.737 93.9828 93.9829 102.737 83.1797 102.749V107.643C83.1797 110.345 80.9877 112.536 78.2865 112.536C75.5838 112.536 73.3933 110.345 73.3933 107.643V102.749H63.6084V107.643C63.6084 110.345 61.4164 112.536 58.7153 112.536C56.0126 112.536 53.8221 110.345 53.8221 107.643V102.749H39.144C36.4414 102.749 34.2509 100.559 34.2509 97.8577C34.2509 95.155 36.4414 92.9645 39.144 92.9645H44.0357V44.0357H39.144C36.4414 44.0357 34.2509 41.8452 34.2509 39.1425C34.2509 36.4399 36.4414 34.2493 39.144 34.2493H53.8221V29.3577C53.8221 26.655 56.0126 24.4645 58.7153 24.4645C61.4179 24.4645 63.6084 26.655 63.6084 29.3577V34.2493H73.3933V29.3577C73.3933 26.655 75.5838 24.4645 78.2865 24.4645C80.9891 24.4645 83.1797 26.655 83.1797 29.3577V34.2493C93.9426 34.2045 102.705 42.8919 102.751 53.6548C102.775 59.3543 100.304 64.7791 95.9867 68.5001C100.263 72.1793 102.731 77.5354 102.751 83.1781V83.1781Z" fill="#FFF"/>
                    </svg>
                </div>
                <div class="card-body p-0 custome-tooltip">
                    <div id="widgetChart3" class="chart-primary"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6">
            <div class="card card-box bg-secondary">
                <div class="card-header border-0 pb-0">
                    <div class="chart-num-days">
                        <p>
                            <i class="fa-solid fa-sort-down me-2"></i>
                            4%(30 days)
                        </p>
                        <h2 class="count-num text-white">$65,123</h2>
                    </div>
                    <svg
                     xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     width="50px" height="50px">
                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                     d="M21.000,42.000 C9.402,42.000 -0.001,32.598 -0.001,21.000 C-0.001,9.402 9.402,-0.000 21.000,-0.000 C32.592,0.013 41.987,9.408 42.000,21.000 C42.000,32.598 32.598,42.000 21.000,42.000 ZM28.171,14.437 C28.383,14.172 28.499,13.843 28.499,13.504 C28.500,12.675 27.829,12.001 26.999,12.000 L22.499,12.000 L22.499,7.500 C22.499,6.672 21.828,6.000 21.000,6.000 C20.171,6.000 19.500,6.671 19.500,7.500 L19.500,12.000 L15.000,12.000 C14.171,12.000 13.499,12.671 13.499,13.500 C13.499,14.328 14.171,15.000 15.000,15.000 L23.878,15.000 L13.827,27.562 C13.615,27.829 13.499,28.160 13.499,28.501 C13.499,29.329 14.171,30.000 15.000,30.000 L19.500,30.000 L19.500,34.500 C19.500,35.328 20.171,36.000 21.000,36.000 C21.828,36.000 22.499,35.328 22.499,34.500 L22.499,30.000 L26.999,30.000 C27.828,30.000 28.500,29.328 28.500,28.500 C28.500,27.672 27.828,27.000 26.999,27.000 L18.121,27.000 L28.171,14.437 Z"/>
                    </svg>
                </div>
                <div class="card-body p-0 custome-tooltip">
                    <div id="widgetChart1" class="chart-primary"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6">
            <div class="card card-box bg-pink">
                <div class="card-header border-0 pb-0">
                    <div class="chart-num-days">
                        <p>
                            <i class="fa-solid fa-sort-down me-2"></i>
                            4%(30 days)
                        </p>
                        <h2 class="count-num text-white">$65,123</h2>
                    </div>
                    <svg width="50" height="50" viewBox="0 0 137 137" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M70.3615 78.5206C69.1671 78.9977 67.8366 78.9977 66.6421 78.5206L53.8232 73.3927L68.5018 102.75L83.1804 73.3927L70.3615 78.5206Z" fill="#FFF"/>
                    <path d="M68.4982 68.5L88.0696 61.6503L68.4982 34.25L48.9268 61.6503L68.4982 68.5Z" fill="#FFF"/>
                    <path d="M68.5 0C30.6686 0 0 30.6686 0 68.5C0 106.331 30.6686 137 68.5 137C106.331 137 137 106.331 137 68.5C136.958 30.6865 106.313 0.0418093 68.5 0V0ZM97.3409 65.7958L72.8765 114.725C71.6685 117.142 68.7285 118.122 66.3125 116.914C65.3643 116.44 64.5968 115.673 64.1235 114.725L39.6591 65.7958C38.899 64.2698 38.9856 62.4586 39.8875 61.0117L64.3519 21.8692C65.978 19.5787 69.151 19.0381 71.4416 20.6642C71.9089 20.9957 72.3166 21.4019 72.6481 21.8692L97.111 61.0117C98.0144 62.4586 98.101 64.2698 97.3409 65.7958V65.7958Z" fill="#FFF"/>
                    </svg>
                </div>
                <div class="card-body p-0 custome-tooltip">
                    <div id="widgetChart4" class="chart-primary"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6">
            <div class="card card-box bg-primary">
                <div class="card-header border-0 pb-0">
                    <div class="chart-num-days">
                        <p>
                            <i class="fa-solid fa-sort-down me-2"></i>
                            4%(30 days)
                        </p>
                        <h2 class="count-num text-white">$65,123</h2>
                    </div>
                    <svg width="50" height="45" viewBox="0 0 137 137" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M68.5 0C30.6686 0 0 30.6686 0 68.5C0 106.331 30.6686 137 68.5 137C106.331 137 137 106.331 137 68.5C136.958 30.6865 106.313 0.0418093 68.5 0ZM40.213 63.6068H59.7843C62.4869 63.6068 64.6774 65.7973 64.6774 68.5C64.6774 71.2027 62.4869 73.3932 59.7843 73.3932H40.213C37.5104 73.3932 35.3199 71.2027 35.3199 68.5C35.3199 65.7973 37.5119 63.6068 40.213 63.6068ZM101.393 56.6456L95.5088 86.0883C94.1231 92.9226 88.122 97.8411 81.1488 97.8576H40.213C37.5104 97.8576 35.3199 95.6671 35.3199 92.9644C35.3199 90.2617 37.5119 88.0712 40.213 88.0712H81.1488C83.4617 88.0652 85.4522 86.4347 85.9121 84.168L91.7982 54.7253C92.3208 52.0973 90.6156 49.544 87.9891 49.0214C87.677 48.9601 87.3605 48.9288 87.0439 48.9288H49.9994C47.2967 48.9288 45.1062 46.7383 45.1062 44.0356C45.1062 41.3329 47.2967 39.1424 49.9994 39.1424H87.0439C95.128 39.1454 101.679 45.699 101.677 53.7831C101.677 54.7433 101.582 55.7019 101.393 56.6456Z" fill="#FFF"></path>
                    </svg>
                </div>
                <div class="card-body p-0 custome-tooltip">
                    <div id="widgetChart2" class="chart-primary"></div>
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











            (function($) {
    /* "use strict" */

 var dzChartlist = function(){

	var screenWidth = $(window).width();
	//let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var widgetChart2 = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [200, 310, 50, 250, 50, 300, 100, 200,],
				//radius: 12,
			},
		],
			chart: {
			type: 'line',
			height: 70,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}

		},

		colors:['#0E8A74'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 6,
		  curve:'smooth',
		  colors:['rgba(255, 255, 255, 0.5)'],
		},

		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 10,
				right: 0,
				bottom: 20,
				left: 0

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: false,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 1,
		  colors:'#FB3E7A'
		},
		tooltip: {
			style: {
				fontSize: '13px',
				fontFamily: 'Poppins',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#widgetChart2"), options);
		chartBar1.render();

	}
	var widgetChart3 = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [200, 310, 50, 250, 50, 300, 100, 200,],
				//radius: 12,
			},
		],
			chart: {
			type: 'line',
			height: 70,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}

		},

		colors:['#0E8A74'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 6,
		  curve:'smooth',
		  colors:['rgba(255, 255, 255, 0.5)'],
		},

		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 10,
				right: 0,
				bottom: 20,
				left: 0

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: false,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 1,
		  colors:'#FB3E7A'
		},
		tooltip: {
			style: {
				fontSize: '13px',
				fontFamily: 'Poppins',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#widgetChart3"), options);
		chartBar1.render();

	}
	var widgetChart1 = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [200, 310, 50, 250, 50, 300, 100, 200,],
				//radius: 12,
			},
		],
			chart: {
			type: 'line',
			height: 70,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}

		},

		colors:['#0E8A74'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 6,
		  curve:'smooth',
		  colors:['rgba(255, 255, 255, 0.5)'],
		},

		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 10,
				right: 0,
				bottom: 20,
				left: 0

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: false,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 1,
		  colors:'#FB3E7A'
		},
		tooltip: {
			style: {
				fontSize: '13px',
				fontFamily: 'Poppins',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#widgetChart1"), options);
		chartBar1.render();

	}
	var widgetChart4 = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [200, 310, 50, 250, 50, 300, 100, 200,],
				//radius: 12,
			},
		],
			chart: {
			type: 'line',
			height: 70,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}

		},

		colors:['#0E8A74'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 6,
		  curve:'smooth',
		  colors:['rgba(255, 255, 255, 0.5)'],
		},

		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 10,
				right: 0,
				bottom: 20,
				left: 0

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: false,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 1,
		  colors:'#FB3E7A'
		},
		tooltip: {
			style: {
				fontSize: '13px',
				fontFamily: 'Poppins',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#widgetChart4"), options);
		chartBar1.render();

	}
	var btcStock = function(){
		var options = {
          series: [{
          data: [{
              x: new Date(1538778600000),
              y: [6629.81, 6650.5, 6623.04, 6633.33]
            },
            {
              x: new Date(1538780400000),
              y: [6632.01, 6643.59, 6620, 6630.11]
            },
            {
              x: new Date(1538782200000),
              y: [6630.71, 6648.95, 6623.34, 6635.65]
            },
            {
              x: new Date(1538784000000),
              y: [6635.65, 6651, 6629.67, 6638.24]
            },
            {
              x: new Date(1538785800000),
              y: [6638.24, 6640, 6620, 6624.47]
            },
            {
              x: new Date(1538787600000),
              y: [6624.53, 6636.03, 6621.68, 6624.31]
            },
            {
              x: new Date(1538789400000),
              y: [6624.61, 6632.2, 6617, 6626.02]
            },
            {
              x: new Date(1538791200000),
              y: [6627, 6627.62, 6584.22, 6603.02]
            },
            {
              x: new Date(1538793000000),
              y: [6605, 6608.03, 6598.95, 6604.01]
            },
            {
              x: new Date(1538794800000),
              y: [6604.5, 6614.4, 6602.26, 6608.02]
            },
            {
              x: new Date(1538796600000),
              y: [6608.02, 6610.68, 6601.99, 6608.91]
            },
            {
              x: new Date(1538798400000),
              y: [6608.91, 6618.99, 6608.01, 6612]
            },
            {
              x: new Date(1538800200000),
              y: [6612, 6615.13, 6605.09, 6612]
            },
            {
              x: new Date(1538802000000),
              y: [6612, 6624.12, 6608.43, 6622.95]
            },
            {
              x: new Date(1538803800000),
              y: [6623.91, 6623.91, 6615, 6615.67]
            },
            {
              x: new Date(1538805600000),
              y: [6618.69, 6618.74, 6610, 6610.4]
            },
            {
              x: new Date(1538807400000),
              y: [6611, 6622.78, 6610.4, 6614.9]
            },
            {
              x: new Date(1538809200000),
              y: [6614.9, 6626.2, 6613.33, 6623.45]
            },
            {
              x: new Date(1538811000000),
              y: [6623.48, 6627, 6618.38, 6620.35]
            },
            {
              x: new Date(1538812800000),
              y: [6619.43, 6620.35, 6610.05, 6615.53]
            },
            {
              x: new Date(1538814600000),
              y: [6615.53, 6617.93, 6610, 6615.19]
            },
            {
              x: new Date(1538816400000),
              y: [6615.19, 6621.6, 6608.2, 6620]
            },
            {
              x: new Date(1538818200000),
              y: [6619.54, 6625.17, 6614.15, 6620]
            },
            {
              x: new Date(1538820000000),
              y: [6620.33, 6634.15, 6617.24, 6624.61]
            },
            {
              x: new Date(1538821800000),
              y: [6625.95, 6626, 6611.66, 6617.58]
            },
            {
              x: new Date(1538823600000),
              y: [6619, 6625.97, 6595.27, 6598.86]
            },
            {
              x: new Date(1538825400000),
              y: [6598.86, 6598.88, 6570, 6587.16]
            },
            {
              x: new Date(1538827200000),
              y: [6588.86, 6600, 6580, 6593.4]
            },
            {
              x: new Date(1538829000000),
              y: [6593.99, 6598.89, 6585, 6587.81]
            },
            {
              x: new Date(1538830800000),
              y: [6587.81, 6592.73, 6567.14, 6578]
            },
            {
              x: new Date(1538832600000),
              y: [6578.35, 6581.72, 6567.39, 6579]
            },
            {
              x: new Date(1538834400000),
              y: [6579.38, 6580.92, 6566.77, 6575.96]
            },
            {


              x: new Date(1538836200000),
              y: [6575.96, 6589, 6571.77, 6588.92]
            },
            {
              x: new Date(1538838000000),
              y: [6588.92, 6594, 6577.55, 6589.22]
            },
            {
              x: new Date(1538839800000),
              y: [6589.3, 6598.89, 6589.1, 6596.08]
            },
            {
              x: new Date(1538841600000),
              y: [6597.5, 6600, 6588.39, 6596.25]
            },
            {
              x: new Date(1538843400000),
              y: [6598.03, 6600, 6588.73, 6595.97]
            },
            {
              x: new Date(1538845200000),
              y: [6595.97, 6602.01, 6588.17, 6602]
            },
            {
              x: new Date(1538847000000),
              y: [6602, 6607, 6596.51, 6599.95]
            },
            {
              x: new Date(1538848800000),
              y: [6600.63, 6601.21, 6590.39, 6591.02]
            },
            {
              x: new Date(1538850600000),
              y: [6591.02, 6603.08, 6591, 6591]
            },
            {
              x: new Date(1538852400000),
              y: [6591, 6601.32, 6585, 6592]
            },
            {
              x: new Date(1538854200000),
              y: [6593.13, 6596.01, 6590, 6593.34]
            },
            {
              x: new Date(1538856000000),
              y: [6593.34, 6604.76, 6582.63, 6593.86]
            },
            {
              x: new Date(1538857800000),
              y: [6593.86, 6604.28, 6586.57, 6600.01]
            },
            {
              x: new Date(1538859600000),
              y: [6601.81, 6603.21, 6592.78, 6596.25]
            },
            {
              x: new Date(1538861400000),
              y: [6596.25, 6604.2, 6590, 6602.99]
            },
            {
              x: new Date(1538863200000),
              y: [6602.99, 6606, 6584.99, 6587.81]
            },
            {
              x: new Date(1538865000000),
              y: [6587.81, 6595, 6583.27, 6591.96]
            },
            {
              x: new Date(1538866800000),
              y: [6591.97, 6596.07, 6585, 6588.39]
            },
            {
              x: new Date(1538868600000),
              y: [6587.6, 6598.21, 6587.6, 6594.27]
            },
            {
              x: new Date(1538870400000),
              y: [6596.44, 6601, 6590, 6596.55]
            },
            {
              x: new Date(1538872200000),
              y: [6598.91, 6605, 6596.61, 6600.02]
            },
            {
              x: new Date(1538874000000),
              y: [6600.55, 6605, 6589.14, 6593.01]
            },
            {
              x: new Date(1538875800000),
              y: [6593.15, 6605, 6592, 6603.06]
            },
            {
              x: new Date(1538877600000),
              y: [6603.07, 6604.5, 6599.09, 6603.89]
            },
            {
              x: new Date(1538879400000),
              y: [6604.44, 6604.44, 6600, 6603.5]
            },
            {
              x: new Date(1538881200000),
              y: [6603.5, 6603.99, 6597.5, 6603.86]
            },
            {
              x: new Date(1538883000000),
              y: [6603.85, 6605, 6600, 6604.07]
            },
            {
              x: new Date(1538884800000),
              y: [6604.98, 6606, 6604.07, 6606]
            },
          ]
        }],
          chart: {
          type: 'candlestick',
          height: 450,
		   toolbar: {
			   show: false
		   }
        },
		colors:['var(--primary), #000000'],
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          tooltip: {
            enabled: true
          }
        },
		plotOptions: {
		  candlestick: {
			colors: {
			  upward: '#0080ff',
			  downward: '#ff3f3f'
			}
		  }
		}
        };

        var chart = new ApexCharts(document.querySelector("#btcStock"), options);
        chart.render();

	}
	var swiperreview = function() {
		var swiper = new Swiper('.crypto1-Swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView:4,
			spaceBetween: 20,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
			breakpoints: {

			  300: {
				slidesPerView: 1,
				spaceBetween: 30,
			  },
			  991: {
				slidesPerView: 2,
				spaceBetween: 30,
			  },
			  1200: {
				slidesPerView: 4,
				spaceBetween: 30,
			  },
			},
		});
	}
	var widgetChart2 = function(){
		var options = {
		  series: [
			{
				name: 'Net Profit',
				data: [200, 310, 50, 250, 50, 300, 100, 200,],
				//radius: 12,
			},
		],
			chart: {
			type: 'line',
			height: 70,
			toolbar: {
				show: false,
			},
			zoom: {
				enabled: false
			},
			sparkline: {
				enabled: true
			}

		},

		colors:['#0E8A74'],
		dataLabels: {
		  enabled: false,
		},

		legend: {
			show: false,
		},
		stroke: {
		  show: true,
		  width: 6,
		  curve:'smooth',
		  colors:['rgba(255, 255, 255, 0.5)'],
		},

		grid: {
			show:false,
			borderColor: '#eee',
			padding: {
				top: 10,
				right: 0,
				bottom: 20,
				left: 0

			}
		},
		states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
		xaxis: {
			categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',],
			axisBorder: {
				show: false,
			},
			axisTicks: {
				show: false
			},
			labels: {
				show: false,
				style: {
					fontSize: '12px',
				}
			},
			crosshairs: {
				show: false,
				position: 'front',
				stroke: {
					width: 1,
					dashArray: 3
				}
			},
			tooltip: {
				enabled: false,
				formatter: undefined,
				offsetY: 0,
				style: {
					fontSize: '12px',
				}
			}
		},
		yaxis: {
			show: false,
		},
		fill: {
		  opacity: 1,
		  colors:'#FB3E7A'
		},
		tooltip: {
			style: {
				fontSize: '13px',
				fontFamily: 'Poppins',
			},
			y: {
				formatter: function(val) {
					return "$" + val + " thousands"
				}
			}
		}
		};

		var chartBar1 = new ApexCharts(document.querySelector("#widgetChart2"), options);
		chartBar1.render();

	}


	/* Function ============ */
		return {
			init:function(){
			},


			load:function(){
				widgetChart1();
				widgetChart2();
				swiperreview();
				widgetChart3();
				widgetChart4();
				btcStock();

			},

			resize:function(){
				widgetChart1();
			}
		}

	}();



	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000);

	});



})(jQuery);






    </script>
    @endpush
</x-backend.layouts.app>
