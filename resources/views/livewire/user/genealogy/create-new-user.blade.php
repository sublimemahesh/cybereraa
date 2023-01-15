<div class="row">
    <div class="col-lg-6 mt-2">
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
    <div class="col-lg-6 mt-2">
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
    <div class="col-lg-6 mt-2">
        <div wire:ignore>
            <label class="mb-1" for="country">
                <strong>{{ __('Country') }}
                    <sup class="main-required">*</sup>
                </strong>
            </label>
            <x-select2 class="form-control" id="country" name="country_id" wire:model="state.country_id" :options="$countries"/>
        </div>
        @error('state.country_id')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-2">
        <div wire:ignore>
            <label class="mb-1" for="phone">
                <strong>{{ __('Mobile Number') }}
                    <sup class="main-required">*</sup>
                </strong>
            </label>
            <x-jet-input wire:ignore id="phone" class="block mt-1 w-full form-control" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone"/>
        </div>
        @error('state.phone')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror

    </div>
    <div class="col-lg-6 mt-2">
        <label class="mb-1" for="email"><strong>{{ __('Email') }}<sup class="main-required">*</sup></strong></label>
        <x-jet-input id="email" wire:model.lazy="state.email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required/>
        @error('state.email')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-2">
        <label class="mb-1" for="username"><strong>{{ __('Username') }}
                <sup class="main-required">*</sup></strong></label>
        <x-jet-input id="username" wire:model.lazy="state.username" class="block mt-1 w-full  form-control" type="text" name="username" required autocomplete="off"/>
        @error('state.username')
        {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
        <div class="text-danger">
            <strong>required!</strong> {{ $message }}.
        </div>
        @enderror
    </div>
    <div class="col-lg-6 mt-2">
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
    <div class="col-lg-6 mt-2">
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
    <div class="col-lg-12 mt-2">
        <div class="relative border rounded-md px-5 py-4 bg-secondary/70 border-secondary/70 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300 flex items-center mb-2"
                role="alert">
            <p class="text-sm">Passwords should contain a minimum of 8 characters, using a mix of uppercase and lowercase
                letters, numbers, and special characters.</p>
        </div>
    </div>
    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="col-lg-12 mt-2">
            <x-jet-label for="terms">
                <div class="d-flex align-items-center">
                    <x-jet-checkbox name="terms" id="terms" wire:model.lazy="state.terms" required/>
                    <div class="mx-2">
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

    <div class="col-lg-12 mt-2">
        <button wire:click.prevent="register" type="submit" class="btn btn-primary btn-block">
            Register
        </button>
    </div>

    <x-jet-validation-errors class="col-lg-12 mb-4 text-danger"/>


    @push('scripts')
        @include('auth.layouts.js-init-script')
    @endpush
</div>
