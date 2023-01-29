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

    </div>

    @push('scripts')

    @endpush
</x-backend.layouts.app>
