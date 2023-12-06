<x-backend.layouts.app>
    @section('title', 'Update Trader | Expenses Summery')
    @section('header-title', 'Update Trader | Expenses Summery' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.traders.index') }}">Traders</a>
        </li>

        <li class="breadcrumb-item active">Edit {{ $trader->name }} </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.traders.save', ['btn_id' => 'update'])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/traders.js') }}"></script>
    @endpush
</x-backend.layouts.app>
