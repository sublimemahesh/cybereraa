<x-backend.layouts.app>
    @section('title', 'Create | Support Tickets')
    @section('header-title', 'Create Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.support.tickets.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item active">Create New Ticket</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <livewire:user.tickets.create :category="$category"/>
        </div>
    </div>
</x-backend.layouts.app>
