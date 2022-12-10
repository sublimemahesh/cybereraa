<div class="mt-4">
    <x-jet-label for="nic" value="{{ __('NIC') }}"/>
    <x-jet-input id="nic" wire:model.lazy="state.nic" class="block mt-1 w-full" type="text" name="nic" :value="old('nic')" required/>
    @error('state.nic')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>
<div class="mt-4">
    <x-jet-label for="driving_lc_number" value="{{ __('Driving license number') }}"/>
    <x-jet-input id="driving_lc_number" wire:model.lazy="state.driving_lc_number" type="text" class="block mt-1 w-full" name="driving_lc_number" :value="old('driving_lc_number')" required/>
    @error('state.driving_lc_number')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>
<div class="mt-4">
    <x-jet-label for="passport_number" value="{{ __('Passport number') }}"/>
    <x-jet-input id="passport_number" wire:model.lazy="state.passport_number" type="text" class="block mt-1 w-full" name="passport_number" :value="old('passport_number')" required/>
    @error('state.passport_number')
    <div class="text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

@include('auth.components.button', ['attribute' => 'wire:click.prevent=nextStep', 'slot' => 'Next'])