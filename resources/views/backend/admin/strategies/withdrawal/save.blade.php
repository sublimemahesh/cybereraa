


<div class="card">
    <div class="card-header">
        <h5 class="card-title">Withdrawal</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="packages">Packages</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="packages" name="packages" placeholder="Packages"
                                type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="commission">Commission</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="commission" name="commission" placeholder="Commission"
                                type="text">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="max withdraw">Max withdraw</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="mw" name="max_withdraw" placeholder="Max withdraw"
                                type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" id="{{ $btn_id }}-package"
                                class="btn btn-primary">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- //////////////////// Min Withdrawal //////////// --}}

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Min withdrawal</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="min withdraw">Min withdraw</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="" name="min_withdraw" placeholder="Max withdraw"
                            type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" id="{{ $btn_id }}-package" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- //////////////////////// Payout transfer ///////////// --}}

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Payout transfer</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="payout transfer fee">Payout transfer
                        fee </label>
                    <div class="col-sm-9">
                        <input class="form-control" id="" name="payout_transfer_fee"
                            placeholder="Payout transfer fee" type="text">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for=">p2p transfer fee">P2P transfer
                        fee</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="" name="p2p_transfer_fee"
                            placeholder="P2P transfer fee" type="text">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" id="{{ $btn_id }}-package" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
</div>
