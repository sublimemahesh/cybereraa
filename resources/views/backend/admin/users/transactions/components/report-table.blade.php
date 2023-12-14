<div class="w-full my-3 dark:bg-gray-800">
    <div class="rounded-sm">

        <div class="border-l border-b border-r border-gray-200 dark:border-gray-600 px-2 py-4 dark:border-0  dark:bg-secondary-dark">
            <div>
                <div class="md:flex md:flex-wrap">
                    @if(!request()->routeIs('admin.users.profile.show'))
                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                            <div>
                                <div class=" pt-2 p-2 ">
                                    <label for="user_id" class="text-gray-700 dark:text-gray-300">USER ID</label>
                                    <div class="relative">
                                        <input id="user_id" value="{{ request()->input('user_id') }}" placeholder="Enter User ID" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                                <label for="currency-type" class="text-gray-700 dark:text-gray-300">CURRENCY</label>
                                <div class="relative">
                                    <select id="currency-type" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        <option value="crypto" {{ request()->input('currency-type') === 'crypto' ? 'selected' : '' }}>Crypto</option>
                                        <option value="wallet" {{ request()->input('currency-type') === 'wallet' ? 'selected' : '' }}>Wallet</option>
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
                                <label for="pay-method" class="text-gray-700 dark:text-gray-300">PAY METHOD</label>
                                <div class="relative">
                                    <select id="pay-method" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        <option value="main" {{ request()->input('pay-method') === 'main' ? 'selected' : '' }}>MAIN WALLET</option>
                                        <option value="topup" {{ request()->input('pay-method') === 'topup' ? 'selected' : '' }}>TOPUP WALLET</option>
                                        <option value="binance" {{ request()->input('pay-method') === 'binance' ? 'selected' : '' }}>BINANCE</option>
                                        <option value="manual" {{ request()->input('pay-method') === 'manual' ? 'selected' : '' }}>MANUAL APPROVE</option>
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
                                        <option value="initial" {{ request()->input('status') === 'initial' ? 'selected' : '' }}>INITIAL</option>
                                        <option value="pending" {{ request()->input('status') === 'pending' ? 'selected' : '' }}>PENDING</option>
                                        <option value="paid" {{ request()->input('status') === 'paid' ? 'selected' : '' }}>PAID</option>
                                        <option value="canceled" {{ request()->input('status') === 'canceled' ? 'selected' : '' }}>CANCELED</option>
                                        <option value="rejected" {{ request()->input('status') === 'rejected' ? 'selected' : '' }}>REJECTED</option>
                                        <option value="expired" {{ request()->input('status') === 'expired' ? 'selected' : '' }}>EXPIRED</option>
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
                    @if(!request()->routeIs('admin.staking.transactions.index'))
                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                            <div>
                                <div class=" pt-2 p-2 ">
                                    <label for="product-type" class="text-gray-700 dark:text-gray-300">PRODUCT TYPE</label>
                                    <div class="relative">
                                        <select id="product-type" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                            <option value="">ALL</option>
                                            <option value="package" {{ request()->input('product-type') === 'package' ? 'selected' : '' }}>PACKAGE</option>
                                            <option value="staking" {{ request()->input('product-type') === 'staking' ? 'selected' : '' }}>STAKING</option>
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
                    @else
                        <input type="hidden" name="product-type" id="product-type" value="staking">
                    @endif
                    <div class="flex flex-col mb-2">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="transaction-search" class="text-gray-700 dark:text-gray-300"></label>
                                <div class="relative">
                                    <button id="transaction-search" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
    <table id="transactions" class="display mb-1 table-responsive-my" style="table-layout: fixed">
        <thead>
        <tr>
            <th>ACTIONS</th>
            <th>TRX ID</th>
            <th>USER</th>
            <th>PURCHASE</th>
            <th>PACKAGE</th>
            <th class="text-center">TYPE</th>
            <th>STATUS</th>
            <th class="text-center">CREATED</th>
            <th class="text-right">GAS FEE</th>
            <th class="text-right">AMOUNT</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th colspan="10" style="text-align:right"></th>
        </tr>
        </tfoot>
    </table>
</div>
