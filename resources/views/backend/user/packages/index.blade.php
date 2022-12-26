<x-backend.layouts.app>
    @section('title', 'Buy Package')
    @section('header-title', 'Packages' )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Buy Package</li>
    @endsection
 
    <div class="row">
        @foreach($packages as $package)
            <div class="col-xl-3 col-md-6 col-sm-12 col-lg-3">
                <div class="card text-center">
                    <div class="card-header">
                        <h5 class="card-title">{{ $package->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <ul class="list-group">
                                <li class="list-group-item active">
                                    {{ $package->currency }} <b> {{ $package->amount }} </b>
                                </li>
                                <li class="list-group-item"><b>Package </b>{{ $package->name }}</li>
                                <li class="list-group-item">
                                    <b>During {{ $package->month_of_period }} </b> Month Of Period
                                </li>
                                <li class="list-group-item">
                                    <b> Up to {{ $package->daily_leverage }}% </b>Daily Leverage
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary mb-2" id="{{ $package->slug }}-choose">Choose</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="pay-method-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Payment method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="card bg-secondary pay-method-wallet cursor-pointer" id="wallet">
                                    <a class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-wallet fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h4>VIA WALLET</h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-secondary pay-method-binance-pay cursor-pointer" id="binance-pay">
                                    <div class="card-body card-link">
                                        <div class="text-center"><span><i class="fa fa-qrcode fa-4x"></i></span>
                                            <div class="mb-3"></div>
                                            <h4>BINANCE PAY</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        <script>
            const ALLOWED_PACKAGES = {!! json_encode($packages->pluck('slug'),JSON_THROW_ON_ERROR) !!};
        </script>
        <script src="{{ asset('assets/backend/js/packages/choose.js') }}"></script>
    @endpush
</x-backend.layouts.app>
