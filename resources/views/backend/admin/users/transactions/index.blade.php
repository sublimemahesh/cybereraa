<x-backend.layouts.app>
    @section('title', 'Transaction | Reports')
    @section('header-title', 'Payments | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/datatables/css/datatable-extension.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
        <style>
            .swal2-select {
                border-width: 1px;
                border-style: solid;
            }
        </style>
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Payments </li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="alert alert-warning">
                Free Pending Packages do not show here. Please visit
                <a href="https://www.cybereraa.com/admin/reports/users/transactions?status=pending" target="_blank">Cybereraa.com</a>
                for Free Package Approval. <br>
                Please Note:
                <b>
                    Make sure you do not approve any misleading packages requested by users, that look like a FREE package.
                    This page does not allow any FREE Packages to be approved or rejected.
                </b>
            </div>
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.users.transactions.components.report-table')
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Approve/Reject Transaction</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0" id="modalContent">
                        <!-- Content loaded dynamically here -->
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        <!-- Datatable -->
        <script !src="">
            const TRANSACTION_URL = location.href;
            const HISTORY_STATE = true;

            const REJECT_REASONS = {!! json_encode(App\Enums\TransactionRejectReasonsEnum::reasons(),JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT) !!};
        </script>
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/extensions/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/clipboard/clipboard.min.js') }}"></script>

        <script src="{{ asset('assets/backend/js/admin/transactions/main.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/transactions/manual-trx.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/transactions/reject-manual-trx.js') }}"></script>

        <script !src="">
            // document.getElementById('approveModal').addEventListener('shown.bs.modal', event => {
            let clipboard = new ClipboardJS('#copy-to-clipboard');
            // Handle copy success
            clipboard.on('success', function (e) {
                console.log(e)
                Toast.fire({
                    icon: 'success', title: 'Transaction ID copied to clipboard!',
                })
                e.clearSelection();

                let textarea = document.createElement('textarea');
                textarea.value = e.text;
                document.body.appendChild(textarea);
                textarea.select();
                textarea.focus()
                document.execCommand('copy');
                document.body.removeChild(textarea);
            });
            // })
        </script>

    @endpush
</x-backend.layouts.app>
