<x-backend.layouts.app>
    @section('title', 'Strategies | Withdrawal')
    @section('header-title', 'Strategies | Withdrawal' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a class="active">Withdrawal</a>
        </li>
    @endsection

    @include('backend.admin.strategies.withdrawal.payout-limits')

    @include('backend.admin.strategies.withdrawal.fees')

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script>
            $("#withdrawal_days_of_week").select2({
                placeholder: 'Select week days of the week',
                allowClear: true
            })
        </script>
    @endpush
</x-backend.layouts.app>

