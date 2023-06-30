<x-backend.layouts.app>
    @section('title', 'Transfer Funds')
    @section('header-title', 'Transfer Funds' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Peer To Peer Transfer Funds</li>
    @endsection
    <div class="row">
        @include('backend.user.wallet.top-nav')
        <div class="col-xl-8 col-sm-6">
            {{--<div class="alert alert-warning">P2P transactions are temporarily suspended for 24 hours from 4.00 Pm on 6th April 2023 to 4.00 pm on 7th April 2023!</div>--}}
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">P2P Transfer Confirmation</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="theme-form" enctype="multipart/form-data" id="confirm-form">
                                <div class="mb-3 mt-2">
                                    <label for="p2p-transfer">Sender</label>
                                    <div class="form-control">{{ $p2p->user_id }} - {{ $p2p->user->username }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Transferred Amount</label>
                                    <div class="form-control">USDT {{ $p2p->amount }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Status</label>
                                    <div class="form-control">{{ $p2p->status }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Received Date</label>
                                    <div class="form-control">{{ $p2p->created_at->format('Y-m-d h:i A') }}</div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea id="remark" rows="3" placeholder="Remark" class="form-control h-auto" disabled>{{ $p2p->remark }}</textarea>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="payout_info">Payout Info</label>
                                    <div class="text-info">View Profile Details:
                                        <a href="{{ route('admin.users.profile.show', $p2p->user) }}">View Profile</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="proof_document">Proof</label>
                                    <input class="form-control" data-input='payout' type="file" name='proof_document' id='proof_document'>
                                </div>
                                <hr>
                                <button type="submit" id="confirm-p2p" class="btn btn-sm btn-success mb-2">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/wallet/confirm-p2p.js') }}"></script>
    @endpush
</x-backend.layouts.app>
