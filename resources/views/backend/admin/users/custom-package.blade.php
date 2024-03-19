<x-backend.layouts.app>
    @section('title', 'Custom Investment | Users')
    @section('header-title', 'Custom Investment')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Custom Investment</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.custom-investment') }}" id="custom-free-package-form" enctype="multipart/form-data" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-3 mt-2">
                                <label class="col-sm-12 col-form-label" for="user_id">Select User</label>
                                <div class="col-sm-12">
                                    <select name="user_id" class="form-control single-select-placeholder js-states select2-hidden-accessible" id="user_id">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <x-jet-input-error for="user_id" class="text-danger m-2"/>
                            </div>

                            <div class="form-group row mb-3 ">
                                <label class="col-sm-12 col-form-label" for="amount">Enter Amount</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" placeholder="Investment Amount" name="amount" id="amount">
                                </div>
                                <x-jet-input-error for="amount" class="text-danger m-2"/>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">CONFIRM & ADD PACKAGE</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <div id="errorContainer" class="text-danger"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function (event) {
                $("#user_id").select2({
                    ajax: {
                        url: function (params) {
                            return APP_URL + '/super-admin/filter/users/' + params.term;
                        }, method: 'POST', dataType: 'json', delay: 1000, processResults: function (data) {
                            return {
                                results: data.data
                            };
                        }, cache: true
                    }, minimumInputLength: 3, placeholder: 'Select an User', allowClear: true
                });

                $(document).on('submit', '#custom-free-package-form', function (e) {
                    e.preventDefault();
                    if ($('#amount').val() <= 0) {
                        Toast.fire({
                            icon: "error", title: "Investment Amount is required.!",
                        });
                    } else {

                        Swal.fire({
                            title: "Are You Sure?",
                            text: "Activate package for selected user?, Please note that this process cannot be reversed. Please make sure all the provided information's are double checked before proceed.!",
                            icon: "info",
                            showCancelButton: true,
                        }).then((transfer) => {
                            if (transfer.isConfirmed) {
                                loader()
                                const form = $('#custom-free-package-form')[0]; // You need to use standard javascript object here
                                const formData = new FormData(form);
                                axios
                                    .post("{{ route('admin.users.custom-investment') }}", formData)
                                    .then(function (response) {
                                        Toast.fire({
                                            icon: response.data.icon, title: response.data.message || "Success!",
                                        }).then(function () {
                                            //form.reset();
                                        });
                                        location.reload()
                                    })
                                    .catch(function (error) {
                                        // Swal.close()
                                        Toast.fire({
                                            icon: "error", title: error.response.data.message || "Something went wrong!",
                                        });
                                    });
                            }
                        })
                    }
                })
            })
        </script>

    @endpush
</x-backend.layouts.app>
