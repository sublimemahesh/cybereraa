<div class="col-lg-6  mt-4">
    <label class="mb-1" for="nic" ><strong>{{ __('NIC') }}<sup class="main-required">*</sup></strong></label>
    <x-jet-input id="nic" wire:model.lazy="state.nic" class="block mt-1 w-full form-control" type="text" name="nic" :value="old('nic')" required/>
    @error('state.nic')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-registerfromErroAlert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>
<div class="col-lg-6  mt-4">
    <label class="mb-1" for="driving_lc_number" ><strong>{{ __('Driving license number') }}<sup class="main-required">*</sup></strong></label>
    <x-jet-input id="driving_lc_number" wire:model.lazy="state.driving_lc_number" type="text" class="block mt-1 w-full form-control" name="driving_lc_number" :value="old('driving_lc_number')" required/>
    @error('state.driving_lc_number')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-registerfromErroAlert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>
<div class="col-lg-6  mt-4">
    <label class="mb-1" for="passport_number" ><strong>{{ __('Passport number') }}<sup class="main-required">*</sup></strong></label>

    <x-jet-input id="passport_number" wire:model.lazy="state.passport_number" type="text" class="block mt-1 w-full form-control" name="passport_number" :value="old('passport_number')" required/>
    @error('state.passport_number')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-registerfromErroAlert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>

@include('auth.components.button', ['attribute' => 'wire:click.prevent=nextStep', 'slot' => 'Next'])