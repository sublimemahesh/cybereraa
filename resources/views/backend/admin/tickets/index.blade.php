<x-backend.layouts.app>
    @section('title', 'Support Tickets')
    @section('header-title', 'Support Tickets' )
    @section('plugin-styles')
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Support Tickets</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.tickets.components.filters', compact('filter_category', 'filter_priority', 'filter_status'))
                    <table id="tickets" class="display table-responsive-my">
                        <thead>
                        <tr>
                            <th>ACTIONS</th>
                            <th>USER</th>
                            <th>TICKET ID</th>
                            <th>SUBJECT</th>
                            <th>CATEGORY</th>
                            <th>PRIORITY</th>
                            <th>STATUS</th>
                            <th>CREATED AT</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/tickets/index.js') }}"></script>
    @endpush
</x-backend.layouts.app>
