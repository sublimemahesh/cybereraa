<div class="col-xl-12 col-lg-12">
    <div class="card card-bx m-b30">
        <div class="card-header">
            <h6 class="title"> {{ __('Delete Account') }}</h6>
        </div>

        <div class="card-body">
            <div>
                {{ __('Permanently delete your account.') }}
            </div>
            <div name="content">
                <div class="max-w-xl text-sm text-gray-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </div>

                @error('account')
                <div class="alert alert-danger mt-2">
                    {{ $message  }}
                </div>
                @enderror

                <!-- Delete User Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingUserDeletion">
                    <x-slot name="title">
                        {{ __('Delete Account') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                            <x-jet-input type="password" class="mt-1 block w-3/4 form-control"
                                         placeholder="{{ __('Password') }}"
                                         x-ref="password"
                                         wire:model.defer="password"
                                         wire:keydown.enter="deleteUser"/>

                            <x-jet-input-error for="password" class="mt-2"/>
                            <x-jet-input-error for="account" class="mt-2"/>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        <x-jet-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                            {{ __('Delete Account') }}
                        </x-jet-danger-button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        </div>
        <div class="card-footer">
            <x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-jet-danger-button>
        </div>
    </div>
</div>
