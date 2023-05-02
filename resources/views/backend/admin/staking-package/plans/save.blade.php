<div class="row">
    <div class="col-sm-8">
        <form class="theme-form" enctype="multipart/form-data" id="package-form">
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">PACKAGE</label>
                <div class="col-sm-9">
                    <div class="form-control" id="staking_package_id">{{ $package->name ?? null }} </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="name">NAME</label>
                <div class="col-sm-9">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text"
                           value="{{ $plan->name ?? null }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="duration">DURATION (Days)</label>
                <div class="col-sm-9">
                    <input class="form-control" id="duration" name="duration" placeholder="Duration in days" type="text"
                           value="{{ $plan->duration ?? null  }}">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="interest_rate">INTEREST RATE (%)</label>
                <div class="col-sm-9">
                    <input class="form-control" id="interest_rate" name="interest_rate" placeholder="Interest Rate"
                           type="text"
                           value="{{ $plan->interest_rate ?? null }}">
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label" for="is_active">IS ACTIVE</label>
                <div class="col-sm-9">
                    <div class="form-check custom-checkbox mb-3 check-xs">
                        <input type="checkbox"
                               {{ !empty($plan->id) && $plan->is_active ? 'checked' : null }} class="form-check-input"
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
            const PACKAGE_ID = '{{ $package->id ?? null }}'
            const PLAN_ID = '{{ $plan->id ?? null }}'
        </script>
    @endpush
</div>
