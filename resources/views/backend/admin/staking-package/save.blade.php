<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="package-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">NAME</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text"
                           value="{{ $StakingPackage->name ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="currency">CURRENCY</label>
                <div class="col-sm-9">
                    <input class="form-control" disabled placeholder="Currency" type="text"
                           value="{{ $StakingPackage->currency ?? 'USDT' }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="amount">AMOUNT</label>
                <div class="col-sm-9">
                    <input class="form-control" id="amount" name="amount" placeholder="Amount" type="text"
                           value="{{ $StakingPackage->amount ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="gas_fee">GAS FEE</label>
                <div class="col-sm-9">
                    <input class="form-control" id="gas_fee" name="gas_fee" placeholder="Amount" type="text"
                           value="{{ $StakingPackage->gas_fee ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="description">DESCRIPTION</label>
                <div class="col-sm-9">
                    <input class="form-control" id="description" name="description" placeholder="Description"
                           type="text" value="{{ $StakingPackage->description ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="is_active">IS ACTIVE</label>
                <div class="col-sm-9">
                    <div class="form-check custom-checkbox mb-3 check-xs">
                        <input type="checkbox"
                               {{ !empty($StakingPackage->id) && $StakingPackage->is_active ? 'checked' : null }} class="form-check-input"
                               name="is_active" id="is_active">
                        <label class="form-check-label" for="is_active"></label>
                    </div>
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
        <script>
            const PACKAGE_ID = '{{ $StakingPackage->id ?? null }}'
        </script>
    @endpush
</div>
