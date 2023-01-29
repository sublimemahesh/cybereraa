<x-backend.layouts.app>
    @section('title', 'Roles')
    @section('header-title', 'Roles' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Roles</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Edit Roles
                    </h5>
                    <hr>
                    <x-jet-validation-errors class="text-danger" />
                    <form action="{{ route("super_admin.roles.update", [$role->id]) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="name">Name</label>
                                <div class="col-sm-9">
                                    @can('default.roles.manage', $role)
                                        <input class="form-control" name="name" id="name" type="text" value="{{ old('title', $role->name) }}">
                                    @else
                                        <input name="name" id="name" type="hidden" value="{{ old('title', $role->name) }}">
                                        <div class="form-control">{{ old('title', $role->name) }} </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="permissions">Permissions</label>
                                <div class="col-sm-9">
                                    <select class="single-select-placeholder js-states select2-hidden-accessible select2" name="permissions[]" id="permissions" multiple="multiple">
                                        @foreach($permissions as $id => $permission)
                                            <option value="{{ $id }}" {{ (in_array($id, old('permissions', []), true) || $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permission }}</option>
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

