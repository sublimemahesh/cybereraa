<x-backend.layouts.app>
    @section('title', 'Edit Currency | CMS')
    @section('header-title', 'Edit Currency | CMS' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.currencies.index') }}">Currencies</a>
        </li>

        <li class="breadcrumb-item active">Edit {{ $currency->title }} Currency</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.currencies.save', ['btn_id' => 'update'])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/currency.js') }}"></script>
    @endpush
</x-backend.layouts.app>
