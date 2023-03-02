<x-backend.layouts.app>
    @section('title', 'Reject KYC | Users')
    @section('header-title', 'Reject KYC | Users' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/choose-wallet.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Reject KYC</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Reject KYC {{ $user->username }}</h4>
                        <hr>
                        <p>DOCUMENT NAME: <code>{{ $document->document_type_name }}</code></p>
                        <p>DOCUMENT TYPE: <code>{{ $document->document_type }}</code></p>
                        <p>UPLOADED AT: <code>{{ $document->updated_at }}</code></p>
                        <div class="badge badge-xs badge-{{ $document->status_color }} light">
                            {{ strtoupper($document->status) }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="reject-kyc-form">
                                <div class="mb-3 mt-2">
                                    <label for="repudiate_note">DOCUMENT</label> <br>
                                    <img src="{{ storage('user/kyc/' . $kyc->type . '/' . $document->document_name) }}" class="img-thumbnail" width="200px" alt=""/>
                                </div>
                                <hr>
                                <div class="mb-3 mt-2">
                                    <label for="repudiate_note">Reason</label>
                                    <textarea id="repudiate_note" name="repudiate_note" rows="3" placeholder="Reject Note" class="form-control h-auto">{{ $document->repudiate_note }}</textarea>
                                </div>
                                <hr>
                                <input type="hidden" name="kyc" id="kyc" value="{{ $kyc->id }}">
                                <input type="hidden" name="document" id="document" value="{{ $document->id }}">
                                @can('reject', $document)
                                    <button type="submit" id="reject-kyc" class="btn btn-sm btn-info mb-2">Confirm & Reject</button>
                                @endcan
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/users/kyc-approve.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/kyc/reject-kyc.js') }}"></script>
    @endpush
</x-backend.layouts.app>
