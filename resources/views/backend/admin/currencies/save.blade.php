<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="currency-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">Currency</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Currency" type="text" value="{{ $currency->name ?? null }}">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="value">Value ($)</label>
                <div class="col-sm-9">
                    <input class="form-control" id="value" name="value" placeholder="Value" type="text" value="{{ $currency->value ?? null }}">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="change">Change (%)</label>
                <div class="col-sm-9">
                    <input class="form-control" id="change" name="change" placeholder="Change (%) in Last 30 Days" type="text" value="{{ $currency->change ?? null }}">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="image">Image</label>
                <div class="col-sm-9">
                    <input class="form-control" id="image_name" type="file" accept="image/*" placeholder="Select Image">
                    <input class="form-control" id="image_data" type="hidden">
                    @if(!empty($currency->image_name))
                        <img class="preview-image img-thumbnail mt-2 preview-image w-25" alt="preview-image" src="{{ storage('currencies/'.$currency->image_name) }}"/>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-currency" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const CURRENCY_ID = '{{ $currency->id ?? null }}'
        </script>
    @endpush
</div>
