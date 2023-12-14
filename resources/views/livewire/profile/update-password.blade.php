<div class="col-xl-9 col-lg-9">
    <div class="card profile-card card-bx m-b30">
        <div class="card-header">
            <h6 class="title">{{ __('Update Password') }}</h6>
        </div>
        <form class="profile-form" wire:submit.prevent="{{'updatePassword'}}">
            <div class="card-body">
                <div class="row" name="form">
                    <div class="col-sm-12 m-b30">
                        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                        <input type="password" id="current_password" class="form-control"
                               wire:model.defer="state.current_password" autocomplete="current-password">
                        <x-jet-input-error for="current_password" class="mt-2"/>
                    </div>

                    <div class="col-sm-12 m-b30">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <input type="password" id="password" class="form-control"
                               wire:model.defer="state.password" autocomplete="new-password">
                        <x-jet-input-error for="password" class="mt-2"/>
                    </div>

                    <div class="col-sm-12 m-b30">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password_confirmation" class="form-control"
                               wire:model.defer="state.password_confirmation" autocomplete="new-password">
                        <x-jet-input-error for="password_confirmation" class="mt-2"/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div name="actions" class="col-lg-6 m-b30">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>
                    @if(!$otpSent)
                        <p>
                            OTP code will be sent to Email: {{ App\Traits\MaskCredentials::maskedEmailAddress(auth()->user()->email) }}
                           {{-- @if(str_starts_with(auth()->user()?->phone, '+94'))
                                and Phone: {{ App\Traits\MaskCredentials::maskedPhone(auth()->user()->phone) }}
                            @endif--}}
                        </p>
                        <br>
                        <div id="2ft-section">
                            <button type="submit" wire:click="sendOTP" id="send-2ft-code" class="btn btn-sm btn-google mb-2">
                                Send Verification Code
                            </button>
                        </div>
                    @else
                        <div class="mb-3 mt-2">
                            <label for="otp">OTP Code </label>
                            <input id="otp" type="text" wire:model.lazy="otp" class="block mt-1 w-full form-control" autocomplete="one-time-password" placeholder="OTP code">
                            <div class="text-info cursor-pointer" wire:click="sendOTP" id="send-2ft-code">Resend OTP</div>
                            @error('otp')
                            <div class="mr-3 text-sm text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
