<div class="col-xl-12">
    <div class="auth-form">
        <div class="text-center mb-3">
            <a href="{{ route('/') }}">
                <img class="m-auto" src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt="">
            </a>
        </div>
        <h4 class="text-center mb-4">Create Your Account</h4>
        <form>
            @csrf
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <label class="mb-1" for="first_name"><strong class="main-register-form-text">{{ __('First Name') }}
                            <sup class="main-required">*</sup></strong>
                    </label>
                    <x-jet-input id="first_name" wire:model.lazy="state.first_name" class="block mt-1 w-full form-control" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name"/>
                    @error('state.first_name')
                    {{-- <div class="text-sm text-red-600 main-registerMessage">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <label class="mb-1" for="last_name"><strong class="main-register-form-text">{{ __('Last Name') }}
                            <sup class="main-required">*</sup>
                        </strong>
                    </label>
                    <x-jet-input id="last_name" wire:model.lazy="state.last_name" class="block mt-1 w-full form-control" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name"/>
                    @error('state.last_name')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <div wire:ignore>
                        <label class="mb-1" for="country"><strong class="main-register-form-text">{{ __('Country') }}
                                <sup class="main-required">*</sup>
                            </strong>
                        </label>
                        <x-select2 id="country" name="country_id" wire:model="state.country_id" :options="$countries"/>
                    </div>
                    @error('state.country_id')
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <div wire:ignore>
                        <label class="mb-1" for="phone">
                            <strong class="main-register-form-text">{{ __('Mobile Number') }}
                                <sup class="main-required">*</sup>
                            </strong>
                        </label>
                        <x-jet-input wire:ignore id="phone" class="block mt-1 w-full form-control" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone"/>
                    </div>
                    @error('state.phone')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror

                </div>
                <div class="col-lg-12 mt-3">
                    <label class="mb-1" for="email"><strong class="main-register-form-text">{{ __('Email') }}
                            <sup class="main-required">*</sup></strong></label>
                    <x-jet-input id="email" wire:model.lazy="state.email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required/>
                    @error('state.email')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <div wire:ignore>
                        <label class="mb-2" for="sponsor">
                            <strong class="main-register-form-text">{{ __('Sponsor username') }}</strong>
                        </label>
                        @if($disable_sponsor_modify)
                            <span class="block mt-1 w-full form-control">{{ $state['sponsor'] }}</span>
                        @else
                            <select wire:model.lazy="state.sponsor" class="single-select-placeholder js-states select2-hidden-accessible" id="sponsor">
                                <option disabled>Start typing sponsor name</option>
                            </select>
                            {{-- <x-jet-input id="sponsor" wire:model.lazy="state.sponsor" class="block mt-1 w-full  form-control" type="text" name="sponsor" required autocomplete="sponsor"/>--}}
                        @endif
                    </div>
                    @if(!empty($sponsor->name))
                        <div class="py-2 px-1 text-success">
                            <strong>Sponsor Details:</strong> {{ $sponsor->username }} - {{ $sponsor->name }}
                        </div>
                    @endif
                    @error('state.sponsor')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>required!</strong> {{ $message }}.
                    </div>
                    @enderror
                    @error('state.super_parent_id')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>required!</strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <label class="mb-1" for="username">
                        <strong class="main-register-form-text">{{ __('Username') }}
                            <sup class="main-required">*</sup>
                        </strong>
                    </label>
                    <x-jet-input id="username" wire:model.lazy="state.username" class="block mt-1 w-full  form-control" type="text" name="username" required autocomplete="off"/>
                    @error('state.username')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>required!</strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <label class="mb-1" for="password"><strong class="main-register-form-text">{{ __('Password') }}
                            <sup class="main-required">*</sup></strong>
                    </label>
                    <x-jet-input id="password" wire:model.lazy="state.password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="new-password"/>
                    @error('state.password')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-6 mt-3">
                    <label class="mb-1" for="password_confirmation"><strong class="main-register-form-text">{{ __('Confirm Password') }}
                            <sup class="main-required">*</sup>
                        </strong>
                    </label>
                    <x-jet-input id="password_confirmation" wire:model.lazy="state.password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password"/>
                    @error('state.password_confirmation')
                    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
                    <div class="main-register-from-error-alert">
                        <strong>Required! </strong> {{ $message }}.
                    </div>
                    @enderror
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="relative border rounded-md px-5 py-4 bg-secondary/70 border-secondary/70 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400 dark:text-slate-300 flex items-center mb-2" role="alert">
                        <p class="text-sm">Passwords should contain a minimum of 8 characters, using a mix of uppercase and lowercase letters, numbers, and special characters.</p>
                    </div>
                </div>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="col-lg-12 mt-1">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms" wire:model.lazy="state.terms" required/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms&Conditions').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('disclaimer').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                            @error('state.terms')
                            <div class="main-register-from-error-alert">{{ $message }}</div>
                            @enderror
                        </x-jet-label>
                    </div>
                @endif
                <div class="col-lg-12 mb-4">
                    @include('auth.components.button', ['attribute' => 'wire:click.prevent=register', 'slot' => 'Register'])
                </div>
                <x-jet-validation-errors class="col-lg-12 mb-4 text-danger"/>
            </div>
        </form>
        @push('scripts')
            @include('auth.layouts.js-init-script')
            @if(!$disable_sponsor_modify)
                <script !src="">
                    window.addEventListener("DOMContentLoaded", function () {
                        const __REG_STEP = @this;
                        $("#sponsor").select2({
                            ajax: {
                                url: function (params) {
                                    return APP_URL + '/filter/sponsors/' + params.term;
                                },
                                method: 'POST',
                                dataType: 'json',
                                delay: 1000,
                                processResults: function (data) {
                                    return {
                                        results: data.data
                                    };
                                },
                                cache: true
                            },
                            minimumInputLength: 3,
                            placeholder: 'Select an User',
                            allowClear: true
                        });

                        $(document).on('change', "#sponsor", function (e) {
                            __REG_STEP.set('state.super_parent_id', $(this).val())
                            let selected = e.target.options[e.target.selectedIndex];
                            $(this).empty()
                            $(this).append(selected);
                        })
                    })
                </script>
            @endif
        @endpush
        <div class="new-account mt-3">
            <p>{{ __('Already registered?') }}
                <a class="text-primary" href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
</div>
