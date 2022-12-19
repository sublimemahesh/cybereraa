<x-backend.layouts.app>
    @section('title', 'Edit pages | CMS')
    @section('header-title', 'Edit pages | CMS' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.pages.index') }}">Pages</a>
        </li>
        @if(!is_null($parent->id))
            <li class="breadcrumb-item">
                <a href="{{ URL::signedRoute('admin.sections.index', ['page' => $parent->slug]) }}">{{ $parent->title }} Page</a>
            </li>
        @endif
        <li class="breadcrumb-item active">Edit {{ $page->title }} page </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <livewire:admin.pages.save :page="$page" :parent="$parent"/>
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