<x-backend.layouts.app>
    @section('title', 'Wallet')
    @section('header-title', 'My Wallet' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">My Wallet</li>
    @endsection

    <div class="alert alert-info">
        Effective from 2023-02-02 All package earnings will be generated after 3 working days from the date of purchase. This will affect all packages purchased from 01-02-2023 onwards.
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-4">
            <div class="card prim-card">
                <div class="card-body py-3">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.333 9.3335H18.6663C16.191 9.3335 13.817 10.3168 12.0667 12.0672C10.3163 13.8175 9.33301 16.1915 9.33301 18.6668V45.3335C9.33301 47.8088 10.3163 50.1828 12.0667 51.9332C13.817 53.6835 16.191 54.6668 18.6663 54.6668H45.333C47.8084 54.6668 50.1823 53.6835 51.9327 51.9332C53.683 50.1828 54.6663 47.8088 54.6663 45.3335V18.6668C54.6663 16.1915 53.683 13.8175 51.9327 12.0672C50.1823 10.3168 47.8084 9.3335 45.333 9.3335ZM27.9997 14.6668H35.9997V22.6668H27.9997V14.6668ZM22.6663 49.3335H18.6663C17.6055 49.3335 16.5881 48.9121 15.8379 48.1619C15.0878 47.4118 14.6663 46.3944 14.6663 45.3335V41.3335H22.6663V49.3335ZM35.9997 49.3335H27.9997V41.3335H35.9997V49.3335ZM49.333 45.3335C49.333 46.3944 48.9116 47.4118 48.1614 48.1619C47.4113 48.9121 46.3939 49.3335 45.333 49.3335H41.333V41.3335H49.333V45.3335ZM49.333 36.0002H14.6663V18.6668C14.6663 17.606 15.0878 16.5885 15.8379 15.8384C16.5881 15.0883 17.6055 14.6668 18.6663 14.6668H22.6663V25.3335C22.6663 26.0407 22.9473 26.719 23.4474 27.2191C23.9475 27.7192 24.6258 28.0002 25.333 28.0002H49.333V36.0002ZM49.333 22.6668H41.333V14.6668H45.333C46.3939 14.6668 47.4113 15.0883 48.1614 15.8384C48.9116 16.5885 49.333 17.606 49.333 18.6668V22.6668Z" fill="white"/>
                    </svg>
                    <div class="d-flex">
                        <h4 class="number mt-2">{{ $wallet->currency }} {{ number_format($wallet->balance,2) }}</h4>
                        <div class="rec-design">
                            <div class="rec-design1">
                            </div>
                            <div class="rec-design2">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="prim-info">
                            <span>MAIN WALLET</span>
                            <h4>AVAILABLE BALANCE</h4>
                        </div>
                        <div class="master-card">
                            <img src="{{ asset('assets/backend/images/logo/logo.png') }}" alt="logo" width="50"/>
                            {{--<svg width="88" height="56" viewBox="0 0 88 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="28" cy="28" r="28" fill="#FF5B5B"/>
                                <circle cx="60" cy="28" r="28" fill="#F79F19"/>
                            </svg>--}}
                            <span class="text-white d-block mt-1">owara3m</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
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
                            <span class="text-white d-block mt-1">owara3m</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-2">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h5 class="fs-18 heading mb-0 m-auto">Income <code class="fs-12">USDT</code></h5>
                </div>
                <div class="card-body text-center pt-3">
                    <div class="icon-box bg-primary">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30ZM6 19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19Z" fill="white"/>
                            <path d="M16 26C16.7912 26 17.5645 25.7654 18.2223 25.3259C18.8801 24.8864 19.3928 24.2616 19.6955 23.5307C19.9983 22.7998 20.0775 21.9956 19.9232 21.2196C19.7688 20.4437 19.3879 19.731 18.8285 19.1716C18.269 18.6122 17.5563 18.2312 16.7804 18.0769C16.0045 17.9225 15.2002 18.0017 14.4693 18.3045C13.7384 18.6072 13.1137 19.1199 12.6741 19.7777C12.2346 20.4355 12 21.2089 12 22C12 23.0609 12.4215 24.0783 13.1716 24.8284C13.9217 25.5786 14.9392 26 16 26ZM16 20C16.3956 20 16.7823 20.1173 17.1112 20.3371C17.4401 20.5568 17.6964 20.8692 17.8478 21.2346C17.9992 21.6001 18.0388 22.0022 17.9616 22.3902C17.8844 22.7781 17.6939 23.1345 17.4142 23.4142C17.1345 23.6939 16.7782 23.8844 16.3902 23.9616C16.0022 24.0387 15.6001 23.9991 15.2347 23.8478C14.8692 23.6964 14.5569 23.44 14.3371 23.1111C14.1173 22.7822 14 22.3956 14 22C14 21.4696 14.2107 20.9609 14.5858 20.5858C14.9609 20.2107 15.4696 20 16 20ZM16 2C15.7348 2 15.4805 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V8.59L12.46 6.05C12.2687 5.88617 12.0227 5.80057 11.771 5.81029C11.5193 5.82001 11.2806 5.92434 11.1025 6.10244C10.9244 6.28053 10.82 6.51927 10.8103 6.77095C10.8006 7.02262 10.8862 7.2687 11.05 7.46L15.29 11.71C15.3822 11.8 15.4908 11.8713 15.61 11.92C15.7334 11.9723 15.866 11.9992 16 11.9992C16.134 11.9992 16.2666 11.9723 16.39 11.92C16.5092 11.8713 16.6179 11.8 16.71 11.71L21 7.46C21.1639 7.2687 21.2495 7.02262 21.2397 6.77095C21.23 6.51927 21.1257 6.28053 20.9476 6.10244C20.7695 5.92434 20.5308 5.82001 20.2791 5.81029C20.0274 5.80057 19.7813 5.88617 19.59 6.05L17 8.59V3C17 2.73478 16.8947 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="mt-3">This Month</div>
                    <div class="count-num mt-1 fs-18"> {{ $income }}</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-2">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h5 class="fs-18 heading mb-0 m-auto">Withdraw <code class="fs-12">USDT</code></h5>
                </div>
                <div class="card-body text-center pt-3">
                    <div class="icon-box bg-primary">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19ZM26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19Z" fill="white"/>
                            <path d="M16.0001 25.9999C16.7912 25.9999 17.5646 25.7653 18.2224 25.3258C18.8802 24.8863 19.3929 24.2616 19.6956 23.5307C19.9984 22.7998 20.0776 21.9955 19.9232 21.2196C19.7689 20.4437 19.3879 19.7309 18.8285 19.1715C18.2691 18.6121 17.5564 18.2311 16.7804 18.0768C16.0045 17.9225 15.2003 18.0017 14.4694 18.3044C13.7384 18.6072 13.1137 19.1199 12.6742 19.7777C12.2347 20.4355 12.0001 21.2088 12.0001 21.9999C12.0001 23.0608 12.4215 24.0782 13.1717 24.8284C13.9218 25.5785 14.9392 25.9999 16.0001 25.9999ZM16.0001 19.9999C16.3956 19.9999 16.7823 20.1172 17.1112 20.337C17.4401 20.5568 17.6965 20.8691 17.8478 21.2346C17.9992 21.6 18.0388 22.0022 17.9617 22.3901C17.8845 22.7781 17.694 23.1344 17.4143 23.4142C17.1346 23.6939 16.7782 23.8843 16.3903 23.9615C16.0023 24.0387 15.6002 23.9991 15.2347 23.8477C14.8693 23.6963 14.5569 23.44 14.3371 23.1111C14.1174 22.7822 14.0001 22.3955 14.0001 21.9999C14.0001 21.4695 14.2108 20.9608 14.5859 20.5857C14.9609 20.2107 15.4697 19.9999 16.0001 19.9999ZM16.7101 2.28994C16.6171 2.19621 16.5065 2.12182 16.3847 2.07105C16.2628 2.02028 16.1321 1.99414 16.0001 1.99414C15.8681 1.99414 15.7374 2.02028 15.6155 2.07105C15.4937 2.12182 15.383 2.19621 15.2901 2.28994L11.0501 6.53994C10.8565 6.72692 10.7451 6.98315 10.7404 7.25226C10.7357 7.52138 10.8381 7.78133 11.0251 7.97494C11.2121 8.16855 11.4683 8.27995 11.7374 8.28464C12.0065 8.28933 12.2665 8.18692 12.4601 7.99994L15.0001 5.40994V10.9999C15.0001 11.2652 15.1054 11.5195 15.293 11.707C15.4805 11.8946 15.7349 11.9999 16.0001 11.9999C16.2653 11.9999 16.5197 11.8946 16.7072 11.707C16.8947 11.5195 17.0001 11.2652 17.0001 10.9999V5.40994L19.5401 7.99994C19.7263 8.18468 19.9777 8.28883 20.2401 8.28994C20.38 8.29755 20.52 8.27567 20.6509 8.22571C20.7818 8.17575 20.9008 8.09883 21.0001 7.99994C21.1863 7.81258 21.2909 7.55912 21.2909 7.29494C21.2909 7.03075 21.1863 6.7773 21.0001 6.58994L16.7101 2.28994Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="mt-3">This Month</div>
                    <div class="count-num mt-1 fs-18"> {{ $withdraw }}</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-2">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h5 class="fs-16 heading mb-0 m-auto  text-responsiv">Commissions <code class="fs-12">USDT</code></h5>
                </div>
                <div class="card-body text-center pt-3">
                    <div class="icon-box bg-primary">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30ZM6 19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19Z" fill="white"/>
                            <path d="M16 26C16.7912 26 17.5645 25.7654 18.2223 25.3259C18.8801 24.8864 19.3928 24.2616 19.6955 23.5307C19.9983 22.7998 20.0775 21.9956 19.9232 21.2196C19.7688 20.4437 19.3879 19.731 18.8285 19.1716C18.269 18.6122 17.5563 18.2312 16.7804 18.0769C16.0045 17.9225 15.2002 18.0017 14.4693 18.3045C13.7384 18.6072 13.1137 19.1199 12.6741 19.7777C12.2346 20.4355 12 21.2089 12 22C12 23.0609 12.4215 24.0783 13.1716 24.8284C13.9217 25.5786 14.9392 26 16 26ZM16 20C16.3956 20 16.7823 20.1173 17.1112 20.3371C17.4401 20.5568 17.6964 20.8692 17.8478 21.2346C17.9992 21.6001 18.0388 22.0022 17.9616 22.3902C17.8844 22.7781 17.6939 23.1345 17.4142 23.4142C17.1345 23.6939 16.7782 23.8844 16.3902 23.9616C16.0022 24.0387 15.6001 23.9991 15.2347 23.8478C14.8692 23.6964 14.5569 23.44 14.3371 23.1111C14.1173 22.7822 14 22.3956 14 22C14 21.4696 14.2107 20.9609 14.5858 20.5858C14.9609 20.2107 15.4696 20 16 20ZM16 2C15.7348 2 15.4805 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V8.59L12.46 6.05C12.2687 5.88617 12.0227 5.80057 11.771 5.81029C11.5193 5.82001 11.2806 5.92434 11.1025 6.10244C10.9244 6.28053 10.82 6.51927 10.8103 6.77095C10.8006 7.02262 10.8862 7.2687 11.05 7.46L15.29 11.71C15.3822 11.8 15.4908 11.8713 15.61 11.92C15.7334 11.9723 15.866 11.9992 16 11.9992C16.134 11.9992 16.2666 11.9723 16.39 11.92C16.5092 11.8713 16.6179 11.8 16.71 11.71L21 7.46C21.1639 7.2687 21.2495 7.02262 21.2397 6.77095C21.23 6.51927 21.1257 6.28053 20.9476 6.10244C20.7695 5.92434 20.5308 5.82001 20.2791 5.81029C20.0274 5.80057 19.7813 5.88617 19.59 6.05L17 8.59V3C17 2.73478 16.8947 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="mt-3">This Month</div>
                    <div class="count-num mt-1 fs-18"> {{ $qualified_commissions }}</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-2 col-xl-2">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h5 class="fs-18 heading mb-0 m-auto">Losts <code class="fs-12">USDT</code></h5>
                </div>
                <div class="card-body text-center pt-3">
                    <div class="icon-box bg-primary">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19V25C4 26.3261 4.52678 27.5979 5.46447 28.5355C6.40215 29.4732 7.67392 30 9 30H23C24.3261 30 25.5979 29.4732 26.5355 28.5355C27.4732 27.5979 28 26.3261 28 25V19C28 17.6739 27.4732 16.4021 26.5355 15.4645C25.5979 14.5268 24.3261 14 23 14H9C7.67392 14 6.40215 14.5268 5.46447 15.4645C4.52678 16.4021 4 17.6739 4 19ZM26 19V25C26 25.7956 25.6839 26.5587 25.1213 27.1213C24.5587 27.6839 23.7956 28 23 28H9C8.20435 28 7.44129 27.6839 6.87868 27.1213C6.31607 26.5587 6 25.7956 6 25V19C6 18.2044 6.31607 17.4413 6.87868 16.8787C7.44129 16.3161 8.20435 16 9 16H23C23.7956 16 24.5587 16.3161 25.1213 16.8787C25.6839 17.4413 26 18.2044 26 19Z" fill="white"/>
                            <path d="M16.0001 25.9999C16.7912 25.9999 17.5646 25.7653 18.2224 25.3258C18.8802 24.8863 19.3929 24.2616 19.6956 23.5307C19.9984 22.7998 20.0776 21.9955 19.9232 21.2196C19.7689 20.4437 19.3879 19.7309 18.8285 19.1715C18.2691 18.6121 17.5564 18.2311 16.7804 18.0768C16.0045 17.9225 15.2003 18.0017 14.4694 18.3044C13.7384 18.6072 13.1137 19.1199 12.6742 19.7777C12.2347 20.4355 12.0001 21.2088 12.0001 21.9999C12.0001 23.0608 12.4215 24.0782 13.1717 24.8284C13.9218 25.5785 14.9392 25.9999 16.0001 25.9999ZM16.0001 19.9999C16.3956 19.9999 16.7823 20.1172 17.1112 20.337C17.4401 20.5568 17.6965 20.8691 17.8478 21.2346C17.9992 21.6 18.0388 22.0022 17.9617 22.3901C17.8845 22.7781 17.694 23.1344 17.4143 23.4142C17.1346 23.6939 16.7782 23.8843 16.3903 23.9615C16.0023 24.0387 15.6002 23.9991 15.2347 23.8477C14.8693 23.6963 14.5569 23.44 14.3371 23.1111C14.1174 22.7822 14.0001 22.3955 14.0001 21.9999C14.0001 21.4695 14.2108 20.9608 14.5859 20.5857C14.9609 20.2107 15.4697 19.9999 16.0001 19.9999ZM16.7101 2.28994C16.6171 2.19621 16.5065 2.12182 16.3847 2.07105C16.2628 2.02028 16.1321 1.99414 16.0001 1.99414C15.8681 1.99414 15.7374 2.02028 15.6155 2.07105C15.4937 2.12182 15.383 2.19621 15.2901 2.28994L11.0501 6.53994C10.8565 6.72692 10.7451 6.98315 10.7404 7.25226C10.7357 7.52138 10.8381 7.78133 11.0251 7.97494C11.2121 8.16855 11.4683 8.27995 11.7374 8.28464C12.0065 8.28933 12.2665 8.18692 12.4601 7.99994L15.0001 5.40994V10.9999C15.0001 11.2652 15.1054 11.5195 15.293 11.707C15.4805 11.8946 15.7349 11.9999 16.0001 11.9999C16.2653 11.9999 16.5197 11.8946 16.7072 11.707C16.8947 11.5195 17.0001 11.2652 17.0001 10.9999V5.40994L19.5401 7.99994C19.7263 8.18468 19.9777 8.28883 20.2401 8.28994C20.38 8.29755 20.52 8.27567 20.6509 8.22571C20.7818 8.17575 20.9008 8.09883 21.0001 7.99994C21.1863 7.81258 21.2909 7.55912 21.2909 7.29494C21.2909 7.03075 21.1863 6.7773 21.0001 6.58994L16.7101 2.28994Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="mt-3">This Month</div>
                    <div class="count-num mt-1 fs-18"> {{ $lost_commissions }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- column -->
        <div class="col-xl-12">
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header justify-content-between border-0">
                            <h2 class="heading mb-0">Latest Transaction</h2>
                        </div>
                        <div class="card-body pt-0 px-0">
                            <div class="table-responsive">
                                <table class="display table-responsive tb-transaction table shadow-hover mb-4 dataTable no-footer" id="example6" style="min-width: 845px">
                                    <tbody>
                                    @forelse($latest_transactions as $trx)
                                        <tr>
                                            <td class="font-w700 fs-16">{{ $trx->type }}</td>
                                            <td class="font-w700 fs-16">
                                                {{ $trx->package_info_json->name }}
                                                @if($trx->type === 'P2P')
                                                    <code class="badge badge-outline-info badge-xs rounded-0">TO: {{ strtoupper($trx->receiver->username) }}</code>
                                                @endif
                                            </td>
                                            <td class="font-w700 fs-16">
                                                <code class="badge badge-xs">{{ $trx->status }}</code></td>
                                            <td class="font-w700 fs-16">
                                                <span class="text-success">{{ $trx->package_info_json->currency }} {{ $trx->amount }}</span>
                                                <br>
                                                <small> TRX FEE: {{ $trx->transaction_fee }}</small>
                                            </td>
                                            <td class="fs-14 font-w400">{{ $trx->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
                                                        <div class="py-2">
                                                            <a class="dropdown-item" href="{{ URL::signedRoute('user.wallet.transfer.invoice', $trx) }}">Invoice</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-pagenation d-flex align-items-center justify-content-between">
                                <p>Showing your<span> {{ count($latest_transactions) }} latest transaction</span> data
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="col-xl-4">
                    <!-- row -->
                    <div class="row">
                        <!-- column-->
                        <div class="col-xl-12 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <h2 class="heading mb-0">Earning Categories</h2>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="icon-box bg-primary me-2 ">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.0038 25.4285C11.7434 25.4285 9.53382 24.7582 7.6544 23.5024C5.77498 22.2466 4.31015 20.4617 3.44515 18.3734C2.58015 16.2851 2.35382 13.9872 2.7948 11.7703C3.23577 9.55337 4.32424 7.51699 5.92255 5.91868C7.52087 4.32036 9.55724 3.2319 11.7742 2.79092C13.9911 2.34995 16.289 2.57627 18.3773 3.44127C20.4656 4.30627 22.2505 5.7711 23.5063 7.65052C24.7621 9.52994 25.4323 11.7395 25.4323 13.9999C25.429 17.0299 24.2239 19.9349 22.0813 22.0774C19.9388 24.22 17.0338 25.4251 14.0038 25.4285ZM14.0038 4.85704C12.1955 4.85704 10.4278 5.39326 8.92427 6.39789C7.42074 7.40252 6.24887 8.83044 5.55687 10.5011C4.86487 12.1717 4.68381 14.01 5.03659 15.7836C5.38937 17.5571 6.26014 19.1862 7.5388 20.4649C8.81745 21.7435 10.4465 22.6143 12.2201 22.9671C13.9936 23.3199 15.832 23.1388 17.5026 22.4468C19.1732 21.7548 20.6011 20.5829 21.6058 19.0794C22.6104 17.5759 23.1466 15.8082 23.1466 13.9999C23.1439 11.5759 22.1798 9.25196 20.4657 7.53793C18.7517 5.8239 16.4278 4.85976 14.0038 4.85704Z" fill="#FCFCFC"></path>
                                                <path d="M15.1466 18.5714H11.7181C11.4149 18.5714 11.1243 18.451 10.9099 18.2367C10.6956 18.0224 10.5752 17.7317 10.5752 17.4286C10.5752 17.1255 10.6956 16.8348 10.9099 16.6204C11.1243 16.4061 11.4149 16.2857 11.7181 16.2857H15.1466V15.1428H12.8609C12.2547 15.1428 11.6733 14.902 11.2447 14.4734C10.816 14.0447 10.5752 13.4633 10.5752 12.8571V11.7143C10.5752 11.1081 10.816 10.5267 11.2447 10.098C11.6733 9.66937 12.2547 9.42856 12.8609 9.42856H16.2895C16.5926 9.42856 16.8833 9.54897 17.0976 9.76329C17.3119 9.97762 17.4323 10.2683 17.4323 10.5714C17.4323 10.8745 17.3119 11.1652 17.0976 11.3795C16.8833 11.5939 16.5926 11.7143 16.2895 11.7143H12.8609V12.8571H15.1466C15.7528 12.8571 16.3342 13.0979 16.7629 13.5266C17.1915 13.9553 17.4323 14.5366 17.4323 15.1428V16.2857C17.4323 16.8919 17.1915 17.4733 16.7629 17.9019C16.3342 18.3306 15.7528 18.5714 15.1466 18.5714Z" fill="#FCFCFC"></path>
                                                <path d="M14.0032 11.7142C13.7001 11.7142 13.4094 11.5937 13.1951 11.3794C12.9808 11.1651 12.8604 10.8744 12.8604 10.5713V9.42844C12.8604 9.12534 12.9808 8.83465 13.1951 8.62032C13.4094 8.40599 13.7001 8.28558 14.0032 8.28558C14.3063 8.28558 14.597 8.40599 14.8113 8.62032C15.0257 8.83465 15.1461 9.12534 15.1461 9.42844V10.5713C15.1461 10.8744 15.0257 11.1651 14.8113 11.3794C14.597 11.5937 14.3063 11.7142 14.0032 11.7142ZM14.0032 19.7142C13.7001 19.7142 13.4094 19.5937 13.1951 19.3794C12.9808 19.1651 12.8604 18.8744 12.8604 18.5713V17.4284C12.8604 17.1253 12.9808 16.8346 13.1951 16.6203C13.4094 16.406 13.7001 16.2856 14.0032 16.2856C14.3063 16.2856 14.597 16.406 14.8113 16.6203C15.0257 16.8346 15.1461 17.1253 15.1461 17.4284V18.5713C15.1461 18.8744 15.0257 19.1651 14.8113 19.3794C14.597 19.5937 14.3063 19.7142 14.0032 19.7142Z" fill="#FCFCFC"></path>
                                            </svg>
                                        </div>
                                        <div class="ps-2 w-100 flex-1">
                                            <h6 class="">Working Hard</h6>
                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-primary" style="width:50%"></div>
                                            </div>
                                            <div class="mt-2">
                                                <span>$50</span><span class="text-primary"> / from $1000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="icon-box bg-secondary me-2">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.0038 25.4285C11.7434 25.4285 9.53382 24.7582 7.6544 23.5024C5.77498 22.2466 4.31015 20.4617 3.44515 18.3734C2.58015 16.2851 2.35382 13.9872 2.7948 11.7703C3.23577 9.55337 4.32424 7.51699 5.92255 5.91868C7.52087 4.32036 9.55724 3.2319 11.7742 2.79092C13.9911 2.34995 16.289 2.57627 18.3773 3.44127C20.4656 4.30627 22.2505 5.7711 23.5063 7.65052C24.7621 9.52994 25.4323 11.7395 25.4323 13.9999C25.429 17.0299 24.2239 19.9349 22.0813 22.0774C19.9388 24.22 17.0338 25.4251 14.0038 25.4285ZM14.0038 4.85704C12.1955 4.85704 10.4278 5.39326 8.92427 6.39789C7.42074 7.40252 6.24887 8.83044 5.55687 10.5011C4.86487 12.1717 4.68381 14.01 5.03659 15.7836C5.38937 17.5571 6.26014 19.1862 7.5388 20.4649C8.81745 21.7435 10.4465 22.6143 12.2201 22.9671C13.9936 23.3199 15.832 23.1388 17.5026 22.4468C19.1732 21.7548 20.6011 20.5829 21.6058 19.0794C22.6104 17.5759 23.1466 15.8082 23.1466 13.9999C23.1439 11.5759 22.1798 9.25196 20.4657 7.53793C18.7517 5.8239 16.4278 4.85976 14.0038 4.85704Z" fill="#FCFCFC"></path>
                                                <path d="M15.1466 18.5714H11.7181C11.4149 18.5714 11.1243 18.451 10.9099 18.2367C10.6956 18.0224 10.5752 17.7317 10.5752 17.4286C10.5752 17.1255 10.6956 16.8348 10.9099 16.6204C11.1243 16.4061 11.4149 16.2857 11.7181 16.2857H15.1466V15.1428H12.8609C12.2547 15.1428 11.6733 14.902 11.2447 14.4734C10.816 14.0447 10.5752 13.4633 10.5752 12.8571V11.7143C10.5752 11.1081 10.816 10.5267 11.2447 10.098C11.6733 9.66937 12.2547 9.42856 12.8609 9.42856H16.2895C16.5926 9.42856 16.8833 9.54897 17.0976 9.76329C17.3119 9.97762 17.4323 10.2683 17.4323 10.5714C17.4323 10.8745 17.3119 11.1652 17.0976 11.3795C16.8833 11.5939 16.5926 11.7143 16.2895 11.7143H12.8609V12.8571H15.1466C15.7528 12.8571 16.3342 13.0979 16.7629 13.5266C17.1915 13.9553 17.4323 14.5366 17.4323 15.1428V16.2857C17.4323 16.8919 17.1915 17.4733 16.7629 17.9019C16.3342 18.3306 15.7528 18.5714 15.1466 18.5714Z" fill="#FCFCFC"></path>
                                                <path d="M14.0032 11.7142C13.7001 11.7142 13.4094 11.5937 13.1951 11.3794C12.9808 11.1651 12.8604 10.8744 12.8604 10.5713V9.42844C12.8604 9.12534 12.9808 8.83465 13.1951 8.62032C13.4094 8.40599 13.7001 8.28558 14.0032 8.28558C14.3063 8.28558 14.597 8.40599 14.8113 8.62032C15.0257 8.83465 15.1461 9.12534 15.1461 9.42844V10.5713C15.1461 10.8744 15.0257 11.1651 14.8113 11.3794C14.597 11.5937 14.3063 11.7142 14.0032 11.7142ZM14.0032 19.7142C13.7001 19.7142 13.4094 19.5937 13.1951 19.3794C12.9808 19.1651 12.8604 18.8744 12.8604 18.5713V17.4284C12.8604 17.1253 12.9808 16.8346 13.1951 16.6203C13.4094 16.406 13.7001 16.2856 14.0032 16.2856C14.3063 16.2856 14.597 16.406 14.8113 16.6203C15.0257 16.8346 15.1461 17.1253 15.1461 17.4284V18.5713C15.1461 18.8744 15.0257 19.1651 14.8113 19.3794C14.597 19.5937 14.3063 19.7142 14.0032 19.7142Z" fill="#FCFCFC"></path>
                                            </svg>
                                        </div>
                                        <div class="ps-2 w-100 flex-1">
                                            <h6 class="">Side Project</h6>
                                            <div class="progress mt-2">
                                                <div class="progress-bar bg-secondary" style="width:40%"></div>
                                            </div>
                                            <div class="mt-2">
                                                <span>$50</span><span class="text-primary"> / from $1000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-6 col-md-12">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="text-white">Monthly Target</h3>
                                            <h6 class="text-white mt-4">Total Earning</h6>
                                            <div class="count-num text-white">$25,365.25</div>
                                            <p class="text-white mt-3">25% than last month</p>
                                        </div>
                                        <div class="d-inline-block position-relative donut-chart-sale">
                                            <span class="donut4" data-peity='{ "fill": ["var(--secondary)", "rgba(239, 239, 239, 1)"],   "innerRadius":60, "radius": 80}'>75/100</span>
                                            <small class="fs-28 font-w700 text-white">75%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    @push('scripts')
        {{--<script src="{{ asset('assets/backend/vendor/peity/jquery.peity.min.js') }}"></script>--}}
    @endpush
</x-backend.layouts.app>
