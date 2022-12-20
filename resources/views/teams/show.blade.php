<x-backend.layouts.app>
    @section('styles')
        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('title', __('Team Settings'))
    @section('header-title', __('Team Settings'))

    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Team Settings</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        @livewire('teams.update-team-name-form', ['team' => $team])

                        @livewire('teams.team-member-manager', ['team' => $team])

                        @if (Gate::check('delete', $team) && ! $team->personal_team)
                            <x-jet-section-border/>

                            <div class="mt-10 sm:mt-0">
                                @livewire('teams.delete-team-form', ['team' => $team])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-backend.layouts.app>
