<x-backend.layouts.app>
    @section('title', 'Strategies | Benefits')
    @section('header-title', 'Strategies | Special Bonus')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a class="active">Special Bonus</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Special Bonus Requirement</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <form class="theme-form" enctype="multipart/form-data" id="bonus-requirement-form">
                                <div id="package-requirement-inputs">
                                    @foreach($special_bonus_requirement as $type => $requirement)
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-4 col-form-label">Direct Sales</label>
                                            <div class="col-sm-8">
                                                <div class="form-control">{{ $requirement['direct_sales'] }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-4 col-form-label" for="special_bonus_requirement_{{ $type }}_total_investment">Direct Sale {{ $requirement['direct_sales'] }} Total Investment</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" value="{{ $requirement['total_investment'] }}" id="special_bonus_requirement_{{ $type }}_total_investment" name="special_bonus_requirement[{{ $type }}][total_investment]" placeholder="" type="number">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-4 col-form-label" for="special_bonus_requirement_{{ $type }}_bonus">Direct Sale {{ $requirement['direct_sales'] }} Bonus Percentage</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" value="{{ $requirement['bonus'] }}" id="special_bonus_requirement_{{ $type }}_bonus" name="special_bonus_requirement[{{ $type }}][bonus]" placeholder="" type="number">
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="save" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).on('click', '#save', function (e) {
                loader()
                e.preventDefault();

                let __form = $('#bonus-requirement-form');

                __form.find(".text-danger").remove();
                let formData = __form.serialize();

                axios.patch(`${APP_URL}/admin/strategies/special-bonus/requirements`, formData).then(response => {
                    Toast.fire({
                        icon: response.data.icon, title: response.data.message,
                    }).then(res => {
                        if (response.data.status) {
                            location.reload();
                        }
                    })
                }).catch((error) => {
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                    error.response.data.message &&
                    appendError('save', `<span class="text-danger">${error.response.data.message}</span>`)
                })
            })

            function appendError(id, html) {
                $(`#${id}`).next(".text-danger").remove();
                $(html).insertAfter(`#${id}`)
            }
        </script>
    @endpush
</x-backend.layouts.app>
