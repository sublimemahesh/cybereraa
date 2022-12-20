<x-backend.layouts.app>
    @section('styles')
        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('title', __('API Tokens'))
    @section('header-title', __('API Tokens'))

    @section('breadcrumb-items')
        <li class="breadcrumb-item active">API Tokens</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        @livewire('api.api-token-manager')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-backend.layouts.app>
