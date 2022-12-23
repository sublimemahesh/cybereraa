<x-backend.layouts.app>
    @section('title', 'Pages | CMS')
    @section('header-title', 'Pages | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        @if(!is_null($parent->id))
            <li class="breadcrumb-item">
                <a href="{{ route('admin.pages.index') }}">Pages</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ URL::signedRoute('admin.sections.index', ['page' => $parent->slug]) }}">{{ $parent->title }} Page</a>
            </li>
        @endif
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.pages.save :parent="$parent"/>
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
                            @if(is_null($parent->id))
                                <th>CHILDREN COUNT</th>
                            @endif
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td class="py-2">
                                    {{-- @can('update', $page) --}}
                                    <a class="btn btn-xxs btn-info" href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                                    @if(is_null($page->parent_id))
                                        <a class="btn btn-xxs btn-success" href="{{ URL::signedRoute('admin.sections.index', ['page' => $page->slug]) }}">Section</a>
                                    @endif
                                    <a class="btn btn-xxs btn-danger delete-page" data-page="{{ $page->id }}" href="javascript:void(0)">Delete</a>
                                    {{-- @endcan --}}
                                </td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                @if(is_null($parent->id))
                                    <td>{{ $page->children_count }}</td>
                                @endif
                                <td>{{ $page->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
        <script>
            $(document).on("click", ".delete-page", function (e) {
                e.preventDefault();
                __this = $(this);
                let page_id = $(this).data("page");
                Swal.fire({
                    title: "Are You Sure?",
                    text: "Are you want to delete this page?",
                    icon: "warning",
                    showCancelButton: true,
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        loader()
                        axios.delete(`${APP_URL}/admin/pages/${page_id}`)
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

