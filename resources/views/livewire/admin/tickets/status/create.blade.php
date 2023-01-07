<div>
    <table class="table table-striped table-bordered dt-responsive nowrap" id="statuses">
        <thead>
        <tr>
            <th>ACTIONS</th>
            <th>NAME</th>
            <th>COLOR</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($statuses as $status)
            <tr>
                <td>
                    {{-- @can('update', $status) --}}
                    <a class="btn btn-xs btn-info" href="{{ route('admin.support.tickets.status.edit', $status) }}">
                        Edit
                    </a>
                    {{-- @endcan --}}
                </td>
                <td>{{ $status->name }}</td>
                <td><span class="badge" style="background-color:{{ $status->color }}">{{ $status->color }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
