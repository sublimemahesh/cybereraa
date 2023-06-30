<x-backend.layouts.app>
    @section('title', 'Popup Notices | CMS')
    @section('header-title', 'Popup Notices | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Popup Notices</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.popups.save/>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>ACTIONS</th>
                                <th>TITLE</th>
                                <th>IS ACTIVE</th>
                                <th>START</th>
                                <th>END</th>
                                <th>LAST MODIFIED</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($popups as $popup)
                                <tr>
                                    <td class="py-2">
                                        @can('update', $popup)
                                            <a class="btn btn-xxs btn-info" href="{{ route('admin.popup-notices.edit', $popup) }}">Edit</a>
                                        @endcan
                                        @can('delete', $popup)
                                            <a class="btn btn-xxs btn-danger delete-popup" data-popup="{{ $popup->id }}" href="javascript:void(0)">Delete</a>
                                        @endcan
                                    </td>
                                    <td>{{ $popup->title }}</td>
                                    <td>{{ $popup->is_active ? 'ACTIVE': 'INACTIVE' }}</td>
                                    <td>{{ $popup->start_date }}</td>
                                    <td>{{ $popup->end_date }}</td>
                                    <td>{{ $popup->updated_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
        <script>
            $(document).on("click", ".delete-popup", function (e) {
                e.preventDefault();
                __this = $(this);
                let popup_id = $(this).data("popup");
                Swal.fire({
                    title: "Are You Sure?",
                    text: "Are you want to delete this popup?",
                    icon: "warning",
                    showCancelButton: true,
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        loader()
                        axios.delete(`${APP_URL}/admin/popup-notices/${popup_id}`)
                            .then(response => {
                                Toast.fire({
                                    icon: response.data.icon, title: response.data.message,
                                }).then(res => {
                                    if (response.data.status) {
                                        location.reload();
                                    }
                                })
                            }).catch((error) => {
                            Toast.fire({
                                icon: 'error',
                                title: error.response.data.message || "Something went wrong!",
                            })
                            console.error(error.response.data)
                        })
                    }
                });
            });
        </script>
    @endpush
</x-backend.layouts.app>

