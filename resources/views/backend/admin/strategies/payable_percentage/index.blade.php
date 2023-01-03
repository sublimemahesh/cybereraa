<x-backend.layouts.app>
    @section('title', 'Strategies | Payable percentage')
    @section('header-title', 'Strategies | Payable percentage' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Payable percentage</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.strategies.payable_percentage.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    
    @endpush
</x-backend.layouts.app>

