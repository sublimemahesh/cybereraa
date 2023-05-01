<x-backend.layouts.app>
    @section('title', 'Buy Staking Package')
    @section('header-title', 'Staking Packages' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Staking Packages</li>
    @endsection

    <div class="row">
        @foreach($packages as $package)
            {{--@php
                $gas_fee = $is_gas_fee_added ? $package->gas_fee : 0;
            @endphp--}}
            <div class="col-xl-3 col-md-6 col-sm-12 col-lg-3">
                <div class="card text-center">
                    <div class="card-header">
                        <h5 class="card-title">{{ $package->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <ul class="list-group">
                                <li class="list-group-item active">
                                    {{ $package->currency }}
                                    <b> {{ $package->total_amount }} </b>
                                </li>
                                <li class="list-group-item"><b>Price </b>USDT {{ $package->amount }}</li>
                                <li class="list-group-item"><b>Gas Fee </b>USDT {{ $package->gas_fee }}</li>
                                <li class="list-group-item"><b>Package </b>{{ $package->name }}</li>
                                <li class="list-group-item">
                                    <b> {{ $package->plans_count }} </b> Plans Available
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a type="button" class="btn btn-primary mb-2" href="{{ route('user.staking-packages.purchase',$package) }}">View Plans</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-backend.layouts.app>
