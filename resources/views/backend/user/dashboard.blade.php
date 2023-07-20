<x-backend.layouts.app>
    @section('title', 'User Dashboard')
    @section('header-title', 'Welcome ' . Auth::user()->name)
    @section('header-title2',Auth::user()->username)


    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card bubles rounded-3 profile-card-bg-image">
                                <div class="card-body ref-card-body">
                                    <div class="bubles-down buy-coin d-flex justify-content-between mb-0 mx-0">
                                        <div class="w-100">
                                            <h1 class="mb-0 lh-1 text-uppercase">{{ Auth::user()->username }}</h1>
                                            <p class="fs-26 mb-1 mx-0 text-muted w-100 text-uppercase">{{ Auth::user()->name }}</p>
                                            <p class="fs-16 fw-bold text-warning">{{ Auth::user()->currentRank->rank ?? 'NO' }} STAR </p>

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
                                            @if (Auth::user()->id === config('fortify.super_parent_id') || (Auth::user()->parent_id !== null && Auth::user()->position !== null))
                                                <div class="btn-genealogy btn-genealogy mt-2">
                                                    <a href="{{ route('user.genealogy.position.register') }}" class="btn btn-info rounded-3 profile-card-btn">
                                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                        Registration new user
                                                    </a>

                                                    <a href="{{ route('user.genealogy') }}" class="btn btn-info rounded-3 profile-card-btn">
                                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                                        My genealogy
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="float-left width-295  rounded-3">
                                            <img src="{{ Auth::user()->profile_photo_url }}" class=" w-100 profile-img-border img-round profile-pic-m" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ number_format($invest_income,2) }}</h4>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{$qualified_commissions }}</h4>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{$pending_commissions }}</h4>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $income }}</h4>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> USDT {{ $today_income }}</h4>
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
                                                    <h4 class="text-white user-dashboard-card-font-size-change"> {{$descendants_count }}</h4>
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
                                            <button class="last-income-round nav-link border border-right  active" id="nav-package-earning-tab last-income-round" data-bs-toggle="tab"
                                                    data-bs-target="#nav-package-earning" type="button" role="tab"
                                                    aria-controls="nav-package-earning" aria-selected="true">Latest Package Earnings
                                            </button>
                                            <button class="nav-link border border-left" id="nav-direct-sale-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-direct-sale" type="button" role="tab"
                                                    aria-controls="nav-direct-sale" aria-selected="false">Direct Sales
                                            </button>
                                            <button class="nav-link border border-left " id="nav-indirect-sale-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-indirect-sale" type="button" role="tab"
                                                    aria-controls="nav-indirect-sale" aria-selected="false">In-Direct Sales
                                            </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent3">
                                        <div class="tab-pane fade show active" id="nav-package-earning" role="tabpanel" aria-labelledby="package-earning-tab">
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
                                                        <span class="p-0">{{ $day_earn->earnable->package_info_json->name }}</span>
                                                        <span class="p-0">{{ $day_earn->payed_percentage ?? $day_earn->earnable->payable_percentage }}%</span>
                                                        <span class="p-0">{{ $day_earn->created_at->format('Y-m-d') }}</span>
                                                        <div class="bg-layer"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-direct-sale" role="tabpanel" aria-labelledby="nav-direct-sale-tab">
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
                                                        <span class="p-0">{{ $sale->purchasedPackage->user->username }}</span>
                                                        <span class="p-0">{{ Carbon::parse($sale->next_payment_date)->format('Y-m-d') }}</span>
                                                        <div class="bg-layer"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-indirect-sale" role="tabpanel" aria-labelledby="nav-indirect-sale-tab">
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
                                            <td class="py-1">{{ Carbon::parse($ranker->activated_at)->format('Y-m-d h:i A') }}</td>
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

        {{--    popups--}}
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


        {{--    popups--}}
        <div class="modal fade" id="birthday-modal">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <img src="{{ asset('assets/backend/images/bday-wish.jpeg') }}" alt="Happy Birthday" class="rounded-2 w-100">
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
