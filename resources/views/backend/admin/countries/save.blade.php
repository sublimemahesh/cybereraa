<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="country-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">Name</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Country Name" type="text" value="{{ $country->name ?? null }}">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="iso">ISO</label>
                <div class="col-sm-9">
                    <input class="form-control" id="iso" name="iso" placeholder="Unique ISO Code" type="text" value="{{ $country->iso ?? null }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-country" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const COUNTRY_ID = '{{ $country->id ?? null }}'
        </script>
    @endpush
</div>
