<div class="mt-4">
    <x-jet-label for="password" value="{{ __('Password') }}"/>
    <x-jet-input id="password" wire:model.lazy="state.password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
    @error('state.password')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
    <x-jet-input id="password_confirmation" wire:model.lazy="state.password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"/>
    @error('state.password_confirmation')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

@if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
    <div class="mt-4">
        <x-jet-label for="terms">
            <div class="flex items-center">
                <x-jet-checkbox name="terms" id="terms" wire:model.lazy="state.terms" required/>

                <div class="ml-2">
                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                    ]) !!}
                </div>
            </div>
            @error('state.terms')
            <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </x-jet-label>
    </div>
@endif

@include('auth.components.button', ['attribute' => 'wire:click.prevent=register', 'slot' => 'Register'])