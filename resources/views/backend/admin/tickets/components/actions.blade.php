<div class="d-flex flex-wrap">
    @can('view', $ticket)
        <a class="btn btn-xxs p-1 btn-primary" href="{{ route('admin.support.tickets.show', $ticket) }}">
            View
        </a>
    @endcan
    @can('close', $ticket)
        <a class="btn btn-xxs p-1 btn-danger close-ticket" data-id="{{ $ticket->id }}">
            Close
        </a>
    @endcan
    @can('reopen', $ticket)
        <a class="btn btn-xxs p-1 btn-secondary reopen-ticket" data-id="{{ $ticket->id }}">
            Open
        </a>
    @endcan
    @can('lowPriority', $ticket)
        <a class="btn btn-xxs p-1 btn-secondary priority-ticket" data-priority="low" data-id="{{ $ticket->id }}">
            Low
        </a>
    @endcan
    @can('mediumPriority', $ticket)
        <a class="btn btn-xxs p-1 btn-secondary priority-ticket" data-priority="medium" data-id="{{ $ticket->id }}">
            Medium
        </a>
    @endcan
    @can('highPriority', $ticket)
        <a class="btn btn-xxs p-1 btn-secondary priority-ticket" data-priority="high" data-id="{{ $ticket->id }}">
            High
        </a>
    @endcan
    @can('update', $ticket)
        <a class="btn btn-xxs p-1 btn-info" href="{{ route('support.tickets.edit', $ticket) }}">
            Edit
        </a>
    @endcan
    @can('delete', $ticket)
        <a class="btn btn-xxs p-1 btn-danger delete-ticket" data-id="{{ $ticket->id }}" href="javascript:void(0)">
            Delete
        </a>
    @endcan
</div>
