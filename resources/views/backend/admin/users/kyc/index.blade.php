<x-backend.layouts.app>
    @section('title', 'User KYC')
    @section('header-title', 'User KYC' )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">KYCs</li>
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
                                <th># SUBMITTED DOCUMENTS</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kycs as $kyc)
                                <tr>
                                    <td>{{ $kyc->kyc_type }}</td>
                                    <td>{{ $kyc->required_documents }}</td>
                                    <td>{{ $kyc->documents_count }}</td>
                                    <td>
                                        {{--Pending / Rejected--}}
                                        <div class="badge badge-{{ $kyc->status_color }} text-white">{{ ucfirst($kyc->status) }}</div>
                                    </td>
                                    <td>
                                        @can('view', $kyc)
                                            <a href="{{ route('admin.users.kycs.show', $kyc) }}" class="btn btn-xs btn-primary shadow sharp me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
    </div>

    @push('scripts')
    @endpush
</x-backend.layouts.app>
