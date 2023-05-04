<x-backend.layouts.app>
    @section('title', 'My Staking')
    @section('header-title', 'My Staking | Cancel' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.staking-packages.dashboard') }}">Staking</a>
        </li>
        <li class="breadcrumb-item active">Cancel Staking request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Cancel Staking</h4>
                        <p>
                            If you cancel the staking, you may not receive any interest for the staking.
                        </p>
                        <p>
                            <b>Package: </b> {{ $plan->name }} <br>
                            <b>Price: </b>USDT {{ $package->amount }} <br>
                            <b>Duration: </b>{{ $plan->duration }} Days <br>
                            <b>Interest: </b>{{ $plan->interest_rate }}%
                        </p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="cancel-form">
                                <div class="mb-3 mt-2">
                                    <label for="withdraw-amount">
                                        Staking Plan Amount
                                    </label>
                                    <div class="form-control">USDT {{ $purchase->invested_amount }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Cancel Letter</label>
                                    <textarea id="remark" name="remark" rows="3" placeholder="Cancel Note" class="form-control h-auto"></textarea>
                                </div>
                                <hr>
                                <button type="submit" id="cancel-request" class="btn btn-sm btn-success mb-2">Confirm & Cancel</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/staking/cancel.js') }}"></script>
    @endpush
</x-backend.layouts.app>
