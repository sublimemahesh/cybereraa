<x-backend.layouts.app>
    @section('title', 'Edit Priorities | Support Tickets')
    @section('header-title', 'Edit Priorities | Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.support.tickets.priority.create') }}">Tickets Priorities</a>
        </li>
        <li class="breadcrumb-item active">Edit Category</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.tickets.priority.edit :priority="$priority"/>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>