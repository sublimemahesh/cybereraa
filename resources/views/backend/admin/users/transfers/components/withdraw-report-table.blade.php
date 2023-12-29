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
                                <label for="binance-trx-date-range" class="text-gray-700 dark:text-gray-300">REQUEST DATE</label>
                                <div class="relative">
                                    <form autocomplete="off">
                                        <input id="binance-trx-date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
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
                                <label for="binance-trx-date-approve" class="text-gray-700 dark:text-gray-300">APPROVE DATE</label>
                                <div class="relative">
                                    <form autocomplete="off">
                                        <input id="binance-trx-date-approve" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
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
                                <label for="binance-trx-status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                <div class="relative">
                                    <select id="binance-trx-status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        <option value="pending" {{ request()->input('status') === 'pending' ? 'selected' : '' }}>PENDING</option>
                                        <option value="processing" {{ request()->input('status') === 'processing' ? 'selected' : '' }}>PROCESSING</option>
                                        <option value="success" {{ request()->input('status') === 'success' ? 'selected' : '' }}>SUCCESS</option>
                                        <option value="cancelled" {{ request()->input('status') === 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                                        <option value="fail" {{ request()->input('status') === 'fail' ? 'selected' : '' }}>FAIL</option>
                                        <option value="reject" {{ request()->input('status') === 'reject' ? 'selected' : '' }}>REJECT</option>
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
                                    <button id="binance-trx-search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
    <table data-order="[[ 5, &quot;{{ in_array(request()->input('status'), ['pending', 'processing'])? 'asc' : 'desc' }}&quot; ]]" id="binance-trx" class="mb-1 nowrap table-responsive-my display" style="table-layout: fixed">
        <thead>
            <tr>
                <th>ACTIONS</th>
                <th>USER</th>
                <th>TYPE</th>
                <th>STATUS</th>
                <th>WALLET ADDRESS</th>
                <th class="text-center">CREATED</th>
                <th class="text-center">PROCESSED</th>
                <th class="text-center">APPROVED</th>
                <th class="text-center">REJECTED</th>
                <th class="text-right">AMOUNT</th>
                <th class="text-right">FEE</th>
                <th class="text-right">TOTAL</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align:right" >Total: $</th>
                <th style="text-align:right" class="text-wrap pe-1"></th>
                <th style="text-align:right" class="text-wrap pe-1"></th>
                <th style="text-align:right" class="text-wrap pe-1"></th>
            </tr>
        </tfoot>
    </table>
</div>
