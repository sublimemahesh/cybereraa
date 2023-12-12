<div class="col-xl-12 col-lg-12">
    <form class="profile-form" wire:submit.prevent="{{ 'updateProfileInformation' }}">


        <div class="card">
         
            <div class="card-body" id="nav-txt-color">
                <!-- Nav tabs -->
                <div class="default-tab" x-data="{ activeTab: 'home' }">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item nav-item-mr nav-item-li-width">
                            <a class="nav-link text-center" data-bs-toggle="tab" :class="{ 'active': activeTab === 'home' }" @click="activeTab = 'home'" href="#home">
                                Profile Photo
                            </a>
                        </li>
                        <li class="nav-item nav-item-ml nav-item-mr nav-item-li-width">
                            <a class="nav-link text-center" data-bs-toggle="tab" :class="{ 'active': activeTab === 'profile' }" @click="activeTab = 'profile'" href="#profile">
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item nav-item-ml nav-item-mr nav-item-li-width">
                            <a class="nav-link text-center" data-bs-toggle="tab" :class="{ 'active': activeTab === 'contact' }" @click="activeTab = 'contact'" href="#contact">
                                Contact Details
                            </a>
                        </li>
                        <li class="nav-item nav-item-ml nav-item-li-width">
                            <a class="nav-link text-center" data-bs-toggle="tab" :class="{ 'active': activeTab === 'payment' }" @click="activeTab = 'payment'" href="#payment">
                                Payment details
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade show" :class="{ 'show active': activeTab === 'home' }" id="home" role="tabpanel">
                            <div class="pt-4">
                                <div class="row" name="form">
                                    <div class="col-sm-12 m-b30">
                                        <!-- Profile Photo -->
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <div x-data="{ photoName: null, photoPreview: null }"
                                                 class="col-span-6 sm:col-span-4">
                                                <!-- Profile Photo File Input -->
                                                <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                                                       x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                               "/>
                                                <!-- Current Profile Photo -->
                                                <div class="mt-2" x-show="! photoPreview">
                                                    <img src="{{ $this->user->profile_photo_url }}"
                                                         alt="{{ $this->user->name }}"
                                                         class="rounded-full h-20 w-20 object-cover">


                                                    <x-jet-secondary-button class="mt-2 mr-2 btn-m" type="button"
                                                                            x-on:click.prevent="$refs.photo.click()">
                                                        {{ __('Select A New Photo') }}
                                                    </x-jet-secondary-button>

                                                    @if ($this->user->profile_photo_path)
                                                        <x-jet-secondary-button type="button" class="mt-2 btn-m2"
                                                                                wire:click="deleteProfilePhoto">
                                                            {{ __('Remove Photo') }}
                                                        </x-jet-secondary-button>
                                                    @endif

                                                </div>

                                                <!-- New Profile Photo Preview -->
                                                <div class="mt-2" x-show="photoPreview" style="display: none;">
                                                <span
                                                    class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                                </span>
                                                </div>

                                                <x-jet-input-error for="photo" class="mt-2"/>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'profile' }" id="profile">
                            <div class="pt-4">
                                <div class="row" name="form">
                                    @if ($this->user->super_parent_id !== null)
                                        <div class="col-sm-6 m-b30 mt-2">
                                            <label class="form-label" for="sponsor">{{ __('Sponsor') }}</label>
                                            <div class="form-control">#{{ $this->user->super_parent_id }}:
                                                {{ $this->user->sponsor->name }}
                                                - {{ $this->user->sponsor->username }}</div>
                                        </div>
                                    @endif
                                    <div class="col-sm-6 m-b30 mt-2">
                                        <label class="form-label" for="name">{{ __('Name') }}</label>
                                        @if (auth()->user()->profile->is_kyc_verified)
                                            <div class="form-control">{{ $state['name'] }}</div>
                                        @else
                                            <input type="text" id="name" class="form-control" wire:model.defer="state.name"
                                                   autocomplete="name">
                                        @endif
                                        <x-jet-input-error for="name" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-6 m-b30 mt-2" wire:ignore>
                                        <label class="form-label" for="phone">{{ __('Phone') }}</label>
                                        <input type="text" id="phone" class="form-control"
                                               wire:model.defer="state.phone">
                                        {{-- <div class="form-control">{{ $state['phone'] }}</div> --}}
                                        <x-jet-input-error for="phone" class="mt-2"/>
                                    </div>
                                    <div class="col-sm-6 m-b30 mt-2">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input type="text" id="email" class="form-control"
                                               wire:model.defer="state.email">
                                        <x-jet-input-error for="email" class="mt-2"/>
                                        @if (
                                        !$this->user->hasVerifiedEmail() &&
                                        Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()))
                                            <p class="text-sm mt-2">
                                                {{ __('Your email address is unverified.') }}

                                                <button type="button"
                                                        class="underline text-sm text-gray-600 hover:text-gray-900"
                                                        wire:click.prevent="sendEmailVerification">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if ($this->verificationLinkSent)
                                                <p v-show="verificationLinkSent"
                                                   class="mt-2 font-medium text-sm text-green-600">
                                                    {{ __('A new verification link has been sent to your email
                                                    address.') }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <div>
                                            <label class="form-label" for="dob">{{ __('Birth Day') }}</label>
                                            <x-jet-input wire:ignore id="dob" wire:model.defer="state.profile_info.dob"
                                                         class="bday-mask block mt-1 w-full form-control" type="text"
                                                         name="dob" autofocus autocomplete="dob"/>
                                            <x-jet-input-error for="profile_info.dob" class="mt-2"/>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="gender">{{ __('Gender') }}</label>
                                        <select id="gender" wire:model.defer="state.profile_info.gender"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm  form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <x-jet-input-error for="profile_info.gender" class="mt-2"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'contact' }" id="contact">
                            <div class="pt-4">
                                <div class="row" name="form">
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="street">{{ __('Address Line 01')
                                            }}</label>
                                        <x-jet-input id="street" wire:model.defer="state.profile_info.street"
                                                     class="block mt-1 w-full form-control" type="text" name="street" autofocus
                                                     autocomplete="street"/>
                                        <x-jet-input-error for="profile_info.street" class="mt-2"/>
                                    </div>
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="state">{{ __('City') }}</label>
                                        <x-jet-input id="state" wire:model.defer="state.profile_info.state"
                                                     class="block mt-1 w-full form-control" type="text" name="state" autofocus
                                                     autocomplete="state"/>
                                        <x-jet-input-error for="profile_info.state" class="mt-2"/>
                                    </div>
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="address">{{ __('State') }}</label>
                                        <x-jet-input id="address" wire:model.defer="state.profile_info.address"
                                                     class="block mt-1 w-full form-control" type="text" name="address" autofocus
                                                     autocomplete="address"/>
                                        <x-jet-input-error for="profile_info.address" class="mt-2"/>
                                    </div>
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="zip_code">{{ __('Zip Code')
                                            }}</label>
                                        <x-jet-input id="zip_code" wire:model.defer="state.profile_info.zip_code"
                                                     class="block mt-1 w-full form-control" type="number"
                                                     name="zip_code" autofocus autocomplete="zip_code"/>
                                        <x-jet-input-error for="profile_info.zip_code" class="mt-2"/>
                                    </div>

                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="recover_email">
                                            {{ __('Recover Email') }}
                                        </label>
                                        <x-jet-input id="recover_email"
                                                     wire:model.defer="state.profile_info.recover_email"
                                                     class="block mt-1 w-full form-control" type="email" name="recover_email"/>
                                        <x-jet-input-error for="profile_info.recover_email" class="mt-2"/>
                                    </div>

                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="home_phone"> {{ __('Recover Phone')
                                            }}
                                        </label>
                                        <x-jet-input id="home_phone" wire:model.defer="state.profile_info.home_phone"
                                                     class="block mt-1 w-full form-control" type="text"
                                                     name="home_phone"/>
                                        <x-jet-input-error for="profile_info.home_phone" class="mt-2"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'payment' }" id="payment">
                            <div class="pt-4">
                                <div class="row" name="form">
                                    {{-- <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="binance_email"> {{ __('TRC20  Email') }}
                                        </label>
                                        <x-jet-input id="binance_email"
                                                     wire:model.defer="state.profile_info.binance_email"
                                                     class="block mt-1 w-full form-control" type="email" name="binance_email"/>
                                        <x-jet-input-error for="profile_info.binance_email" class="mt-2"/>
                                    </div> --}}
                                    {{-- <div class="col-lg-6 m-b30">
                                        <label class="form-label" for="binance_id"> {{ __('TRC20  Id') }}
                                        </label>
                                        <x-jet-input id="binance_id" wire:model.defer="state.profile_info.binance_id"
                                                     class="block mt-1 w-full form-control" type="text" name="binance_id"/>
                                        <x-jet-input-error for="profile_info.binance_id" class="mt-2"/>
                                    </div> --}}
                                    {{-- <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="binance_phone"> {{ __('TRC20  Phone') }}
                                        </label>
                                        <x-jet-input id="binance_phone"
                                                     wire:model.defer="state.profile_info.binance_phone"
                                                     class="block mt-1 w-full form-control" type="text" name="binance_phone"/>
                                        <x-jet-input-error for="profile_info.binance_phone" class="mt-2"/>
                                    </div> --}}
                                    <div class="col-lg-6 m-b30 mt-2">
                                        <label class="form-label" for="wallet_address"> {{ __('TRC20 Wallter Address') }}
                                        </label>
                                        <x-jet-input id="wallet_address"
                                                     wire:model.defer="state.profile_info.wallet_address"
                                                     class="block mt-1 w-full form-control" type="text" name="wallet_address"/>
                                        <x-jet-input-error for="profile_info.wallet_address" class="mt-2"/>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <div class="card-footer">
                <div class="row">
                    <div name="actions" class="col-lg-12 m-b30">
                        <x-jet-action-message class="mr-3" on="saved">
                            {{ __('Saved.') }}
                        </x-jet-action-message>
                        @if (!$otpSent)
                            <p>
                                OTP code will be sent to Email: {{ $state['email'] }}
                                @if (str_starts_with(auth()->user()?->phone, '+94'))
                                    and Phone: {{ $state['phone'] }}
                                @endif
                            </p>
                            <br>
                            <div id="2ft-section">
                                <button type="submit" wire:click="sendOTP" class="btn btn-sm btn-google mb-2">
                                    Send Verification Code
                                </button>
                            </div>
                        @else
                            <div class="mb-3 mt-2">
                                <label for="otp">OTP Code</label>
                                <input id="otp" type="text" wire:model.lazy="otp" class="block mt-1 w-full form-control"
                                       autocomplete="one-time-password" placeholder="OTP code">
                                <div class="text-info cursor-pointer" wire:click="sendOTP">Resend OTP</div>
                                @error('otp')
                                <div class="mr-3 text-sm text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                                {{ __('Save') }}
                            </button>
                        @endif
                    </div>
                    <div class="col-lg-12 m-b30">
                        <x-jet-validation-errors/>
                    </div>
                </div>
            </div>
        </div>


    </form>
    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
        <script !src="">
            window.addEventListener('DOMContentLoaded', (event) => {
                $('.bday-mask').mask('0000-00-00', {
                    onComplete: function (cep) {
                        console.log('cep changed! ', cep);
                    }
                    , placeholder: "YYYY-MM-DD"
                    , selectOnFocus: true
                });

                const __REG_STEP = @this;
                let itl_phone

                function init(phone_iso = 'lk') {
                    itl_phone && itl_phone.destroy();

                    try {
                        return intlTelInput.intlTelInput(document.querySelector("#phone"), {
                            initialCountry: phone_iso
                            , formatOnDisplay: false,
                            //allowDropdown: false,
                            autoPlaceholder: 'aggressive'
                        })
                    } catch (e) {
                        console.log(e.message)
                        return init('lk')
                    }
                }

                itl_phone = init()

                document.querySelector("#phone").addEventListener('change', function (e) {
                    let countryData = itl_phone.getSelectedCountryData();
                    let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                    if (itl_phone.isValidNumber()) {
                        __REG_STEP.set('state.phone', phone);
                    } else {
                        //__REG_STEP.set('state.phone', null);
                        Toast.fire({
                            icon: 'error'
                            , title: "Invalid number!"
                            ,
                        })
                    }
                    console.log('phone: change: ', countryData)
                })
                document.getElementById("phone").addEventListener("close:countrydropdown", function () {
                    let countryData = itl_phone.getSelectedCountryData();
                    let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                    __REG_STEP.set('state.phone', null);
                    console.log('countryChange: phone_iso: ', countryData)
                });

                Livewire.hook('element.updated', (message, component) => {
                    //console.log(component.serverMemo.data)
                    try {
                        document.querySelector("#phone").value = component.serverMemo.data.state.phone;
                    } catch (e) {

                    }
                });
            });

        </script>
    @endpush
</div>


