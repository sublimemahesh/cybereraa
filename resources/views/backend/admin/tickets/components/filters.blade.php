<div class="w-full my-3 dark:bg-gray-800">
    <div class="rounded-sm">
        <div class="px-4 py-3 cursor-pointer bg-gray-50 border border-gray-200 dark:border-gray-600 dark:bg-gray-500">
            <button class="appearance-none text-left text-base font-medium text-gray-500 focus:outline-none dark:text-gray-300" type="button">
                Filter
            </button>
        </div>
        <div class="border-l border-b border-r border-gray-200 dark:border-gray-600 px-2 py-4 dark:border-0 dark:bg-gray-700">
            <div>
                <div class="md:flex md:flex-wrap">
                    <div class="flex flex-col mb-2 md:w-1/2 lg:w-1/4">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="input_category" class="text-gray-700 dark:text-gray-300">CATEGORY</label>
                                <div class="relative">
                                    <select id="input_category"
                                            class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        @foreach ($filter_category as $status)
                                            <option value="{{ $status->id }}" {{ request()->status === $status->id ? 'selected' : '' }}>{{ Str::upper($status->name) }}</option>
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
                                <label for="input_priority" class="text-gray-700 dark:text-gray-300">PRIORITY</label>
                                <div class="relative">
                                    <select id="input_priority" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        @foreach ($filter_priority as $status)
                                            <option value="{{ $status->id }}" {{ request()->status === $status->id ? 'selected' : '' }}>{{ Str::upper($status->name) }}</option>
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
                                <label for="input_status" class="text-gray-700 dark:text-gray-300">STATUS</label>
                                <div class="relative">
                                    <select id="input_status" class="power_grid appearance-none block mt-1 mb-1 bg-gray-50 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full active dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                                        <option value="">ALL</option>
                                        @foreach ($filter_status as $status)
                                            <option value="{{ $status->id }}" {{ request()->status === $status->id ? 'selected' : '' }}>{{ Str::upper($status->name) }}</option>
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
                    <div class="flex flex-col mb-2">
                        <div>
                            <div class=" pt-2 p-2 ">
                                <label for="" class="dark:text-gray-300 opacity-0 text-gray-700">Search</label>
                                <div class="relative">
                                    <button id="search" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
