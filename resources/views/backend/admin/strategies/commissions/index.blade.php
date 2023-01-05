<x-backend.layouts.app>
    @section('title', 'Strategies | Commissions')
    @section('header-title', 'Strategies | Commissions' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Commissions</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Commissions Percentage
                    </h5>
                    <p>Mention the values in percentage of 100</p>
                    <hr>
                    <form class="theme-form" enctype="multipart/form-data" id="commissions-form">

                        @include('backend.admin.strategies.commissions.commission-payment-percentages')
                        <hr>
                        @include('backend.admin.strategies.commissions.rank-payment-percentages')

                        <hr>

                        <div class="mb-2">Total Percentage from single sale:
                            <code><span id="total-percentage"></span>%</code>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" id="save-commissions" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/strategies/commissions/script.js') }}"></script>
    @endpush
</x-backend.layouts.app>

