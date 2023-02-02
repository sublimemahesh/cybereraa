<x-backend.layouts.app>
    @section('title', 'Kyc Entry')
    @section('header-title', 'Kyc Entry' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/kyc.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.kycs.index', $kyc->profile->user) }}">KYCs</a>
        </li>
        <li class="breadcrumb-item">{{ $kyc->kyc_type }} Entry</li>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table header-border table-responsive-sm">
                            <thead>
                            <tr>
                                <th>DOCUMENT NAME</th>
                                <th>DOCUMENT TYPE</th>
                                <th>UPLOADED AT</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kyc->documents as $document)
                                <tr>
                                    <td>{{ $document->document_type_name }}</td>
                                    <td>{{ $document->document_type }}</td>
                                    <td>{{ $document->updated_at }}</td>
                                    <td>
                                        <div class="badge badge-xs badge-{{ $document->status_color }} light">{{ strtoupper($document->status) }}</div>
                                    </td>
                                    <td class="imgDiv">
                                        @can ('view', $document)
                                        <a src="{{ storage('user/kyc/' . $kyc->type . '/' . $document->document_name) }}"
                                            class="btn btn-primary btn-xxs mb-2" href="#">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan
                                        @can('approve', $document)
                                            <a target="_blank" class="btn btn-success btn-xxs mb-2 approve-kyc" data-document="{{ $document->id }}" href="javascript:void(0);">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        @endcan
                                        @can('reject', $document)
                                            <a target="_blank" class="btn btn-danger btn-xxs mb-2 reject-kyc" data-document="{{ $document->id }}" href="javascript:void(0);">
                                                <i class="fas fa-close"></i>
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
    <script src="{{ asset('assets/backend/js/admin/users/ezoom.js') }}"></script>
    <script src="{{ asset('assets/backend/js/admin/users/kyc-approve.js') }}"></script>
    @endpush
</x-backend.layouts.app>
