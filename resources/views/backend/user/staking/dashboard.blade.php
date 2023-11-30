<x-backend.layouts.app>
    @section('title', 'Staking Dashboard ')
    @section('header-title', 'Staking Dashboard' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Staking Dashboard</li>
    @endsection

    <div class="row">
        <div class="col-xl-4 col-lg-4">
            <div class="card prim-card">
                <div class="card-body py-3">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M45.333 9.3335H18.6663C16.191 9.3335 13.817 10.3168 12.0667 12.0672C10.3163 13.8175 9.33301 16.1915 9.33301 18.6668V45.3335C9.33301 47.8088 10.3163 50.1828 12.0667 51.9332C13.817 53.6835 16.191 54.6668 18.6663 54.6668H45.333C47.8084 54.6668 50.1823 53.6835 51.9327 51.9332C53.683 50.1828 54.6663 47.8088 54.6663 45.3335V18.6668C54.6663 16.1915 53.683 13.8175 51.9327 12.0672C50.1823 10.3168 47.8084 9.3335 45.333 9.3335ZM27.9997 14.6668H35.9997V22.6668H27.9997V14.6668ZM22.6663 49.3335H18.6663C17.6055 49.3335 16.5881 48.9121 15.8379 48.1619C15.0878 47.4118 14.6663 46.3944 14.6663 45.3335V41.3335H22.6663V49.3335ZM35.9997 49.3335H27.9997V41.3335H35.9997V49.3335ZM49.333 45.3335C49.333 46.3944 48.9116 47.4118 48.1614 48.1619C47.4113 48.9121 46.3939 49.3335 45.333 49.3335H41.333V41.3335H49.333V45.3335ZM49.333 36.0002H14.6663V18.6668C14.6663 17.606 15.0878 16.5885 15.8379 15.8384C16.5881 15.0883 17.6055 14.6668 18.6663 14.6668H22.6663V25.3335C22.6663 26.0407 22.9473 26.719 23.4474 27.2191C23.9475 27.7192 24.6258 28.0002 25.333 28.0002H49.333V36.0002ZM49.333 22.6668H41.333V14.6668H45.333C46.3939 14.6668 47.4113 15.0883 48.1614 15.8384C48.9116 16.5885 49.333 17.606 49.333 18.6668V22.6668Z" fill="white"/>
                    </svg>
                    <div class="d-flex">
                        <h4 class="number mt-2">USDT {{ $wallet->staking_balance }} </h4>
                        <div class="rec-design">
                            <div class="rec-design1">
                            </div>
                            <div class="rec-design2">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="prim-info">
                            <span>STAKING WALLET</span>
                            <h4>AVAILABLE BALANCE</h4>
                        </div>
                        <div class="master-card">
                            <img src="{{ asset('assets/backend/images/logo/logo.png') }}" alt="logo" width="50"/>
                            {{--<svg width="88" height="56" viewBox="0 0 88 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="28" cy="28" r="28" fill="#FF5B5B"/>
                                <circle cx="60" cy="28" r="28" fill="#F79F19"/>
                            </svg>--}}
                            <span class="text-white d-block mt-1">coin1m</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4">
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
                    <div class="count-num mt-1 fs-18"> $ {{ $income }}</div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4">
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
                    <div class="count-num mt-1 fs-18"> $ {{ $withdraw }}</div>
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

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Purchased Staking</h4>
                            </div>
                            <div class="card-body">
                                <div class="w-full my-3 dark:bg-gray-800">
                                    <div class="rounded-sm">
                                        <div class="px-4 py-3 cursor-pointer dark:bg-secondary-dark border border-gray-200 dark:border-gray-600">
                                            <button class="appearance-none text-left text-base font-medium text-gray-500 focus:outline-none dark:text-gray-300" type="button">
                                                Filter
                                            </button>
                                        </div>
                                        <div class="border-l border-b border-r border-gray-200 dark:border-gray-600 px-2 py-4 dark:border-0  dark:bg-secondary-dark">
                                            <div>
                                                <div class="md:flex md:flex-wrap">
                                                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="purchaser_id" class="text-gray-700 dark:text-gray-300">PURCHASED BY</label>
                                                                <div class="relative">
                                                                    <input id="purchaser_id" value="{{ request()->input('purchaser_id') }}" placeholder="Enter User ID" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="transaction-date-range" class="text-gray-700 dark:text-gray-300">PERIOD</label>
                                                                <div class="relative">
                                                                    <form autocomplete="off">
                                                                        <input id="transaction-date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
                                                                    </form>
                                                                    <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="transaction-status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                                                <div class="relative">
                                                                    <select id="transaction-status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <option value="">ALL</option>
                                                                        <option value="active" {{ request()->input('status') === 'active' ? 'selected' : '' }}>ACTIVE</option>
                                                                        <option value="expired" {{ request()->input('status') === 'expired' ? 'selected' : '' }}>EXPIRED</option>
                                                                        <option value="cancelled" {{ request()->input('status') === 'cancelled' ? 'selected' : '' }}>CANCELED</option>
                                                                        <option value="hold" {{ request()->input('status') === 'hold' ? 'selected' : '' }}>HOLD</option>
                                                                    </select>
                                                                    <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="package_id" class="text-gray-700 dark:text-gray-300">STAKING PACKAGE</label>
                                                                <div class="relative">
                                                                    <select id="package_id" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <option value="">ALL</option>
                                                                        @foreach($packages as $package)
                                                                            <option value="{{ $package->id }}" {{ (int)request()->input('package_id') === $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="plan_id" class="text-gray-700 dark:text-gray-300">STAKING PLANS</label>
                                                                <div class="relative">
                                                                    <select id="plan_id" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <option value="">ALL</option>
                                                                    </select>
                                                                    <div class="pointer-events-none rounded absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                                                        <svg class="pointer-events-none w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col mb-2">
                                                        <div>
                                                            <div class=" pt-2 p-2 ">
                                                                <label for="transaction-search" class="text-gray-700 dark:text-gray-300">&nbsp;</label>
                                                                <div class="relative">
                                                                    <button id="transaction-search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                                        Search
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="transactions" class="display mb-1 nowrap table-responsive" style="table-layout: fixed ">
                                        <thead>
                                        <tr>
                                            <th>ACTIONS</th>
                                            <th>TRX ID</th>
                                            <th>USER / PACKAGE</th>
                                            <th class="text-center">STATUS</th>
                                            <th>MATURITY DATE</th>
                                            <th>INTEREST RATE</th>
                                            <th>CREATED</th>
                                            <th>INVESTED</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th colspan="8" style="text-align:right"></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')

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
        <script src="{{ asset('assets/backend/js/staking/dashboard.js') }}"></script>
    @endpush
</x-backend.layouts.app>
