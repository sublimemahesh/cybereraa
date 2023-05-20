<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Rank Bonus requirement</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <form class="theme-form" enctype="multipart/form-data" id="rank-package-form">
                        <div id="package-requirement-inputs">
                            @foreach($rank_package_requirement as $rank => $requirement)
                                <div class="form-group row mb-2">
                                    <label class="col-sm-4 col-form-label" for="rank_package_requirement_{{ $rank }}_active_investment">Rank {{ $rank }} Active Investment</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" value="{{ $requirement['active_investment'] }}" id="rank_package_requirement_{{ $rank }}_active_investment" name="rank_package_requirement[{{ $rank }}][active_investment]" placeholder="" type="text">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-4 col-form-label" for="rank_package_requirement_{{ $rank }}_total_team_investment">Rank {{ $rank }} Total Team Investment</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" value="{{ $requirement['total_team_investment'] }}" id="rank_package_requirement_{{ $rank }}_total_team_investment" name="rank_package_requirement[{{ $rank }}][total_team_investment]" placeholder="" type="text">
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" id="save-rank-package" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
