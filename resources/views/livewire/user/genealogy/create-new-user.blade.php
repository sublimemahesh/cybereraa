<div class="row">

    <div class="col-lg-6 mb-4">
        <label class="mb-1" for="first_name"><strong>{{ __('First Name') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="first_name" wire:model.lazy="state.first_name" class="block mt-1 w-full form-control" type="text"
                name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name"/>
        @error('state.first_name')
        {{-- <div class="text-sm text-red-600 main-registerMessage">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mb-4">
        <label class="mb-1" for="last_name"><strong>{{ __('Last Name') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="last_name" wire:model.lazy="state.last_name" class="block mt-1 w-full form-control" type="text"
                name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name"/>
        @error('state.last_name')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="country"><strong>{{ __('Country') }}<sup class="main-required">*</sup></strong></label>
        <select id="country" wire:model.lazy="state.country_id"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-control">
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
        @error('state.country_id')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="street"><strong>{{ __('Street') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="street" wire:model.lazy="state.street" class="block mt-1 w-full form-control" type="text"
                name="street" :value="old('street')" required autofocus autocomplete="street"/>
        @error('state.street')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="state"><strong>{{ __('State') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="state" wire:model.lazy="state.state" class="block mt-1 w-full form-control" type="text"
                name="state" :value="old('state')" required autofocus autocomplete="state"/>
        @error('state.state')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="address"><strong>{{ __('Address') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="address" wire:model.lazy="state.address" class="block mt-1 w-full form-control" type="text"
                name="address" :value="old('address')" required autofocus autocomplete="address"/>
        @error('state.address')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="zip_code"><strong>{{ __('Zip Code') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="zip_code" wire:model.lazy="state.zip_code" class="block mt-1 w-full form-control" type="text"
                name="zip_code" :value="old('zip_code')" required autofocus autocomplete="zip_code"/>
        @error('state.zip_code')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>

    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="email"><strong>{{ __('Email') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="email" wire:model.lazy="state.email" class="block mt-1 w-full form-control" type="email"
                name="email" :value="old('email')" required/>
        @error('state.email')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-4">
        <div>
            <label class="mb-1" for="phone"><strong>{{ __('Mobile Number') }}
                    <sup class="main-required">*</sup></strong></label>
            <x-jet-input wire:ignore id="phone" class="block mt-1 w-full form-control" type="text" name="phone"
                    :value="old('phone')" required autofocus autocomplete="phone"/>
        </div>
        @error('state.phone')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror

    </div>

    <div class="col-lg-6 mt-4">
        <div>
            <label class="mb-1" for="home_phone"><strong>{{ __('Other Number') }}
                    <sup class="main-required">*</sup></strong></label>
            <x-jet-input wire:ignore id="home_phone" class="block mt-1 w-full form-control" type="text" name="home_phone"
                    :value="old('home_phone')" required autofocus autocomplete="home_phone"/>
        </div>
        @error('state.home_phone')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror

    </div>

    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="gender"><strong>{{ __('Gender') }}<sup class="main-required">*</sup></strong></label>
        <select id="gender" wire:model.lazy="state.gender"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-control">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        @error('state.gender')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>

    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="dob"><strong>{{ __('Date Of Birth') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="dob" type="date" wire:model.lazy="state.dob" class="block mt-1 w-full form-control"
                name="dob" :value="old('dob')" required autofocus autocomplete="dob"/>
        @error('state.dob')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>


    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="password"><strong>{{ __('Password') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="password" wire:model.lazy="state.password" class="block mt-1 w-full form-control"
                type="password" name="password" required autocomplete="new-password"/>
        @error('state.password')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>

    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="password_confirmation"><strong>{{ __('Confirm Password') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="password_confirmation" wire:model.lazy="state.password_confirmation"
                class="block mt-1 w-full form-control" type="password" name="password_confirmation" required
                autocomplete="new-password"/>
        @error('state.password_confirmation')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-12 mt-4">
        <div class="relative border rounded-md px-5 py-4 bg-secondary/70 border-secondary/70 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300 flex items-center mb-2"
                role="alert">
            <p class="text-sm">Passwords should contain a minimum of 8 characters, using a mix of uppercase and lowercase
                letters, numbers, and special characters.</p>
        </div>
    </div>
    <div class="col-lg-6  mt-4">
        <label class="mb-1" for="nic"><strong>{{ __('NIC') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="nic" wire:model.lazy="state.nic" class="block mt-1 w-full form-control" type="text" name="nic" :value="old('nic')" required/>
        @error('state.nic')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6  mt-4">
        <label class="mb-1" for="driving_lc_number"><strong>{{ __('Driving license number') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="driving_lc_number" wire:model.lazy="state.driving_lc_number" type="text" class="block mt-1 w-full form-control" name="driving_lc_number" :value="old('driving_lc_number')" required/>
        @error('state.driving_lc_number')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6  mt-4">
        <label class="mb-1" for="passport_number"><strong>{{ __('Passport number') }}<sup class="main-required">*</sup></strong></label>

        <x-jet-input id="passport_number" wire:model.lazy="state.passport_number" type="text" class="block mt-1 w-full form-control" name="passport_number" :value="old('passport_number')" required/>
        @error('state.passport_number')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>

    <div class="col-lg-6 mt-4">
        <label class="mb-1" for="username"><strong>{{ __('Nominated Username') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="username" wire:model.lazy="state.username" class="block mt-1 w-full  form-control" type="text" name="username" required autocomplete="off"/>
        @error('state.username')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="col-lg-12 mt-4">
            <x-jet-label for="terms">
                <div class="d-flex align-items-center">
                    <x-jet-checkbox name="terms" id="terms" wire:model.lazy="state.terms" required/>
                    <div class="ml-2">
                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                        ]) !!}
                    </div>
                </div>
                @error('state.terms')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </x-jet-label>
        </div>
    @endif

    <div class="col-lg-12 mb-4">
        <button wire:click.prevent="register" type="submit" class="btn btn-primary btn-block">
            Register
        </button>
    </div>

    <x-jet-validation-errors class="col-lg-12 mb-4 text-danger"/>
    @push('scripts')
        <script>
            function init() {

                const itl_phone = intlTelInput.intlTelInput(document.querySelector("#phone"), {
                    initialCountry: "LK",
                })
                const itl_home_phone = intlTelInput.intlTelInput(document.querySelector("#home_phone"), {
                    initialCountry: "LK",
                })

                document.querySelector("#phone").addEventListener('change', function (e) {
                    let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                    @this.
                    set('state.phone', phone);
                })
                document.querySelector("#home_phone").addEventListener('change', function (e) {
                    let home_phone = itl_home_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                    @this.
                    set('state.home_phone', home_phone);
                })
            }

            window.addEventListener('DOMContentLoaded', (event) => {
                init()
            });
            Livewire.hook('message.processed', (message, component) => {
                init()
                document.querySelector("#phone").value = component.serverMemo.data.state.phone
                document.querySelector("#home_phone").value = component.serverMemo.data.state.home_phone
            });
        </script>
    @endpush
</div>