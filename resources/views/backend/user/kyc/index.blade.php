<x-backend.layouts.app>
    @section('title', 'My KYC')
    @section('header-title', 'My KYC' )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">KYC</li>
    @endsection

    <div class="row kyc-details-page">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ACTIVE KYC ENTRIES</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table header-border table-responsive-sm display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>KYC TYPE</th>
                                <th># REQUIRED DOCUMENTS</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kycs as $kyc)
                                <tr>
                                    <td>{{ $kyc->kyc_type }}</td>
                                    <td>{{ $kyc->required_documents }}</td>
                                    <td>
                                        {{--Pending / Rejected--}}
                                        <div class="badge badge-{{ $kyc->status_color }} text-white">{{ ucfirst($kyc->status) }}</div>
                                    </td>
                                    <td>
                                        @can('view', $kyc)
                                            <a href="{{ route('user.kyc.show', $kyc) }}" class="btn btn-xxs btn-primary shadow"> View Documents</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">REQUIRED / OPTIONAL KYC ENTRIES</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table header-border table-responsive-sm">
                            <thead>
                            <tr>
                                <th>KYC TYPE</th>
                                <th># REQUIRED DOCUMENTS</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach(App\Models\Kyc::KYC_TYPES as $kyc_type => $kyc_type_name)
                                @can('create', [App\Models\Kyc::class, $kyc_type])
                                    <tr>
                                        <td> {{ $kyc_type_name }}</td>
                                        <td> {{ App\Models\Kyc::REQUIRED_DOCUMENTS[$kyc_type] }} </td>
                                        <td>
                                            <div class="badge badge-dark light">REQUIRED</div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xxs btn-primary shadow create-kyc-entry" data-kyc-type="{{ $kyc_type }}">Select</a>
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/kyc/create.js') }}"></script>
    @endpush
</x-backend.layouts.app>
