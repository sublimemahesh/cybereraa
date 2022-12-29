<div class="col-xl-12 col-lg-12">
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
                            <x-jet-input-error for="current_password" class="mt-2" />
                    </div>

                    <div class="col-sm-12 m-b30">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <input type="password" id="password" class="form-control"
                            wire:model.defer="state.password" autocomplete="new-password">
                            <x-jet-input-error for="password" class="mt-2" />
                    </div>

                    <div class="col-sm-12 m-b30">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password_confirmation" class="form-control"
                            wire:model.defer="state.password_confirmation" autocomplete="new-password">
                            <x-jet-input-error for="password_confirmation" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <button class="btn btn-primary">
                        {{ __('Save') }}
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>
