<x-backend.layouts.app>
    @section('title', 'Change sponsor | Users')
    @section('header-title', 'Change sponsor')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('super_admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Change sponsor</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Change {{ $user->username }} sponsor
                    </h5>
                    <hr>
                    <form action="{{ route('super_admin.users.change-sponsor', $user) }}" enctype="multipart/form-data" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="name">Name</label>
                                <div class="col-sm-9">
                                    <div class="form-control">{{ $user->name }}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="username">User name</label>
                                <div class="col-sm-9">
                                    <div class="form-control">{{ $user->username }}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="username">Current Sponsor</label>
                                <div class="col-sm-9">
                                    <div class="form-control">{{ $user->sponsor->id }} - {{ $user->sponsor->username }} - {{ $user->sponsor->name }}</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3 mt-2">
                                <label class="col-sm-12 col-form-label" for="sponsor-user">Select New Sponsor User</label>
                                <div class="col-sm-12">
                                    <select name="new_sponsor_user" required class="form-control single-select-placeholder js-states select2-hidden-accessible" id="sponsor-user">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <x-jet-input-error for="new_sponsor_user" class="text-danger m-2"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
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
            $("#sponsor-user").select2({
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
        </script>

    @endpush
</x-backend.layouts.app>
