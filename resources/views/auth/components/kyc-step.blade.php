<p class="mb-4 text-muted tx-13 ml-0 text-left"> Please note that the KYC details aren't updatable </p>
<div class="col-lg-6 ">
    <label class="mb-1" for="nic" ><strong class="main-register-form-text">{{ __('NIC') }}<sup class="main-required">*</sup></strong></label>
    <x-jet-input id="nic" wire:model.lazy="state.nic" class="block mt-1 w-full form-control" type="text" name="nic" :value="old('nic')" required/>
    @error('state.nic')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-register-from-error-alert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>
<div class="col-lg-6 ">
    <label class="mb-1" for="driving_lc_number" ><strong class="main-register-form-text">{{ __('Driving license number') }}<sup class="main-required">*</sup></strong></label>
    <x-jet-input id="driving_lc_number" wire:model.lazy="state.driving_lc_number" type="text" class="block mt-1 w-full form-control" name="driving_lc_number" :value="old('driving_lc_number')" required/>
    @error('state.driving_lc_number')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-register-from-error-alert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>
<div class="col-lg-6 ">
    <label class="mb-1" for="passport_number" ><strong class="main-register-form-text">{{ __('Passport number') }}<sup class="main-required">*</sup></strong></label>

    <x-jet-input id="passport_number" wire:model.lazy="state.passport_number" type="text" class="block mt-1 w-full form-control" name="passport_number" :value="old('passport_number')" required/>
    @error('state.passport_number')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-register-from-error-alert">
        <strong>required!</strong> {{ $message }}.
      </div>
    @enderror
</div>

@include('auth.components.button', ['attribute' => 'wire:click.prevent=nextStep', 'slot' => 'Next'])
