<div class="mt-4">
    <x-jet-label for="email" value="{{ __('Email') }}"/>
    <x-jet-input id="email" wire:model.lazy="state.email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
    @error('state.email')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

@include('auth.components.button', ['attribute' => 'wire:click.prevent=nextStep', 'slot' => 'Next'])