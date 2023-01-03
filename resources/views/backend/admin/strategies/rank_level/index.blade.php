<x-backend.layouts.app>
    @section('title', 'Strategies | commissions')
    @section('header-title', 'Strategies | Rank level')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Rank level</a>
        </li>
    @endsection

   
            @include('backend.admin.strategies.rank_level.save', ['btn_id' => 'create'])
       

    @push('scripts')
        <!-- Datatable -->
    @endpush
</x-backend.layouts.app>
