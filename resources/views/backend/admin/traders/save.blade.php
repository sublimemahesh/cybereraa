<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="trader-form">

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">NAME</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text" value="{{ $trader->name ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="email">EMAIL</label>
                <div class="col-sm-9">
                    <input class="form-control" id="email" name="email" placeholder="Email" type="email" value="{{ $trader->email ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="phone">PHONE</label>
                <div class="col-sm-9">
                    <input class="form-control" id="phone" name="phone" placeholder="Phone" type="text" value="{{ $trader->phone ?? null }}">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" id="{{ $btn_id }}-trader" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const TRADER_ID = '{{ $trader->id ?? null }}'
        </script>
    @endpush
</div>
