<x-backend.layouts.app>
    @section('title', 'Kyc Entry')
    @section('header-title', 'Kyc Entry' )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.kyc.index') }}">KYC</a>
        </li>
        <li class="breadcrumb-item">Entry</li>
    @endsection

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/kyc/create.js') }}"></script>
    @endpush
</x-backend.layouts.app>