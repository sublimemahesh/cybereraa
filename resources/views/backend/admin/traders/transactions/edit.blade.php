<x-backend.layouts.app>
    @section('title', 'Update Transactions | Expenses Summery')
    @section('header-title', 'Update Transactions | Expenses Summery' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a{{-- href="{{ route('admin.traders.transactions.index', $transaction->trader) }}"--}}>Traders Transactions</a>
        </li>

        <li class="breadcrumb-item active">Edit</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.traders.transactions.save', ['btn_id' => 'update'])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/traders_transaction.js') }}"></script>
    @endpush
</x-backend.layouts.app>
