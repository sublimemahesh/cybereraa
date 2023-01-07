<div>
    <table class="table table-striped table-bordered dt-responsive nowrap" id="tickets">
        <thead>
        <tr>
            <th>ACTIONS</th>
            <th>NAME</th>
            <th>COLOR</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($priorities as $priority)
            <tr>
                <td>
                    {{-- @can('update', $priority) --}}
                    <a class="btn btn-xs btn-info" href="{{ route('admin.support.tickets.priority.edit', $priority) }}">
                        Edit
                    </a>
                    {{-- @endcan --}}
                </td>
                <td>{{ $priority->name }}</td>
                <td><span class="badge" style="background-color:{{ $priority->color }}">{{ $priority->color }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
