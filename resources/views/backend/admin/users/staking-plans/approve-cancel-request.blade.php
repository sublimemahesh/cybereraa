<x-backend.layouts.app>
    @section('title', 'Staking Cancellation')
    @section('header-title', 'Staking Cancel Approve' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-purchased-packages') }}">Staking Report</a>
        </li>
        <li class="breadcrumb-item active">Approve Cancel Staking request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Approve the Cancel Staking (#{{ $cancelRequest->id }})</h4>
                        <p>
                            <b>STATUS:</b> {{ $cancelRequest->status }}
                        </p>
                        <p>
                            <b>Package: </b> {{ $plan->name }} <br>
                            <b>Price: </b>USDT {{ $package->amount }} <br>
                            <b>Duration: </b>{{ $plan->duration }} Days <br>
                            <b>Interest: </b>{{ $plan->interest_rate }}% <br>
                            <b>Maturity Date: </b>{{ $purchase->maturity_date }}
                        </p>
                        <p>
                            <b>Username:</b> <code>{{ $purchase->user->username }}</code> <br>
                            <b>Email:</b> {{ $purchase->user->email }} <br>
                            <b>Phone:</b> {{ $purchase->user->phone }} <br>
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
                                    <div class="form-control h-auto">
                                        {{ $cancelRequest->remark }}
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="interest_rate">Interest Rate</label>
                                    <input id="interest_rate" type="text" name="interest_rate" class="form-control h-auto" placeholder="Enter Interest"/>
                                </div>
                                <hr>
                                <button type="submit" id="approve-request" class="btn btn-sm btn-success mb-2">Confirm & Approve</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/staking-plans/approve-cancel.js') }}"></script>
    @endpush
</x-backend.layouts.app>
