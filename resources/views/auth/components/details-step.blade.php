<div>
    <x-jet-label for="name" value="{{ __('Name') }}"/>
    <x-jet-input id="name" wire:model.lazy="state.name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
    @error('state.name')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

@include('auth.components.button', ['attribute' => 'wire:click.prevent=nextStep', 'slot' => 'Next'])