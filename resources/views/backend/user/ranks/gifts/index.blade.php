<x-backend.layouts.app>
    @section('title', 'Rank Gifts | Benefit')
    @section('header-title', 'Rank Gifts | Benefit' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Rank Gifts</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rewards" class="display mb-1 nowrap table-responsive-my" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th class="text-left">RANK</th>
                                <th>STATUS</th>
                                <th>CREATED AT</th>
                                <th>GIFT REQUIREMENT</th>
                                <th class="text-right">TOTAL INVESTMENT</th>
                                <th class="text-right">TOTAL TEAM INVESTMENT</th>
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
        <script src="{{ asset('assets/backend/js/user/ranks/gift.js') }}"></script>
    @endpush
</x-backend.layouts.app>
