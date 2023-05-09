<div class="card">
    <div class="card-header">
        <h5 class="card-title">Transaction fees</h5>
    </div>
    <div class="card-body">
        <form class="theme-form" enctype="multipart/form-data" id="transaction-strategies-form">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="payout_transfer_fee">Withdrawal fee (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $payout_transfer_fee->value }}" id="payout_transfer_fee" name="payout_transfer_fee" placeholder="Payout transfer fee" type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="staking_withdrawal_fee">Staking Withdrawal fee (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $staking_withdrawal_fee->value }}" id="staking_withdrawal_fee" name="staking_withdrawal_fee" placeholder="Payout transfer fee" type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="p2p_transfer_fee">P2P transfer fee (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $p2p_transfer_fee->value }}" id="p2p_transfer_fee" name="p2p_transfer_fee" placeholder="P2P transfer fee" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="save-transaction-strategies" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/backend/js/admin/strategies/withdrawal/fees.js') }}"></script>
@endpush
