<div class=" col-lg-6 mt-4">
    <label class="mb-1" for="sponsor"><strong class="main-registerFormText">{{ __('Sponsor username') }}
            <sup class="main-required">*</sup></strong></label>
    <x-jet-input id="sponsor" wire:model.lazy="state.sponsor" class="block mt-1 w-full  form-control" type="text" name="sponsor" required autocomplete="sponsor"/>
    @if(!empty($sponsor->name))
        <div class="pt-2 px-1 text-success">
            <strong>Sponsor Details:</strong>  {{ $sponsor->username }} - {{ $sponsor->name }}
        </div>
    @endif
    @error('state.sponsor')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-registerfromErroAlert">
        <strong>required!</strong> {{ $message }}.
    </div>
    @enderror
</div>

<div class="col-lg-6 mt-4">
    <label class="mb-1" for="username"><strong class="main-registerFormText">{{ __('Nominated Username') }}<sup class="main-required">*</sup></strong></label>
    <x-jet-input id="username" wire:model.lazy="state.username" class="block mt-1 w-full  form-control" type="text" name="username" required autocomplete="off" />
    @error('state.username')
    {{-- <div class="text-sm text-red-600">{{ $message }}</div> --}}
    <div class="main-registerfromErroAlert">
        <strong>required!</strong> {{ $message }}.
    </div>
    @enderror
</div>
@if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
    <div class="col-lg-12 mt-4">
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