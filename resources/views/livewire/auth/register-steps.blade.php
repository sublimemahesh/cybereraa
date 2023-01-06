<div x-data="{
    currentStep: @entangle('step').defer,
    stepName: [
        'Basic user details',
        'KYC Details <p class=\'mb-4 text-gray-500 text-sm\'>Please note that the KYC details aren\'t updatable</p>',
        'PLACEMENT & FINISH'
    ]
}">
    {{-- <x-jet class="mb-4" /> --}}
    <form>
        @csrf
        {{-- <nav class="-mb-px flex space-x-2 nav nav-wizard" aria-label="Tabs">
            <div :class="currentStep == 1 ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-2 px-2 border-b-2 font-medium text-sm ">
                <span>DETAILS</span>
            </div>
            <div :class="currentStep == 2 ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-2 px-2 border-b-2 font-medium text-sm">
                <span>KYC</span>
            </div>
            <div :class="currentStep == 3 ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-2 px-2 border-b-2 font-medium text-sm">
                <span>PLACEMENT & FINISH</span>
            </div>
        </nav>
        <div class="mb-6">
            <h1 x-html="stepName[currentStep - 1]"></h1>
            <div class="text-xs text-under text-gray-400 cursor-pointer" x-show="currentStep > 1"
                wire:click="previousStep">⬅ Previous</div>  id="nav-wizard"
        </div> --}}


        <div class="form-wizard order-create sw sw-theme-default sw-justified">
            <ul class="nav nav-wizard"  id="nav-wizard">
                <li>
                    <a :class="currentStep == 1 ? 'active' : 'inactive'" class="nav-link" href="#wizard_Service">
                        <span>1</span>
                    </a>
                </li>
                <li>
                    <a :class="currentStep == 2 ? 'active' : 'inactive'" class="nav-link" href="#wizard_Time">
                        <span>2</span>
                    </a>
                </li>
                <li>
                    <a :class="currentStep == 3 ? 'active' : 'inactive'" class="nav-link" href="#wizard_Details">
                        <span>3</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="row  main-registerfrom">
            @if ($step === 1)
                @include('auth.components.details-step')
            @elseif($step === 2)
                @include('auth.components.kyc-step')
            @elseif($step === 3)
                @include('auth.components.placement-step')
            @endif
        </div>
    </form>


</div>
