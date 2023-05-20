<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Rank level & Gift Level </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="rank_level_count">No Of Ranks</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly value="{{ $rank_level_count->value }}" id="rank_level_count" name="rank_level_count" type="number" placeholder="Enter Count of Ranks available">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-2">
                        <label class="col-sm-3 col-form-label" for="rank_gift_levels">Rank Gift</label>
                        <div class="col-sm-9">
                            <input class="form-control" readonly id="rank_gift_levels" value="{{ count($rank_gift_levels) }}" name="rank_gift_levels" placeholder="Enter Count of Rank Gift issue" type="number">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









