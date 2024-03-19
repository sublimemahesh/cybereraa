<x-backend.layouts.app>
    @section('title', 'Withdrawals Transactions | Reports')
    @section('header-title', 'Withdrawals | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        {{--        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">--}}
        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.bootstrap5.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/select/2.0.0/css/select.bootstrap5.css" rel="stylesheet">
        {{--        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">--}}
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Withdrawals</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.users.transfers.components.withdraw-report-table')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script !src="">
            const WITHDRAW_REPORT_URL = location.href;
            const HISTORY_STATE = true;
            const REJECT_REASONS = {!! json_encode(App\Enums\WithdrawalRejectReasonsEnum::reasons(),JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT) !!};
        </script>
        <!-- Datatable -->
        {{--        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>--}}
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/dataTables.select.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/select.dataTables.js') }}"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
        {{--        <script src="{{ asset('assets/backend/vendor/datatables/extensions/dataTables.buttons.min.js') }}"></script>--}}
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/transfers/withdraws.js') }}"></script>
    @endpush
</x-backend.layouts.app>
