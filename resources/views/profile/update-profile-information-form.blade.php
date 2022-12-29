<div class="col-xl-12 col-lg-12">
    <div class="card profile-card card-bx m-b30">
        <div class="card-header">
            <h6 class="title"> {{ __('Profile Information') }}</h6>
        </div>
        <form class="profile-form" wire:submit.prevent="{{ 'updateProfileInformation' }}">
            <div class="card-body">
                <div class="row" name="form">
                    <div class="col-sm-12 m-b30">
                        <!-- Profile Photo -->
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                                <!-- Profile Photo File Input -->
                                <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                                    x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                               " />
                                <label for="photo" class="form-label" for="name">{{ __('Photo') }}</label>
                                <!-- Current Profile Photo -->
                                <div class="mt-2" x-show="! photoPreview">
                                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                                        class="rounded-full h-20 w-20 object-cover">
                                </div>

                                <!-- New Profile Photo Preview -->
                                <div class="mt-2" x-show="photoPreview" style="display: none;">
                                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                    </span>
                                </div>

                                <x-jet-secondary-button class="mt-2 mr-2" type="button"
                                    x-on:click.prevent="$refs.photo.click()">
                                    {{ __('Select A New Photo') }}
                                </x-jet-secondary-button>

                                @if ($this->user->profile_photo_path)
                                    <x-jet-secondary-button type="button" class="mt-2"
                                        wire:click="deleteProfilePhoto">
                                        {{ __('Remove Photo') }}
                                    </x-jet-secondary-button>
                                @endif

                                <x-jet-input-error for="photo" class="mt-2" />
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6 m-b30">
                        <label class="form-label" for="name">{{ __('Name') }}</label>
                        <input type="text" id="name" class="form-control" wire:model.defer="state.name"
                            autocomplete="name">
                        <span for="name"></span>
                    </div>
                    <div class="col-sm-6 m-b30">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control" wire:model.defer="state.email">
                        <span for="email"></span>

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                            !$this->user->hasVerifiedEmail())
                            <p class="text-sm mt-2">
                                {{ __('Your email address is unverified.') }}

                                <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900"
                                    wire:click.prevent="sendEmailVerification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if ($this->verificationLinkSent)
                                <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>
                    <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
