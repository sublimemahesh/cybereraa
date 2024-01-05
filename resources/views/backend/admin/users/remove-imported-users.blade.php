<x-backend.layouts.app>
    @section('title', 'Remove Imported Bulk Users | Users')
    @section('header-title', 'Remove Imported Bulk Users')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Remove Imported Bulk Users</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Bulk Remove Direct Users
                    </h5>
                    <hr>
                    <form>
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-3 mt-2">
                                <label class="col-sm-12 col-form-label" for="user_id">Select Parent User</label>
                                <div class="col-sm-12">
                                    <select name="user_id" class="form-control single-select-placeholder js-states select2-hidden-accessible" id="user_id">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <x-jet-input-error for="parent-user" class="text-danger m-2"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="button" id="remove-import-users" class="btn btn-danger">Remove</button>
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
                            return APP_URL + '/admin/filter/removable/users/' + params.term;
                        }, method: 'POST', dataType: 'json', delay: 1000, processResults: function (data) {
                            return {
                                results: data.data
                            };
                        }, cache: true
                    }, minimumInputLength: 3, placeholder: 'Select an User', allowClear: true
                });

                $(document).on('click', '#remove-import-users', function (e) {
                    e.preventDefault();
                    const errorContainer = document.getElementById('errorContainer');
                    errorContainer.innerHTML = '';
                    Swal.fire({
                        title: "Are You Sure?",
                        text: "Please Note: Some direct users may not delete if they have purchased packages or referral users under their account. Only imported users without purchased packages and not having referral users will be delete!",
                        icon: "info",
                        showCancelButton: true,
                    }).then((create) => {
                        if (create.isConfirmed) {
                            loader()
                            let user_id = $('#user_id').val();
                            axios
                                .post("{{ route('admin.users.remove.import-users') }}", {user_id})
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
                                    if (error.response && error.response.data && error.response.data.message) {
                                        errorContainer.innerHTML = `<h3>Remove Result:</h3>`;
                                        errorContainer.innerHTML += `<p class="fs-16 text-danger">${error.response.data.message}</p>`;
                                    } else {
                                        // Handle other errors
                                        console.error(error);
                                    }
                                });
                        }
                    });
                })
            })
        </script>

    @endpush
</x-backend.layouts.app>
