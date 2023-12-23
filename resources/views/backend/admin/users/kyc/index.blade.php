<x-backend.layouts.app>
    @section('title', 'User KYC')
    @section('header-title', 'User KYC' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/kyc.css') }}">
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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <div class="tab-content">
                                        <div class="profile-personal-info">
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500"> Name <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->name }}</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">User name <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->username }}</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Date of birthday <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->dob }}</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Gender <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->gender }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <div class="tab-content">
                                        <div class="profile-personal-info">
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500"> NIC no <span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->profile->nic }}</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500"> Passport no<span class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->profile->passport_number }}</h5>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500"> Driving license no<span
                                                            class="pull-end">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7">
                                                    <h5>{{ $user->profile->driving_lc_number }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($kycs as $kyc)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $kyc->kyc_type }} </h4>
                        <hr>
                        <p> Required Documentation: <code>{{ $kyc->required_documents }} REQUIRED</code></p>
                        <p> Submitted Documentation: <code>{{ $kyc->documents_count }} SUBMITED</code></p>
                        STATUS:
                        <div class="badge badge-sm badge-{{ $kyc->status_color }} text-white">{{ ucfirst($kyc->status) }}</div>
                    </div>
                </div>
            </div>
            @can('view', $kyc)
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($kyc->documents as $document)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $document->document_type_name }} </h4>
                                        <hr>
                                        <p>DOCUMENT TYPE: <code>{{$document->document_type}}</code></p>
                                        <p>CREATED AT: <code>{{$document->created_at}}</code></p>
                                        <p>UPDATED AT: <code>{{$document->updated_at}}</code></p>
                                        STATUS:
                                        <div class="badge badge-xs badge-{{ $document->status_color }} light">
                                            {{ strtoupper($document->status) }}
                                        </div>
                                        @if($document->repudiate_note !== null)
                                            <p class="mt-2">REJECT REASON: <code>{{ $document->repudiate_note }}</code></p>
                                        @endif
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a src="{{ storage('user/kyc/' . $kyc->type . '/' . $document->document_name) }}" href="javascript:void(0)" class="imgDiv">
                                                    <img src="{{ storage('user/kyc/' . $kyc->type . '/' . $document->document_name) }}" class="img-thumbnail" style="max-height: 600px" alt="">
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="profile-personal-info">
                                                    @if($user->profile->nic !== null)
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3 col-5">
                                                                <h5 class="f-w-500"> NIC no <span class="pull-end">:</span>
                                                                </h5>
                                                            </div>
                                                            <div class="col-sm-9 col-7">
                                                                <h5>{{ $user->profile->nic }}</h5>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->passport_number !== null)
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3 col-5">
                                                                <h5 class="f-w-500"> Passport no<span class="pull-end">:</span>
                                                                </h5>
                                                            </div>
                                                            <div class="col-sm-9 col-7">
                                                                <h5>{{ $user->profile->passport_number }}</h5>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->driving_lc_number !== null)
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3 col-5">
                                                                <h5 class="f-w-500"> Driving license no<span
                                                                        class="pull-end">:</span>
                                                                </h5>
                                                            </div>
                                                            <div class="col-sm-9 col-7">
                                                                <h5>{{ $user->profile->driving_lc_number }}</h5>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500"> Name <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <h5>{{ $user->name }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">User name <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <h5>{{ $user->username }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <h5>{{ $user->email }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Date of birthday <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <h5>{{ $user->dob }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3 col-5">
                                                            <h5 class="f-w-500">Gender <span class="pull-end">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-sm-9 col-7">
                                                            <h5>{{ $user->gender }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @can('approve', $document)
                                            <a target="_blank" class="btn btn-success btn-xxs mb-2 approve-kyc"
                                               data-document="{{ $document->id }}" href="javascript:void(0);">
                                                <i class="fas fa-check-circle"></i> APPROVE
                                            </a>
                                        @endcan
                                        @can('reject', $document)
                                            <a id="reject-kyc-{{ $document->id }}" class="btn btn-danger btn-xxs mb-2 reject-kyc" data-document="{{ $document->id }}" href="javascript:void(0);">
                                                <i class="fas fa-close"></i> REJECT
                                            </a>
                                        @endcan
                                        <input type="hidden" name="kyc" id="kyc" value="{{ $kyc->id }}">
                                        {{--<input type="hidden" name="document" id="document" value="{{ $document->id }}">--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endcan
            <hr>
        @endforeach
    </div>

    @push('scripts')
        <script>
            const REJECT_REASONS = {!! json_encode(App\Enums\KycRejectReasonsEnum::reasons(),JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT) !!}
        </script>
        <script src="{{ asset('assets/backend/js/admin/users/ezoom.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/kyc-approve.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/kyc/reject-kyc.js') }}"></script>
    @endpush
</x-backend.layouts.app>
