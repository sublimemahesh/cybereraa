<x-backend.layouts.app>
    @section('title', 'Blogs | CMS')
    @section('header-title', 'Blogs | CMS' )
    @section('styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Blogs</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.blogs.save/>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="tickets">
                        <thead>
                        <tr>
                            <th>ACTIONS</th>
                            <th>TITLE</th>
                            <th>SLUG</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>
                                    {{-- @can('update', $blog) --}}
                                    <a class="btn btn-xxs btn-info" href="{{ route('admin.blogs.edit', $blog) }}">Edit</a>
                                    <a class="btn btn-xxs btn-danger delete-blog" data-blog="{{ $blog->id }}" href="javascript:void(0)">Delete</a>
                                    {{-- @endcan --}}
                                </td>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->slug }}</td>
                                <td>{{ $blog->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
        <script>
            $(document).on("click", ".delete-blog", function (e) {
                e.preventDefault();
                __this = $(this);
                let blog_id = $(this).data("blog");
                Swal.fire({
                    title: "Are You Sure?",
                    text: "Are you want to delete this blog?",
                    icon: "warning",
                    showCancelButton: true,
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        loader()
                        axios.delete(`${APP_URL}/admin/blogs/${blog_id}`)
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

