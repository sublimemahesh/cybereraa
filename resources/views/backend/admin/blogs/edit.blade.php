<x-backend.layouts.app>
    @section('title', 'Edit Blog | CMS')
    @section('header-title', 'Edit Blog | CMS' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.blogs.index') }}">Blog</a>
        </li>
        <li class="breadcrumb-item active">Edit blog {{ $blog->title }}</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.blogs.save :blog="$blog"/>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
    @endpush
</x-backend.layouts.app>