<x-backend.layouts.app>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">

        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('title', __('Account Settings'))
    @section('header-title', __('Account Settings'))

    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Account Settings</li>
    @endsection

    <div class="row">


        <div class="col-xl-9 col-lg-8">

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-profile-information')
                </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password')
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures() &&
            \App\Models\User::whereRelation('roles', 'name', 'user')->where('id', Auth::user()->id)
            ->whereDoesntHave('transactions', fn($q) => $q->where('status', 'PENDING'))
            ->whereDoesntHave('purchasedPackages')->exists())

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>

    @push('scripts')

        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    @endpush

</x-backend.layouts.app>
