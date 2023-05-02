<x-backend.layouts.app>
    @section('title','Roles')
    @section('header-title','Roles')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Ceate New Roles</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Add Roles
                    </h5>
                    <hr>
                    <form action="{{ route('super_admin.roles.store')  }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="role-name">Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="name" id="role-name" type="text" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="permissions">Permissions</label>
                                <div class="col-sm-9">
                                    <select class="single-select-placeholder js-states select2-hidden-accessible select2" id="permissions" name="permissions[]" multiple="multiple">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'selected' : ''  }}>{{ $permission->name }}</option>
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
