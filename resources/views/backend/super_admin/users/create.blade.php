<x-backend.layouts.app>
    @section('title', 'Users')
    @section('header-title', 'Users')
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('super_admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0)">Create</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Add a new user
                    </h5>
                    <hr>
                    <form action="{{ route('super_admin.users.store') }}" enctype="multipart/form-data" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="name">Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="name" id="name" value="{{ old('name') }}" type="text">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="username">User name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="username" id="username" value="{{ old('username') }}" type="text" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="country">Country</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="country_id" id="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $key => $country)
                                            <option data-value="{{ $key }}" value="{{ $country->id }}" {{ $country->id === old('country_id')  ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="phone">Mobile number</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="phone" id="phone" value="{{ old('phone') }}" type="text">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="email">Email</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="email" id="email" value="{{ old('email') }}" type="email">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="password">Password</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="password" id="password" type="password" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="password_confirmation">Confirm password</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="role">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Select Role</option>
                                        @foreach($roles as $id => $role)
                                            <option value="{{ $id }}" {{ $id === old('role') ? 'selected' : '' }}>{{ $role }}</option>
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
                $('#country').select2();
            });

            window.addEventListener('DOMContentLoaded', (event) => {
                let itl_phone

                function init(phone_iso = 'lk') {
                    itl_phone && itl_phone.destroy();

                    try {
                        return intlTelInput.intlTelInput(document.querySelector("#phone"), {
                            initialCountry: phone_iso,
                            formatOnDisplay: false,
                            //allowDropdown: false,
                            autoPlaceholder: 'aggressive'
                        })
                    } catch (e) {
                        console.log(e.message)
                        return init('lk')
                    }
                }

                itl_phone = init()
                document.getElementById('country').onchange = function (e) {
                    let selectedISO = e.target.options[e.target.selectedIndex].getAttribute('data-value');
                    let currentPhoneISO = itl_phone.getSelectedCountryData().iso2
                    let currentPhoneVal = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164)
                    let phone_iso = currentPhoneVal.length ? currentPhoneISO : selectedISO
                    itl_phone.setCountry(phone_iso)
                }
            });
        </script>

    @endpush
</x-backend.layouts.app>
