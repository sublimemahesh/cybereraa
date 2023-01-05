<x-backend.layouts.app>
    @section('title', 'Strategies | commissions')
    @section('header-title', 'Strategies | Rank level')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a class="active">Rank level</a>
        </li>
    @endsection

    <div class="row">
        @include('backend.admin.strategies.rank_level.levels', ['btn_id' => 'create'])

        {{-- ////////////////////////////  Rank package requirement ///////////////////// --}}
        @include('backend.admin.strategies.rank_level.package-requirement', ['btn_id' => 'create'])

    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/strategies/ranks/levels.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/strategies/ranks/package-requirement.js') }}"></script>
    @endpush
</x-backend.layouts.app>
