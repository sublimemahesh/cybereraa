<div class="mt-4">
    <x-jet-label for="sponsor" value="{{ __('Sponsor username') }}"/>
    <x-jet-input id="sponsor" wire:model.lazy="state.sponsor" class="block mt-1 w-full" type="text" name="sponsor" required autocomplete="sponsor"/>
    @if(!empty($sponsor->name))
        <div class="text-sm text-green-600">{{ $sponsor->name }}</div>
    @endif
    @error('state.sponsor')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <x-jet-label for="username" value="{{ __('Nominated Username') }}"/>
    <x-jet-input id="username" wire:model.lazy="state.username" class="block mt-1 w-full" type="text" name="username" required autocomplete="username"/>
    @error('state.username')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>
<div class="mt-4">
    <x-jet-label for="position" value="{{ __('Position') }}"/>
    <select id="position" wire:model.lazy="state.position" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <option value="">Select Position</option>
        <option value="right">Right</option>
        <option value="left">Left</option>
    </select>
    @error('state.position')
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