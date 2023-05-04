<x-backend.layouts.app>
    @section('title', 'My Staking')
    @section('header-title', 'My Staking | Reverse Cancel' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.staking-packages.dashboard') }}">Staking</a>
        </li>
        <li class="breadcrumb-item active">Reverse Cancel Staking request</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Reverse the Cancel Staking (#{{ $cancelRequest->id }})</h4>
                        <p>
                            You can reverse the Cancel Staking request before processing begins. <br>
                            <b>STATUS:</b> {{ $cancelRequest->status }}
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
                                    <div class="form-control h-auto">
                                        {{ $cancelRequest->remark }}
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="repudiate_note">Repudiate Note</label>
                                    <textarea id="repudiate_note" name="repudiate_note" class="form-control h-auto" placeholder="Reason"></textarea>
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
        <script src="{{ asset('assets/backend/js/staking/reverse-cancel.js') }}"></script>
    @endpush
</x-backend.layouts.app>
