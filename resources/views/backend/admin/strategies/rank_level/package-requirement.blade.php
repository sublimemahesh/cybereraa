<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Rank package requirement</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <form class="theme-form" enctype="multipart/form-data" id="rank-package-form">
                        <div id="package-requirement-inputs">
                            @foreach($rank_package_requirement as $rank => $amount)
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="rank_package_requirement_{{ $rank }}">Rank {{ $rank }}</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" value="{{ $amount }}" id="rank_package_requirement_{{ $rank }}" name="rank_package_requirement[{{ $rank }}]" placeholder="" type="text">
                                    </div>
                                </div>
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