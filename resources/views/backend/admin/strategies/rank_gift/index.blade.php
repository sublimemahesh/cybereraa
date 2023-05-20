<x-backend.layouts.app>
    @section('title', 'Strategies | commissions')
    @section('header-title', 'Strategies | Rank level')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a class="active">Rank level</a>
        </li>
    @endsection

    <div class="row">
        @include('backend.admin.strategies.rank_gift.levels', ['btn_id' => 'create'])

        {{-- ////////////////////////////  Rank package requirement ///////////////////// --}}
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
                                    @foreach($rank_gift_requirements as $rank => $requirement)
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-4 col-form-label" for="rank_gift_requirements_{{ $rank }}_total_investment">Rank {{ $rank }} Total Investment</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" value="{{ $requirement['total_investment'] }}" id="rank_gift_requirements_{{ $rank }}_total_investment" name="rank_gift_requirements[{{ $rank }}][total_investment]" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-4 col-form-label" for="rank_gift_requirements_{{ $rank }}_total_team_investment">Rank {{ $rank }} Total Team Investment</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" value="{{ $requirement['total_team_investment'] }}" id="rank_gift_requirements_{{ $rank }}_total_team_investment" name="rank_gift_requirements[{{ $rank }}][total_team_investment]" placeholder="" type="text">
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

    </div>

    @push('scripts')
        <script>
            $(document).on('click', '#save-rank-package', function (e) {
                loader()
                e.preventDefault();

                let __form = $('#rank-package-form');

                __form.find(".text-danger").remove();
                let formData = __form.serialize();

                axios.patch(`${APP_URL}/admin/strategies/rank/gift-requirements`, formData).then(response => {
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
                    appendError('save-rank-package', `<span class="text-danger">${error.response.data.message}</span>`)
                })
            })

            function appendError(id, html) {
                $(`#${id}`).next(".text-danger").remove();
                $(html).insertAfter(`#${id}`)
            }
        </script>
    @endpush
</x-backend.layouts.app>
