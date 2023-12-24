<div class="card">
    <div class="card-header">
        <h5 class="card-title">Withdrawal</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdraw-strategies-form">

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="withdrawal_limits_package">Packages (%)</label>
                        <div class="col-sm-9">
                            <input class="form-control withdrawal_limits" value="{{ $withdrawal_limits->package }}" id="withdrawal_limits_package" name="withdrawal_limits_package" placeholder="Maximum Earning for the package %" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="withdrawal_limits_commission">Commission (%)</label>
                        <div class="col-sm-9">
                            <input class="form-control withdrawal_limits" value="{{ $withdrawal_limits->commission }}" id="withdrawal_limits_commission" name="withdrawal_limits_commission" placeholder="maximum Earning for the commission %" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="max_withdraw_limit">Total maximum payout (%)</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $max_withdraw_limit->value }}" id="max_withdraw_limit" name="max_withdraw_limit" placeholder="Max payout package & commission %" type="number">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-2 d-none">
                        <label class="col-sm-3 col-form-label" for="minimum_p2p_transfer_limit">Minimum P2P Transfer Amount (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $minimum_p2p_transfer_limit->value }}" id="minimum_p2p_transfer_limit" name="minimum_p2p_transfer_limit" placeholder="Minimum withdraw amount Ex: USD 10" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="minimum_payout_limit">Minimum withdraw (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $minimum_payout_limit->value }}" id="minimum_payout_limit" name="minimum_payout_limit" placeholder="Minimum withdraw amount Ex: USD 10" type="number">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="daily_max_withdrawal_limits">Daily Max withdraw (USD)</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ $daily_max_withdrawal_limits->value }}" id="daily_max_withdrawal_limits" name="daily_max_withdrawal_limits" placeholder="Maximum withdraw limit for the one day. Ex: USD 100" type="number">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="withdrawal_days_of_week">Allowed Withdrawal days</label>
                        <div class="col-sm-9">
                            <select class="form-control" multiple name="withdrawal_days_of_week[]" id="withdrawal_days_of_week">
                                <option disabled>Select Week days</option>
                                <option value="Monday" {{ in_array("Monday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ in_array("Tuesday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ in_array("Wednesday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ in_array("Thursday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ in_array("Friday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ in_array("Saturday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Saturday</option>
                                <option value="Sunday" {{ in_array("Sunday", $withdrawal_days_of_week, true) ? 'selected' : '' }}>Sunday</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="save-withdraw-strategies" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/backend/js/admin/strategies/withdrawal/limits.js') }}"></script>
@endpush
