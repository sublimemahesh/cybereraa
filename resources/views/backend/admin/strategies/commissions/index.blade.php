<x-backend.layouts.app>
    @section('title', 'Strategies | Commissions')
    @section('header-title', 'Strategies | Commissions' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Commissions</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                   @include('backend.admin.strategies.Commissions.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="{{ asset('assets/backend/js/admin/strategies/Commissions/script.js') }}"></script>
    @endpush
</x-backend.layouts.app>

