<x-backend.layouts.app>
    @section('title', 'Edit Password')
    @section('header-title', 'Edit Password')
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('super_admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="">Edit Password</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Edit Password
                    </h5>
                    <hr>
                    <form action="{{ route('super_admin.users.savePassword',$user) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label">User name</label>
                                <div class="col-sm-9">
                                    <label class="col-sm-3 col-form-label form-control disabled">{{ old('name', $user->username) }}</label>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="password">Password</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="password" id="password" type="password" autocomplete="new-password">
                                    <input name="id" type="hidden" value="{{ old('id', $user->id) }}">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="password_confirmation">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" autocomplete="new-password">
                                </div>
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
        @if($user?->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive($user),true))
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Remove two Factor Authentication
                        </h5>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" id="remove-two-factor" class="btn btn-primary">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script !src="">
            $(function () {
                $('#remove-two-factor').click(function () {
                    Swal.fire({
                        title: "Are You Sure?",
                        text: "Remove Two Factor Authentication From this Account?",
                        icon: "info",
                        confirmButtonText: `<i class="fa fa-thumbs-up"></i> Remove!`,
                        showCancelButton: true,
                    }).then((activate) => {
                        if (activate.isConfirmed) {
                            loader()
                            axios.post('{{ route('super_admin.users.remove-two-factor', $user) }}').then(response => {
                                Toast.fire({
                                    icon: response.data.icon, title: response.data.message,
                                })
                                if (response.data.redirectUrl !== null) {
                                    location.href = response.data.redirectUrl
                                }
                            }).catch(error => {
                                console.log(error)
                                Toast.fire({
                                    icon: 'error', title: error.response.data.message || "Something went wrong!",
                                })
                            })
                        }
                    });
                })
            })
        </script>
    @endpush
</x-backend.layouts.app>
