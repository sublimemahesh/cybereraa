<div class="card">
    <div class="card-header">
        <h5 class="card-title">Transaction fees</h5>
    </div>
    <div class="card-body">
        <form class="theme-form" enctype="multipart/form-data" id="transaction-strategies-form">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label" for="min_custom_investment">Minimum Custom Investment Amount (USD)</label>
                        <div class="col-sm-8">
                            <input class="form-control" value="{{ $min_custom_investment->value }}" id="min_custom_investment" name="min_custom_investment" placeholder="Minimum Custom Investment Amount (USD)" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label" for="max_custom_investment">Maximum Custom Investment Amount (USD)</label>
                        <div class="col-sm-8">
                            <input class="form-control" value="{{ $max_custom_investment->value }}" id="max_custom_investment" name="max_custom_investment" placeholder="Maximum Custom Investment Amount (USD)" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-4 col-form-label" for="custom_investment_gas_fee">Custom Investment Gas Fee (%)</label>
                        <div class="col-sm-8">
                            <input class="form-control" value="{{ $custom_investment_gas_fee->value }}" min="1" max="100" id="custom_investment_gas_fee" name="custom_investment_gas_fee" placeholder="Custom Investment Gas Fee (%)" type="number">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="payout_transfer_fee">Withdrawal fee (%)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $payout_transfer_fee->value }}" id="payout_transfer_fee" name="payout_transfer_fee" placeholder="Payout transfer fee" type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2 d-none">
                        <label class="col-sm-3 col-form-label" for="staking_withdrawal_fee">Staking Withdrawal fee (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $staking_withdrawal_fee->value }}" id="staking_withdrawal_fee" name="staking_withdrawal_fee" placeholder="Payout transfer fee" type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2 d-none">
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
