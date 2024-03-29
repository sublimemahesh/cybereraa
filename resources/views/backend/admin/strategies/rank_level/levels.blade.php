<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Rank level & Bonus Level</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <form class="theme-form" enctype="multipart/form-data" id="rank-level-form">
                        <div class="form-group row mb-2">
                            <label class="col-sm-3 col-form-label" for="rank_level_count">No Of Ranks</label>
                            <div class="col-sm-9">
                                <input class="form-control" readonly value="{{ $rank_level_count->value }}" id="rank_level_count" name="rank_level_count" type="number" placeholder="Enter Count of Ranks available">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row mb-2">
                            <label class="col-sm-3 col-form-label" for="rank_offset_levels">Rank offset (Excluded Levels)</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="rank_offset_levels" min="0" max="6" value="{{ $rank_level_count->value - count($rank_bonus_levels) }}" name="rank_offset_levels" placeholder="Enter Count of Rank bonus ignore level" type="number">
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="col-sm-3 col-form-label" for="rank_bonus_levels">Rank bonus</label>
                            <div class="col-sm-9">
                                <input class="form-control" readonly id="rank_bonus_levels" value="{{ count($rank_bonus_levels) }}" name="rank_bonus_levels" placeholder="Enter Count of Rank bonus issue" type="number">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" id="save-rank-level" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>









