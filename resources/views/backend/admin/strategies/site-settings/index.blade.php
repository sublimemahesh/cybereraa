<x-backend.layouts.app>
    @section('title', 'Strategies | Site Settings')
    @section('header-title', 'Strategies | Site Settings' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Site Settings</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        KYC
                    </h5>
                    <p>KYC Automated settings</p>
                    <hr>
                    <form class="theme-form" enctype="multipart/form-data" id="site-settings-form">
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="automate_kyc">Automate KYC</label>
                                <div class="col-sm-9">
                                    <div class="form-check custom-checkbox mb-3 check-xs">
                                        <input type="checkbox" {{ $automateKyc ? 'checked' : null }} value="1" class="form-check-input" name="automate_kyc" id="automate_kyc">
                                        <label class="form-check-label" for="automate_kyc"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" id="save-site-settings" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script !src="">
            $(function () {

                $(document).on('click', '#save-site-settings', function (e) {
                    loader()
                    e.preventDefault();

                    let __form = $('#site-settings-form');

                    __form.find(".text-danger").remove();
                    let formData = __form.serialize();

                    axios.patch(`${APP_URL}/admin/strategies/site-settings`, formData).then(response => {
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
                        let errorMap = ['automate_kyc']
                        errorMap.map(id => {
                            error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                        })
                    })
                })

                function appendError(id, html) {
                    $(`#${id}`).next(".text-danger").remove();
                    $(html).insertAfter(`#${id}`)
                }
            })
        </script>
    @endpush
</x-backend.layouts.app>

