<x-backend.layouts.app>
    @section('title', 'Strategies | Withdrawal')
    @section('header-title', 'Strategies | Withdrawal' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Withdrawal</a>
        </li>
    @endsection

                    @include('backend.admin.strategies.withdrawal.save', ['btn_id' => 'create'])
        
    @push('scripts')
    <script src="{{ asset('assets/backend/js/admin/strategies/withdrawal/script.js') }}"></script>
    @endpush
</x-backend.layouts.app>

