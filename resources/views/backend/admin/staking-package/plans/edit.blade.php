<x-backend.layouts.app>
    @section('title', 'Edit Package | CMS')
    @section('header-title', 'Edit Package | CMS' )
    @section('styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-packages.index') }}">Staking Packages</a>
        </li>

        <li class="breadcrumb-item active">Edit {{ $plan->name }} Package</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.staking-package.plans.save', ['btn_id' => 'update'])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/cms/staking_plan.js') }}"></script>
    @endpush
</x-backend.layouts.app>
