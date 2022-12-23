<x-backend.layouts.app>
    @section('title', 'My Packages')
    @section('header-title', 'Active Packages' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">My Packages</li>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display mb-1 table header-border table-responsive-sm" id="active-packages" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>START DATE</th>
                                <th>END DATE</th>
                                <th>NEXT PAYMENT DATE</th>
                                <th>PAYABLE PERCENTAGE</th>
                                <th>ON HOLD STATUS</th>
                                <th>TRX NO</th>
                                <th>PACKAGE NAME</th>
                                <th>PACKAGE VALUE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activePackages as $subscription)
                                <tr>
                                    <td class="py-2">{{ $subscription->created_at }}</td>
                                    <td>{{ $subscription->expired_at }}</td>
                                    <td>{{ $subscription->next_payment_date }}</td>
                                    <td>Up to {{ $subscription->payable_percentage }}%</td>
                                    <td>{{ $subscription->status }}</td>
                                    <td>#{{ str_pad($subscription->transaction->id, 4, 0, STR_PAD_LEFT) }}</td>
                                    <td>{{ $subscription->transaction->create_order_request_info->goods->goodsName }}</td>
                                    <td>{{ $subscription->transaction->currency }} {{ $subscription->transaction->amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script>
            // dataTable3
            let table = $('#active-packages').DataTable({
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        </script>
    @endpush
</x-backend.layouts.app>