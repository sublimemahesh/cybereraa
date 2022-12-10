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

    <div class="row">
        <div class="col-lg-12">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="card-text">
                        <div>
                            Document name:
                            <div class="badge badge-xs badge-dark light">{{ strtoupper($kyc->kyc_type) }} FRONT IMAGE</div>
                        </div>
                        <div>
                            Document Type:&nbsp;&nbsp;
                            <div class="badge badge-xs badge-dark light">FRONT</div>
                        </div>
                        </p>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="card-text">
                        <div>
                            Document name:
                            <div class="badge badge-xs badge-dark light">{{ strtoupper($kyc->kyc_type) }} BACK IMAGE</div>
                        </div>
                        <div>
                            Document Type:&nbsp;&nbsp;
                            <div class="badge badge-xs badge-dark light">BACK</div>
                        </div>
                        </p>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="card-text">
                        <div>
                            Document name:
                            <div class="badge badge-xs badge-dark light">SELFIE WITH {{ strtoupper($kyc->kyc_type) }}</div>
                        </div>
                        <div>
                            Document Type:&nbsp;&nbsp;
                            <div class="badge badge-xs badge-dark light">OTHER</div>
                        </div>
                        </p>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/kyc/create.js') }}"></script>
    @endpush
</x-backend.layouts.app>