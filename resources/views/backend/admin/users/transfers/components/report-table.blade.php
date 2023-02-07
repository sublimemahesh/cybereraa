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
                    @if(request()->routeIs('admin.transfers.p2p'))
                        <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                            <div>
                                <div class=" pt-2 p-2 ">
                                    <label for="user_id" class="text-gray-700 dark:text-gray-300">SENDER ID</label>
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
                                <label for="p2p-trx-receiver_id" class="text-gray-700 dark:text-gray-300">RECEIVER ID</label>
                                <div class="relative">
                                    <input id="p2p-trx-receiver_id" value="{{ request()->input('receiver_id') }}" placeholder="Enter User ID" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="p2p-trx-date-range" class="text-gray-700 dark:text-gray-300">PERIOD</label>
                                <div class="relative">
                                    <form autocomplete="off">
                                        <input id="p2p-trx-date-range" class="flatpickr block my-1 bg-gray-50 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500 flatpickr-input" type="text" placeholder="Select a period" readonly="readonly">
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
                                <label for="p2p-trx-status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                <div class="relative">
                                    <select id="p2p-trx-status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        <option value="processing" {{ request()->input('status') === 'processing' ? 'selected' : '' }}>PROCESSING</option>
                                        <option value="success" {{ request()->input('status') === 'success' ? 'selected' : '' }}>SUCCESS</option>
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
                    <div class="flex flex-col mb-2">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <div class="relative">
                                    <button id="p2p-trx-search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
    <table id="p2p-trx" class="display mb-1 nowrap table-responsive-my">
        <thead>
        <tr>
            <th>SENDER</th>
            <th>RECEIVER</th>
            <th>TYPE</th>
            <th>STATUS</th>
            <th>CREATED AT</th>
            <th>REMARK</th>
            <th class="text-right">AMOUNT</th>
            <th class="text-right">FEE</th>
            <th class="text-right">TOTAL</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th colspan="9" style="text-align:right"></th>
        </tr>
        </tfoot>
    </table>
</div>
