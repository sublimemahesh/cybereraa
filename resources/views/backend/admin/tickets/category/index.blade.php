<x-backend.layouts.app>
    @section('title', 'Categories | Support Tickets')
    @section('header-title', 'Categories | Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Tickets Categories</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.tickets.category.create/>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>