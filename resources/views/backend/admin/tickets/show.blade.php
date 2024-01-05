<x-backend.layouts.app>
    @section('title', 'View | Reply | Support Tickets')
    @section('header-title', 'View | Reply | Support Tickets' )
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.support.tickets.index') }}">Support Tickets</a>
        </li>
        <li class="breadcrumb-item active">View Ticket</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card">
                    <div class="card-header">
                        Show Tickets
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="mb-2">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $ticket->id }}</td>
                                </tr>
                                <tr>
                                    <th>Created at</th>
                                    <td>{{ $ticket->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td>{{ $ticket->subject }}</td>
                                </tr>
                                <tr>
                                    <th>Body</th>
                                    <td><p class="pre-txt">{!! $ticket->body !!}</p></td>
                                </tr>
                                <tr>
                                    <th>Attachments</th>
                                    <td>
                                        @if (!empty($reply->attachment))
                                            <img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png"/>
                                            <a href="{{ storage('uploads/tickets/' . $ticket->attachment) }}" target="blank">
                                                View File {{ $ticket->attachment }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $ticket->status->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Priority</th>
                                    <td>{{ $ticket->priority->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $ticket->category->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Replies</th>
                                    <td>
                                        <livewire:user.tickets.reply :ticket="$ticket"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <a class="btn-dark btn-xs btn-rounded my-2 text-white" href="{{ route('admin.support.tickets.index') }}"> Back to list</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/tickets/index.js') }}"></script>
    @endpush
</x-backend.layouts.app>
