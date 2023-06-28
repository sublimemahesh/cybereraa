@can('view', $ticket)
    <a class="btn btn-xxs p-1 btn-primary rounded-1" href="{{ route('user.support.tickets.show', $ticket) }}">
        View
    </a>
@endcan
@can('update', $ticket)
    <a class="btn btn-xxs p-1 btn-info rounded-1" href="{{ route('user.support.tickets.edit', $ticket) }}">
        Edit
    </a>
@endcan
@can('reopen', $ticket)
    <a class="btn btn-xxs p-1 btn-secondary reopen-ticket rounded-1" data-id="{{ $ticket->id }}">
        Open
    </a>
@endcan
@can('close', $ticket)
    <a class="btn btn-xxs p-1 btn-danger close-ticket rounded-1" data-id="{{ $ticket->id }}">
        Close
    </a>
@endcan
@can('delete', $ticket)
    <a class="btn btn-xxs p-1 btn-danger delete-ticket rounded-1" data-id="{{ $ticket->id }}" href="javascript:void(0)">
        Delete
    </a>
@endcan
