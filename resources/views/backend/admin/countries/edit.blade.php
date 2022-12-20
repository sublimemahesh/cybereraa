<x-backend.layouts.app>
    @section('title', 'Edit Country | CMS')
    @section('header-title', 'Edit Country | CMS' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.countries.index') }}">Countries</a>
        </li>

        <li class="breadcrumb-item active">Edit {{ $country->title }} country</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.countries.save', ['btn_id' => 'update'])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/cms/country.js') }}"></script>
    @endpush
</x-backend.layouts.app>