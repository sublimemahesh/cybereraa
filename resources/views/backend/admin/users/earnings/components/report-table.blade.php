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
                    @if(!request()->routeIs('admin.staking.earnings.index'))
                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                            <div>
                                <div class=" pt-2 p-2 ">
                                    <label for="earning-type" class="text-gray-700 dark:text-gray-300">EARNING TYPE</label>
                                    <div class="relative">
                                        <select id="earning-type" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                            <option value="">ALL</option>
                                            <option value="package" {{ request()->input('earning-type') === 'package' ? 'selected' : '' }}>PACKAGE</option>
                                            <option value="trade_direct" {{ request()->input('earning-type') === 'trade_direct' ? 'selected' : '' }}>TRADE DIRECT</option>
                                            <option value="trade_indirect" {{ request()->input('earning-type') === 'trade_indirect' ? 'selected' : '' }}>TRADE INDIRECT</option>
                                            <option value="direct" {{ request()->input('earning-type') === 'direct' ? 'selected' : '' }}>DIRECT SALE</option>
                                            <option value="indirect" {{ request()->input('earning-type') === 'indirect' ? 'selected' : '' }}>INDIRECT SALE</option>
                                            <option value="special_bonus" {{ request()->input('earning-type') === 'special_bonus' ? 'selected' : '' }}>SPECIAL BONUS</option>
                                            {{-- <option value="p2p" {{ request()->input('earning-type') === 'p2p' ? 'selected' : '' }}>P2P TRANSFER</option> --}}
                                            {{-- <option value="rank_bonus" {{ request()->input('earning-type') === 'rank_bonus' ? 'selected' : '' }}>RANK BONUS</option> --}}
                                            {{--<option value="rank_gift" {{ request()->input('earning-type') === 'rank_gift' ? 'selected' : '' }}>RANK GIFT</option>--}}
                                            {{--<option value="staking" {{ request()->input('earning-type') === 'staking' ? 'selected' : '' }}>STAKING</option>--}}
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
                        <input type="hidden" name="earning-type" id="earning-type" value="staking">
                    @endif
                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="earnings-date-range" class="text-gray-700 dark:text-gray-300">PERIOD</label>
                                <div class="relative">
                                    <form autocomplete="off">
                                        <input id="earnings-date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
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
                                <label for="earnings-status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                <div class="relative">
                                    <select id="earnings-status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        <option value="received" {{ request()->input('status') === 'received' ? 'selected' : '' }}>RECEIVED</option>
                                        <option value="hold" {{ request()->input('status') === 'hold' ? 'selected' : '' }}>HOLD</option>
                                        <option value="canceled" {{ request()->input('status') === 'canceled' ? 'selected' : '' }}>CANCELED</option>
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
                            <div class=" p-2 ">
                                <label class="text-gray-700 dark:text-gray-300">AMOUNT</label>
                                <div class="sm:flex w-full">
                                    <div class="pl-0 pt-1 w-full sm:pr-3 sm:w-1/2">
                                        <input id="amount-start" value="{{ request()->input('amount-start') }}" type="number" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500" placeholder="Min">
                                    </div>
                                    <div class="pl-0 pt-1 w-full sm:w-1/2">
                                        <input id="amount-end" value="{{ request()->input('amount-end') }}" type="number" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-2">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="" class="dark:text-gray-300 opacity-0 text-gray-700">search</label>
                                <div class="relative">
                                    <button id="earnings-search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
    <table id="earnings" class="display mb-1 table-responsive-my" style="table-layout: fixed">
        <thead>
            <tr>
                <th>EARNING TYPE</th>
                <th>USER ID</th>
                <th>USERNAME</th>
                <th>PACKAGE</th>
                <th>STATUS</th>
                <th>PAYMENT DATE</th>
                <th class="text-right">(USDT) AMOUNT</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align:right"></th>
            </tr>
        </tfoot>
    </table>
</div>
