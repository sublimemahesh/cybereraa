<x-backend.layouts.app>
    @section('title', 'Rank Bonus Summery | Reports')
    @section('header-title', 'Rank Bonus Summery | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Monthly Bonus Rewards</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        {{--<div class="col-sm-12">
            @can('generate_monthly_rank_bonus')
                <button id="calculate-bonus" class="mb-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Calculate Bonus ({{ Carbon\Carbon::now()->subMonth()->firstOfMonth()->format('Y-m-d') }} - {{ Carbon\Carbon::now()->subMonth()->lastOfMonth()->format('Y-m-d') }})
                </button>
            @endcan
        </div>--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rewards-summery" class="display mb-1 table-responsive-my" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th>PERIOD</th>
                                <th>RANKERS</th>
                                <th>ALLOCATED (%)</th>
                                <th>CREATED AT</th>
                                <th class="text-right">SALE</th>
                                <th class="text-right">ALLOCATED</th>
                                <th class="text-right">ALLOCATED FOR ONE</th>
                                <th class="text-right">REMAINING</th>
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
        <script src="{{ asset('assets/backend/js/admin/ranks/bonus-summery.js') }}"></script>
    @endpush
</x-backend.layouts.app>
