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
        @include('backend.user.ranks.top-nav')
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="rewards-summery" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                        <thead>
                        <tr>
                            <th>PERIOD</th>
                            <th>RANKERS</th>
                            <th>ALLOCATED (%)</th>
                            <th>CREATED AT</th>
                            <th class="text-right">SALE</th>
                            <th class="text-right">ALLOCATED</th>
                            <th class="text-right">ALLOCATED FOR ONE</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="7" style="text-align:right"></th>
                        </tr>
                        </tfoot>
                    </table>
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
        <script src="{{ asset('assets/backend/js/user/ranks/bonus-summery.js') }}"></script>
    @endpush
</x-backend.layouts.app>
