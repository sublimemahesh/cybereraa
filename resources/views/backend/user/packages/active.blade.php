<x-backend.layouts.app>
    @section('title', 'My Packages')
    @section('header-title', 'Active Packages')
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/css/user/main.css') }}" rel="stylesheet">

    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">My Packages</li>
    @endsection

    {{-- <div class="row">
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
                            @foreach ($activePackages as $subscription)
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



    </div> --}}

    <div class="alert alert-info">
        Effective from 02-02-2023 all package earnings will be generated after 5 days from the date of purchase. This will affect all packages purchased from 02-02-2023 onwards.
    </div>

    <div class="row">
        @foreach ($activePackages as $subscription)
            <div class="col-xl-6 ">
                <div class="card1">
                    <div class="card text-white bg-primary  card2">
                        <div class="card-header">
                            <h5 class="card-title text-white">
                                {{ $subscription->transaction->create_order_request_info->goods->goodsName }} | <span
                                        class='card-currency'>
                                    {{ $subscription->transaction->currency }}{{ $subscription->transaction->amount }}</span>
                            </h5>
                            <p class="card-text text-wite d-inline"><i class="fa fa-check-circle icon-green"
                                        aria-hidden="true"></i> {{ $subscription->status }}</p>
                        </div>
                        <div class="card-body mb-0 package-body">
                            <p class="card-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i> . START
                                DATE : <b> {{ $subscription->created_at }}</b></p>
                            <p class="card-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i> . END DATE
                                : <b> {{ $subscription->expired_at }}</b></p>
                            <p class="card-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i> . NEXT
                                PAYMENT DATE :<b> {{ $subscription->next_payment_date }} </b></p>
                            <p class="card-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i> . PAYABLE
                                PERCENTAGE :<b> Up to {{ $subscription->payable_percentage }}%</b></p>
                        </div>
                        <div class="card-footer d-sm-flex justify-content-between align-items-center">
                            <div class="card-footer-link mb-4 mb-sm-0">
                                <a href="{{ route('user.packages.index') }}"
                                        class="btn bg-white text-primary btn-card">More Packages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
