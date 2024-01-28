<x-backend.layouts.app>
    @section('title', $user->username .' | User profile')
    @section('header-title', 'View profile')
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">{{ $user->username }}'s Profile</li>
    @endsection

    {{-- ///////////////// Profile details ///////////// --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo rounded"></div>
                    </div>
                    <div class="profile-info align-items-center">
                        <div class="">
                            <img src="{{ $user->profile_photo_url }}" class="rounded-full h-20 w-20 object-cover" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{ $user->name }}</h4>
                                <p>
                                    Username: {{ $user->username }}
                                    @if($user->sponsor->id !== null)
                                        <br>
                                        Referral User: <code>
                                            <a href='{{ route('admin.users.profile.show', $user->sponsor)  }}'>{{ $user?->sponsor?->username }}</a>
                                        </code>
                                    @endif
                                </p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0"></h4>
                                <p>
                                    Email: {{ $user->email }} <br>
                                    Mobile: {{ $user->phone }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ///////////////////////////////////////////////////// --}}

    <div class="row">
        @can('wallet.viewAny')
            <div class="col-xl-4 col-lg-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card prim-card">
                            <div class="card-body py-3">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M45.333 9.3335H18.6663C16.191 9.3335 13.817 10.3168 12.0667 12.0672C10.3163 13.8175 9.33301 16.1915 9.33301 18.6668V45.3335C9.33301 47.8088 10.3163 50.1828 12.0667 51.9332C13.817 53.6835 16.191 54.6668 18.6663 54.6668H45.333C47.8084 54.6668 50.1823 53.6835 51.9327 51.9332C53.683 50.1828 54.6663 47.8088 54.6663 45.3335V18.6668C54.6663 16.1915 53.683 13.8175 51.9327 12.0672C50.1823 10.3168 47.8084 9.3335 45.333 9.3335ZM27.9997 14.6668H35.9997V22.6668H27.9997V14.6668ZM22.6663 49.3335H18.6663C17.6055 49.3335 16.5881 48.9121 15.8379 48.1619C15.0878 47.4118 14.6663 46.3944 14.6663 45.3335V41.3335H22.6663V49.3335ZM35.9997 49.3335H27.9997V41.3335H35.9997V49.3335ZM49.333 45.3335C49.333 46.3944 48.9116 47.4118 48.1614 48.1619C47.4113 48.9121 46.3939 49.3335 45.333 49.3335H41.333V41.3335H49.333V45.3335ZM49.333 36.0002H14.6663V18.6668C14.6663 17.606 15.0878 16.5885 15.8379 15.8384C16.5881 15.0883 17.6055 14.6668 18.6663 14.6668H22.6663V25.3335C22.6663 26.0407 22.9473 26.719 23.4474 27.2191C23.9475 27.7192 24.6258 28.0002 25.333 28.0002H49.333V36.0002ZM49.333 22.6668H41.333V14.6668H45.333C46.3939 14.6668 47.4113 15.0883 48.1614 15.8384C48.9116 16.5885 49.333 17.606 49.333 18.6668V22.6668Z"
                                        fill="white"/>
                                </svg>
                                <div class="d-flex">
                                    <h4 class="number mt-2 mb-0">
                                        {{ $wallet->currency ?? 'USDT' }} {{ number_format($wallet->balance,2) }}
                                    </h4>
                                    <div class="rec-design">
                                        <div class="rec-design1"></div>
                                        <div class="rec-design2"></div>
                                    </div>
                                </div>
                                <small>Withdraw Limit: USDT {{ number_format($wallet->withdraw_limit,2) }}</small>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="prim-info">
                                        <span>MAIN WALLET</span>
                                        <h4>AVAILABLE BALANCE</h4>
                                    </div>
                                    <div class="master-card">
                                        <img src="{{ asset('assets/backend/images/logo/logo.png') }}" alt="logo" width="88"/>
                                        {{-- <svg width="88" height="56" viewBox="0 0 88 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="28" cy="28" r="28" fill="#FF5B5B"/>
                                            <circle cx="60" cy="28" r="28" fill="#F79F19"/>
                                        </svg> --}}
                                        <span class="text-white d-block mt-1">cyber Eraa </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card prim-card">
                            <div class="card-body py-3">
                                <i class="material-icons text-white" style="font-size: 60px;">trending_up</i>
                                <div class="d-flex">
                                    <h4 class="number mt-2">{{ $wallet->currency }} {{ number_format($wallet->topup_balance,2) }}</h4>
                                    <div class="rec-design">
                                        <div class="rec-design1">
                                        </div>
                                        <div class="rec-design2">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="prim-info">
                                        <span>TOPUP WALLET</span>
                                        <h4>AVAILABLE BALANCE</h4>
                                    </div>
                                    <div class="master-card">
                                        <img src="{{ asset('assets/backend/images/logo/logo.png') }}" alt="logo" width="50"/>
                                        <span class="text-white d-block mt-1">cyber Eraa </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h2 class="heading mb-0 m-auto">Income</h2>
                            </div>
                            <div class="card-body text-center pt-3">
                                <div class="icon-box bg-primary">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30ZM6 19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19Z"
                                            fill="white"/>
                                        <path
                                            d="M16 26C16.7912 26 17.5645 25.7654 18.2223 25.3259C18.8801 24.8864 19.3928 24.2616 19.6955 23.5307C19.9983 22.7998 20.0775 21.9956 19.9232 21.2196C19.7688 20.4437 19.3879 19.731 18.8285 19.1716C18.269 18.6122 17.5563 18.2312 16.7804 18.0769C16.0045 17.9225 15.2002 18.0017 14.4693 18.3045C13.7384 18.6072 13.1137 19.1199 12.6741 19.7777C12.2346 20.4355 12 21.2089 12 22C12 23.0609 12.4215 24.0783 13.1716 24.8284C13.9217 25.5786 14.9392 26 16 26ZM16 20C16.3956 20 16.7823 20.1173 17.1112 20.3371C17.4401 20.5568 17.6964 20.8692 17.8478 21.2346C17.9992 21.6001 18.0388 22.0022 17.9616 22.3902C17.8844 22.7781 17.6939 23.1345 17.4142 23.4142C17.1345 23.6939 16.7782 23.8844 16.3902 23.9616C16.0022 24.0387 15.6001 23.9991 15.2347 23.8478C14.8692 23.6964 14.5569 23.44 14.3371 23.1111C14.1173 22.7822 14 22.3956 14 22C14 21.4696 14.2107 20.9609 14.5858 20.5858C14.9609 20.2107 15.4696 20 16 20ZM16 2C15.7348 2 15.4805 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V8.59L12.46 6.05C12.2687 5.88617 12.0227 5.80057 11.771 5.81029C11.5193 5.82001 11.2806 5.92434 11.1025 6.10244C10.9244 6.28053 10.82 6.51927 10.8103 6.77095C10.8006 7.02262 10.8862 7.2687 11.05 7.46L15.29 11.71C15.3822 11.8 15.4908 11.8713 15.61 11.92C15.7334 11.9723 15.866 11.9992 16 11.9992C16.134 11.9992 16.2666 11.9723 16.39 11.92C16.5092 11.8713 16.6179 11.8 16.71 11.71L21 7.46C21.1639 7.2687 21.2495 7.02262 21.2397 6.77095C21.23 6.51927 21.1257 6.28053 20.9476 6.10244C20.7695 5.92434 20.5308 5.82001 20.2791 5.81029C20.0274 5.80057 19.7813 5.88617 19.59 6.05L17 8.59V3C17 2.73478 16.8947 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                                <div class="mt-3">This Month</div>
                                <div class="count-num mt-1"><code class="fs-12">USDT</code> {{ $income }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h2 class="heading mb-0 m-auto">Withdraw</h2>
                            </div>
                            <div class="card-body text-center pt-3">
                                <div class="icon-box bg-primary">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19ZM26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19Z"
                                            fill="white"/>
                                        <path
                                            d="M16.0001 25.9999C16.7912 25.9999 17.5646 25.7653 18.2224 25.3258C18.8802 24.8863 19.3929 24.2616 19.6956 23.5307C19.9984 22.7998 20.0776 21.9955 19.9232 21.2196C19.7689 20.4437 19.3879 19.7309 18.8285 19.1715C18.2691 18.6121 17.5564 18.2311 16.7804 18.0768C16.0045 17.9225 15.2003 18.0017 14.4694 18.3044C13.7384 18.6072 13.1137 19.1199 12.6742 19.7777C12.2347 20.4355 12.0001 21.2088 12.0001 21.9999C12.0001 23.0608 12.4215 24.0782 13.1717 24.8284C13.9218 25.5785 14.9392 25.9999 16.0001 25.9999ZM16.0001 19.9999C16.3956 19.9999 16.7823 20.1172 17.1112 20.337C17.4401 20.5568 17.6965 20.8691 17.8478 21.2346C17.9992 21.6 18.0388 22.0022 17.9617 22.3901C17.8845 22.7781 17.694 23.1344 17.4143 23.4142C17.1346 23.6939 16.7782 23.8843 16.3903 23.9615C16.0023 24.0387 15.6002 23.9991 15.2347 23.8477C14.8693 23.6963 14.5569 23.44 14.3371 23.1111C14.1174 22.7822 14.0001 22.3955 14.0001 21.9999C14.0001 21.4695 14.2108 20.9608 14.5859 20.5857C14.9609 20.2107 15.4697 19.9999 16.0001 19.9999ZM16.7101 2.28994C16.6171 2.19621 16.5065 2.12182 16.3847 2.07105C16.2628 2.02028 16.1321 1.99414 16.0001 1.99414C15.8681 1.99414 15.7374 2.02028 15.6155 2.07105C15.4937 2.12182 15.383 2.19621 15.2901 2.28994L11.0501 6.53994C10.8565 6.72692 10.7451 6.98315 10.7404 7.25226C10.7357 7.52138 10.8381 7.78133 11.0251 7.97494C11.2121 8.16855 11.4683 8.27995 11.7374 8.28464C12.0065 8.28933 12.2665 8.18692 12.4601 7.99994L15.0001 5.40994V10.9999C15.0001 11.2652 15.1054 11.5195 15.293 11.707C15.4805 11.8946 15.7349 11.9999 16.0001 11.9999C16.2653 11.9999 16.5197 11.8946 16.7072 11.707C16.8947 11.5195 17.0001 11.2652 17.0001 10.9999V5.40994L19.5401 7.99994C19.7263 8.18468 19.9777 8.28883 20.2401 8.28994C20.38 8.29755 20.52 8.27567 20.6509 8.22571C20.7818 8.17575 20.9008 8.09883 21.0001 7.99994C21.1863 7.81258 21.2909 7.55912 21.2909 7.29494C21.2909 7.03075 21.1863 6.7773 21.0001 6.58994L16.7101 2.28994Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                                <div class="mt-3">This Month</div>
                                <div class="count-num mt-1"><code class="fs-12">USDT</code> {{ $withdraw }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h2 class="heading mb-0 m-auto  text-responsiv">Commissions</h2>
                            </div>
                            <div class="card-body text-center pt-3">
                                <div class="icon-box bg-primary">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30ZM6 19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19Z"
                                            fill="white"/>
                                        <path
                                            d="M16 26C16.7912 26 17.5645 25.7654 18.2223 25.3259C18.8801 24.8864 19.3928 24.2616 19.6955 23.5307C19.9983 22.7998 20.0775 21.9956 19.9232 21.2196C19.7688 20.4437 19.3879 19.731 18.8285 19.1716C18.269 18.6122 17.5563 18.2312 16.7804 18.0769C16.0045 17.9225 15.2002 18.0017 14.4693 18.3045C13.7384 18.6072 13.1137 19.1199 12.6741 19.7777C12.2346 20.4355 12 21.2089 12 22C12 23.0609 12.4215 24.0783 13.1716 24.8284C13.9217 25.5786 14.9392 26 16 26ZM16 20C16.3956 20 16.7823 20.1173 17.1112 20.3371C17.4401 20.5568 17.6964 20.8692 17.8478 21.2346C17.9992 21.6001 18.0388 22.0022 17.9616 22.3902C17.8844 22.7781 17.6939 23.1345 17.4142 23.4142C17.1345 23.6939 16.7782 23.8844 16.3902 23.9616C16.0022 24.0387 15.6001 23.9991 15.2347 23.8478C14.8692 23.6964 14.5569 23.44 14.3371 23.1111C14.1173 22.7822 14 22.3956 14 22C14 21.4696 14.2107 20.9609 14.5858 20.5858C14.9609 20.2107 15.4696 20 16 20ZM16 2C15.7348 2 15.4805 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V8.59L12.46 6.05C12.2687 5.88617 12.0227 5.80057 11.771 5.81029C11.5193 5.82001 11.2806 5.92434 11.1025 6.10244C10.9244 6.28053 10.82 6.51927 10.8103 6.77095C10.8006 7.02262 10.8862 7.2687 11.05 7.46L15.29 11.71C15.3822 11.8 15.4908 11.8713 15.61 11.92C15.7334 11.9723 15.866 11.9992 16 11.9992C16.134 11.9992 16.2666 11.9723 16.39 11.92C16.5092 11.8713 16.6179 11.8 16.71 11.71L21 7.46C21.1639 7.2687 21.2495 7.02262 21.2397 6.77095C21.23 6.51927 21.1257 6.28053 20.9476 6.10244C20.7695 5.92434 20.5308 5.82001 20.2791 5.81029C20.0274 5.80057 19.7813 5.88617 19.59 6.05L17 8.59V3C17 2.73478 16.8947 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                                <div class="mt-3">This Month</div>
                                <div class="count-num mt-1"><code class="fs-12">USDT</code> {{ $qualified_commissions }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h2 class="heading mb-0 m-auto">Losts</h2>
                            </div>
                            <div class="card-body text-center pt-3">
                                <div class="icon-box bg-primary">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19ZM26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19Z"
                                            fill="white"/>
                                        <path
                                            d="M16.0001 25.9999C16.7912 25.9999 17.5646 25.7653 18.2224 25.3258C18.8802 24.8863 19.3929 24.2616 19.6956 23.5307C19.9984 22.7998 20.0776 21.9955 19.9232 21.2196C19.7689 20.4437 19.3879 19.7309 18.8285 19.1715C18.2691 18.6121 17.5564 18.2311 16.7804 18.0768C16.0045 17.9225 15.2003 18.0017 14.4694 18.3044C13.7384 18.6072 13.1137 19.1199 12.6742 19.7777C12.2347 20.4355 12.0001 21.2088 12.0001 21.9999C12.0001 23.0608 12.4215 24.0782 13.1717 24.8284C13.9218 25.5785 14.9392 25.9999 16.0001 25.9999ZM16.0001 19.9999C16.3956 19.9999 16.7823 20.1172 17.1112 20.337C17.4401 20.5568 17.6965 20.8691 17.8478 21.2346C17.9992 21.6 18.0388 22.0022 17.9617 22.3901C17.8845 22.7781 17.694 23.1344 17.4143 23.4142C17.1346 23.6939 16.7782 23.8843 16.3903 23.9615C16.0023 24.0387 15.6002 23.9991 15.2347 23.8477C14.8693 23.6963 14.5569 23.44 14.3371 23.1111C14.1174 22.7822 14.0001 22.3955 14.0001 21.9999C14.0001 21.4695 14.2108 20.9608 14.5859 20.5857C14.9609 20.2107 15.4697 19.9999 16.0001 19.9999ZM16.7101 2.28994C16.6171 2.19621 16.5065 2.12182 16.3847 2.07105C16.2628 2.02028 16.1321 1.99414 16.0001 1.99414C15.8681 1.99414 15.7374 2.02028 15.6155 2.07105C15.4937 2.12182 15.383 2.19621 15.2901 2.28994L11.0501 6.53994C10.8565 6.72692 10.7451 6.98315 10.7404 7.25226C10.7357 7.52138 10.8381 7.78133 11.0251 7.97494C11.2121 8.16855 11.4683 8.27995 11.7374 8.28464C12.0065 8.28933 12.2665 8.18692 12.4601 7.99994L15.0001 5.40994V10.9999C15.0001 11.2652 15.1054 11.5195 15.293 11.707C15.4805 11.8946 15.7349 11.9999 16.0001 11.9999C16.2653 11.9999 16.5197 11.8946 16.7072 11.707C16.8947 11.5195 17.0001 11.2652 17.0001 10.9999V5.40994L19.5401 7.99994C19.7263 8.18468 19.9777 8.28883 20.2401 8.28994C20.38 8.29755 20.52 8.27567 20.6509 8.22571C20.7818 8.17575 20.9008 8.09883 21.0001 7.99994C21.1863 7.81258 21.2909 7.55912 21.2909 7.29494C21.2909 7.03075 21.1863 6.7773 21.0001 6.58994L16.7101 2.28994Z"
                                            fill="white"/>
                                    </svg>
                                </div>
                                <div class="mt-3">This Month</div>
                                <div class="count-num mt-1"><code class="fs-12">USDT</code> {{ $lost_commissions }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <div class="col-xl-8">
            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <h4 class="text-primary">Personal information</h4>
                                <hr>
                                <div class="profile-personal-info">

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> NIC no <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->nic}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> Passport no <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->passport_number}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> Driving license no<span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->driving_lc_number}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> Name <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->name}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">User name <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->username}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Date of birthday <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->dob }}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Gender <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->gender  }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <h4 class="text-primary">Locations information</h4>
                                <hr>
                                <div class="profile-personal-info">

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> Address <span class="pull-end"> : </span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->address }}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Country <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->country['name']}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">State <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->state}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">City <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->city}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Street <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->street}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Zip <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->zip_code}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <h4 class="text-primary">Contacts information</h4>
                                <hr>
                                <div class="profile-personal-info">

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Email <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->email}}</h5>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500"> Phone No <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->phone}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Home phone no <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->home_phone }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <h4 class="text-primary">Bank information</h4>
                                <hr>
                                <div class="profile-personal-info">

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Wallet Address (TRC20 USDT) <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7">
                                            <h5 class="copy-to-clipboard"  data-clipboard-text="{{$user->profile->wallet_address}}">{{$user->profile->wallet_address}} <i class="fa fa-clone"
                                                style="font-size: 17px;"></i></h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card h-auto">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <div class="tab-content">
                                <h4 class="text-primary">Verified & created information</h4>
                                <hr>
                                <div class="profile-personal-info">

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Account created at <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->created_at}}</h5>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Account updated at <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->updated_at}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">NIC Verified At <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{$user->profile->nic_verified_at}}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Passport verified at <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><h5>{{ $user->profile->passport_verified_at }}</h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Driving lc verified at <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7">
                                            <h5>{{ $user->profile->driving_lc_verified_at }}</h5>
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
    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Same Kyc Users</h4>
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
                                    <th><strong>SPONSOR</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sameKycUsers as $kyc_user)
                                    <tr>
                                        <td>{{ $kyc_user->id }}</td>
                                        <td class="text-success">{{ $kyc_user->username }}</td>
                                        <td class="text-success">{{ $kyc_user->name }}</td>
                                        <td>{{ $kyc_user->email }}</td>
                                        <td>{{ $kyc_user->sponsor->username }}</td>
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
        @can('transactions.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">Transaction/Sales</h4>
                        </div>
                        @include('backend.admin.users.transactions.components.report-table')
                    </div>
                </div>
            </div>
        @endcan
        @can('wallet.topup-history.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">Topup History</h4>
                        </div>
                        @include('backend.admin.users.wallets.components.report-table')
                    </div>
                </div>
            </div>
        @endcan
        @can('withdraw.p2p.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">P2P History</h4>
                        </div>
                        @include('backend.admin.users.transfers.components.report-table')
                    </div>
                </div>
            </div>
        @endcan
        @can('withdrawals.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">Withdrawals</h4>
                        </div>
                        @include('backend.admin.users.transfers.components.withdraw-report-table')
                    </div>
                </div>
            </div>
        @endcan
        @can('commissions.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">Commissions</h4>
                        </div>
                        @include('backend.admin.users.incomes.components.report-table')
                    </div>
                </div>
            </div>
        @endcan
        @can('earnings.viewAny')
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title">Earnings/Incomes</h4>
                        </div>
                        @include('backend.admin.users.earnings.components.report-table')
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <input id="user_id" type="hidden" value="{{ $user->id }}"/>
    @push('scripts')
        <script !src="">
            const TRANSACTION_URL = "{{ route('admin.transactions.index', ['user_id' => $user->id]) }}";
            const TOPUP_HISTORY_URL = "{{ route('admin.wallet.topup.history', ['user_id' => $user->id]) }}";
            const P2P_URL = "{{ route('admin.transfers.p2p', ['user_id' => $user->id]) }}";
            const WITHDRAW_REPORT_URL = "{{ route('admin.transfers.withdrawals', ['user_id' => $user->id]) }}";
            const INCOMES_URL = "{{ route('admin.incomes.commission', ['user_id' => $user->id]) }}";
            const EARNING_URL = "{{ route('admin.earnings.index', ['user_id' => $user->id]) }}";
            const HISTORY_STATE = false;
        </script>
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>

        <script src="{{ asset('assets/backend/js/admin/transactions/main.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/wallets/history.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/transfers/p2p.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/transfers/withdraws.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/incomes/commissions.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/earnings/earnings.js') }}"></script>

        <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>
         <script !src="">
                let clipboard = new ClipboardJS('.copy-to-clipboard');

            // Handle copy success
            clipboard.on('success', function (e) {
                Toast.fire({
                    icon: 'success', title: 'Address copied to clipboard!',
                })
                e.clearSelection();
            });
    </script>

    @endpush
</x-backend.layouts.app>
