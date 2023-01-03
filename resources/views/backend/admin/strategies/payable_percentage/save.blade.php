<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="packages">Direct</label>
                <div class="col-sm-9">
                    <input class="form-control" id="packages" name="direct" placeholder="Direct" type="text">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="commission">Indirect</label>
                <div class="col-sm-9">
                    <input class="form-control" id="commission" name="indirect" placeholder="Indirect"
                        type="text">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="max withdraw">Rank bonus</label>
                <div class="col-sm-9">
                    <input class="form-control" id="mw" name="Rank_bonus" placeholder="Rank bonus"
                        type="text">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-package" class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
    @push('scripts')
    @endpush
</div>
