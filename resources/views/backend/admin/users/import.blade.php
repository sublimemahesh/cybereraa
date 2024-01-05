<x-backend.layouts.app>
    @section('title', 'Import Bulk Users | Users')
    @section('header-title', 'Import Bulk Users')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Import Bulk Users</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            @can('users.remove.bulk-import')
                <a href="{{ route('admin.users.remove.import-users') }}" class="btn btn-danger btn-md mb-2">
                    Remove Import Users
                </a>
            @endcan
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.import') }}" id="import-users-form" enctype="multipart/form-data" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-3 mt-2">
                                <label class="col-sm-12 col-form-label" for="parent-user">Select Parent User</label>
                                <div class="col-sm-12">
                                    <select name="parent-user" class="form-control single-select-placeholder js-states select2-hidden-accessible" id="parent-user">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <x-jet-input-error for="parent-user" class="text-danger m-2"/>
                            </div>

                            <div class="form-group row mb-3 ">
                                <label class="col-sm-12 col-form-label" for="users-list">Select Users File</label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="users-list" id="users-list" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                </div>
                                <x-jet-input-error for="users-list" class="text-danger m-2"/>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Import</button>
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
                $("#parent-user").select2({
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

                $(document).on('submit', '#import-users-form', function (e) {
                    e.preventDefault();
                    const errorContainer = document.getElementById('errorContainer');
                    errorContainer.innerHTML = '';
                    if ($('#users-list').val() <= 0) {
                        Toast.fire({
                            icon: "error", title: "Users excel file is required.!",
                        });
                    } else {
                        loader()
                        const form = $('#import-users-form')[0]; // You need to use standard javascript object here
                        const formData = new FormData(form);
                        axios
                            .post("{{ route('admin.users.import') }}", formData)
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
                                if (error.response && error.response.data && (error.response.data.errors || error.response.data.failures)) {
                                    const failures = error.response.data.failures || error.response.data.errors;

                                    // Display errors in the errorContainer

                                    errorContainer.innerHTML = `<h3>Import Result:</h3>`;
                                    errorContainer.innerHTML += `<p class="fs-16 text-warning">${error.response.data.message}</p>`;

                                    const limit = 20;
                                    // Display up to limit errors
                                    const displayedFailures = failures.slice(0, limit);

                                    // displayedFailures.forEach(failure => {
                                    //     const errorMessage = Array.isArray(failure) ? failure.join('. ') : failure;
                                    //     errorContainer.innerHTML += `<p>${errorMessage}</p>`;
                                    // });

                                    displayedFailures.forEach(failure => {
                                        errorContainer.innerHTML += `<p>Row ${failure.row} (${failure.values.user_id}): ${failure.errors.join(', ')}</p>`;
                                    });
                                    // If there are more than limit errors, mention the count
                                    if (failures.length > limit) {
                                        errorContainer.innerHTML += `<p>And ${failures.length - limit} more errors...</p>`;
                                    }
                                } else {
                                    // Handle other errors
                                    console.error(error);
                                }
                            });
                    }
                })
            })
        </script>

    @endpush
</x-backend.layouts.app>
