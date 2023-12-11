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

    <div class="alert alert-info">
        All package earnings will be generated after 3 working days from the date of purchase.
    </div>

    <div class="row">
        @include('backend.user.transactions.top-nav')
        @foreach ($activePackages as $subscription)
            <div class="col-xl-6 ">
                <div class="card1">
                    <div class="card text-white  card2 active-card-bp">
                        <div class="card-header">


                            <h5 class="card-title text-white">
                                {{ $subscription->transaction->create_order_request_info->goods->goodsName }} |
                                <span class='card-currency'>
                                    {{ $subscription->transaction->currency }} {{ $subscription->transaction->amount}}
                                </span>
                            </h5>
                        </div>

                        <div class="card-body mb-0 package-body">
                            <p class="card-text">Buy Date : <b> {{ $subscription->created_at->format('Y-m-d h:i A') }}</b></p>
                            <p class="card-text">Active Date : <b> {{ $subscription->package_activate_date }}</b></p>
                            <p class="card-text">Next Payment Date :<b> {{ $subscription->next_payment_date }} </b></p>
                            <p class="card-text">Plan Expire Return ({{ $subscription->investment_profit }}%) :<b> {{ $subscription->transaction->currency }}  {{ $subscription->invested_amount * ($subscription->investment_profit) /100 }} </b></p>
                            <p class="card-text">Completed Return :<b> {{ $subscription->transaction->currency }}  {{ $subscription->earnings_sum_amount ?? 0 }} </b></p>
                            <p class="card-text">Pending Return : <b> {{ $subscription->transaction->currency }}  {{ ($subscription->invested_amount * ($subscription->investment_profit) /100) - $subscription->earnings_sum_amount }} </b></p>
                            <p class="card-text">Purchased by : <b> #{{ str_pad($subscription->purchaser_id, 4, '0', STR_PAD_LEFT)}}</b></p>
                        </div>
                        <div class="card-footer">
                            <div class="card-footer-link">
                                <a href="{{ URL::signedRoute('user.transactions.invoice', $subscription->transaction_id) }}"
                                   class="btn bg-white text-primary btn-card">Invoice
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
