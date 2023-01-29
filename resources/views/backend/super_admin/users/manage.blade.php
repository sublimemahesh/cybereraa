<x-backend.layouts.app>
    @section('title', 'Manage permission')
    @section('header-title', 'Manage permission')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('super_admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="">Manage permission</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Manage permission
                    </h5>
                    <hr>
                    <form action="{{ route('super_admin.users.store-permissions', $user) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="name">User Details</label>
                                <div class="col-sm-9">
                                    <div class="form-control"> {{$user->id }}: {{$user->name }} - {{$user->username }} </div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="role">Role</label>
                                <div class="col-sm-9">
                                    @if(!$user->hasRole('user'))
                                        <select class="form-control" name="role" id="role">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $id => $role)
                                                <option value="{{ $id }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <div class="form-control"> User</div>
                                        <input type="hidden" name="role" value="{{ $user->roles->where('name', 'user')->first()->id }}"/>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="permissions">Direct Permissions</label>
                                <div class="col-sm-9">
                                    <select class="js-example-basic-multiple" name="permissions[]" id="permissions" multiple="multiple">
                                        @foreach ($permissions as $key=> $name)
                                            <option value="{{ $key }}" {{ $user->hasDirectPermission($name) ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
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
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#permissions').select2();
            });
        </script>
    @endpush
</x-backend.layouts.app>
