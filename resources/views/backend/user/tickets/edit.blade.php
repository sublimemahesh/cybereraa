<x-backend.layouts.app>
    @section('title', 'Edit | Support Tickets')
    @section('header-title', 'Edit Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.support.tickets.index') }}">Tickets</a>
        </li>
        <li class="breadcrumb-item active">Edit Ticket</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <livewire:user.tickets.create :ticket="$ticket" :edit="true"/>
        </div>
    </div>
</x-backend.layouts.app>
