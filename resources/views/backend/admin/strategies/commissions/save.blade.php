<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="withdrawal-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">Commissions</label>
                <div class="col-sm-9">
                    <input class="form-control" id="commissions" name="" placeholder="Commissions" type="text">
                </div>
            </div>
            <div id="add_textflied"></div>

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
