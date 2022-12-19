<x-backend.layouts.app>
    @section('title', 'Create new user')
    @section('header-title', 'Create new user' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/genealogy.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.genealogy', $parent) }}">Genealogy</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ URL::signedRoute('user.genealogy.position.manage', [$parent, $position]) }}">Manage New Position</a>
        </li>
        <li class="breadcrumb-item active">Create new user</li>
    @endsection
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <livewire:user.genealogy.create-new-user :parent="$parent" :position="$position"/>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/genealogy/assign-position.js') }}"></script>
    @endpush
</x-backend.layouts.app>
