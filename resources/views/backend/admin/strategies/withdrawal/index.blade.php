<x-backend.layouts.app>
    @section('title', 'Strategies | Withdrawal')
    @section('header-title', 'Strategies | Withdrawal' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a class="active">Withdrawal</a>
        </li>
    @endsection

    @include('backend.admin.strategies.withdrawal.payout-limits')

    @include('backend.admin.strategies.withdrawal.fees')

</x-backend.layouts.app>

