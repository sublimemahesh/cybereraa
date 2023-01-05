<div class="row">
    <div class="col-sm-8">
        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="rank_gift">Rank gift Amount (%)</label>
            <div class="col-sm-9">
                <input class="form-control" data-input="commissions" id="rank_gift" value="{{ $rank_gift->value }}" name="rank_gift" placeholder="Enter Rank gift amount in USD" type="text">
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-3 col-form-label" for="rank_bonus">Rank Bonus Amount (%)</label>
            <div class="col-sm-9">
                <input class="form-control" data-input="commissions" id="rank_bonus" value="{{ $rank_bonus->value }}" name="rank_bonus" placeholder="Enter Rank bonus amount in USD" type="text">
            </div>
        </div>
    </div>
</div>