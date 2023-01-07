<x-backend.layouts.app>
    @section('title', 'Edit Categories | Support Tickets')
    @section('header-title', 'Edit Categories | Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.support.tickets.category.create') }}">Tickets Categories</a>
        </li>
        <li class="breadcrumb-item active">Edit Category</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.tickets.category.edit :category="$category"/>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>