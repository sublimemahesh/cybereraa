<x-backend.layouts.app>
    @section('title', 'KYC  Entry')
    @section('header-title', 'KYC  Entry' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/kyc.css') }}">
        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.kyc.index') }}">KYC</a>
        </li>
        <li class="breadcrumb-item">Entry</li>
    @endsection

    <div class="row">
        @if(!Auth::user()->profile_is_complete)
            <div class="col-xl-12 col-lg-12">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                @endif
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title"></h4>
                        <p>Please note that the KYC details aren't updatable</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="mb-1" for="{{ $kyc->profile_name }}">
                                <strong>{{ $kyc->kyc_type }}
                                    <sup class="main-required">*</sup>
                                </strong>
                            </label>
                            <x-jet-input id="{{ $kyc->profile_name }}" placeholder="Enter {{ $kyc->kyc_type }} Number" class="block mt-1 w-full form-control" type="text" name="nic" value="{{ $kyc->profile->{$kyc->profile_name} }}" required/>
                        </div>
                        <hr>
                        @foreach($kyc->documents as $document)
                            <div class="col-lg-12 mb-3">
                                <div class="row mb-3">
                                    <div class="card-text col-sm-6">
                                        <div>
                                            Document name:
                                            <span><code>{{ $document->document_type_name }}</code></span>
                                        </div>
                                        <div>
                                            Document Type:&nbsp;&nbsp;
                                            <div class="badge badge-xs badge-dark light">{{ $document->document_type }}</div>
                                        </div>
                                    </div>
                                    <div class="card-text col-sm-6">
                                        @if($document->status !== 'required')
                                            <div>
                                                Uploaded at:&nbsp;&nbsp;
                                                <div class="badge badge-xs badge-success light">{{ $document->updated_at }}</div>
                                            </div>
                                        @endif
                                        <div>
                                            Status:&nbsp;&nbsp;
                                            <div class="badge badge-xs badge-{{ $document->status_color }} light">{{ strtoupper($document->status) }}</div>
                                        </div>
                                    </div>
                                    @if($document->status === 'rejected' && $document->repudiate_note !== null)
                                        <div class="card-text col-sm-12 mt-3">
                                            <div>
                                                Reject Reason:&nbsp;&nbsp;
                                                <div class="badge badge-xs light">{{ $document->repudiate_note }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @can ('view', $document)
                                    <a target="_blank" class="btn btn-block btn-primary btn-sm mb-2" href="{{ storage('user/kyc/'. $kyc->type .'/'. $document->document_name) }}"> View Image</a>
                                @endcan
                                @can('update', $document)
                                    {{-- <input class="form-control" type="file" id="formFile">--}}
                                    <section class="kyc-img-container">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-4">
                                                        <div class="preview-zone d-none">
                                                            <div class="box box-solid">
                                                                <div class="box-header with-border">
                                                                    <div><b>Preview</b></div>
                                                                    <div class="box-tools pull-right">
                                                                        <button type="button" class="btn btn-danger btn-xxs remove-preview">
                                                                            Remove Image
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="box-body mb-3">
                                                                    <!-- preview image -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @can ('update', $document)
                                                            <div class="dropzone-wrapper">
                                                                <div class="dropzone-desc">
                                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                                    <p class="m-0 mb-1">- Choose an image file -</p>
                                                                    <p class="mb-0">Click here or Drag & drop here.</p>
                                                                </div>
                                                                <input type="file" data-type="{{ $document->type }}" id="{{ $kyc->type }}-{{ $document->type }}-image" class="dropzone" accept="image/*" required/>
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="kyc-doc-val" id="{{ $document->type }}">
                                            <input type="hidden" value="{{ $document->id }}" id="{{ $kyc->type }}-{{ $document->type }}-id"/>
                                            {{--<button type="submit" id="{{ $kyc->type }}-{{ $document->type }}-submit" data-kyc="{{ $kyc->id }}" class="btn btn-block btn-primary">Save Document</button>--}}
                                        </form>
                                    </section>
                                @endcan
                                <input type="hidden" value="{{ $document->document_name }}" id="{{ $document->type }}-has-document">
                            </div>
                            <hr>
                        @endforeach
                        @can('update', $kyc)
                            <div class="col-lg-12 mb-3">
                                <button id="saveKYC" data-kyc="{{ $kyc->id }}" type="submit" class="btn btn-primary">
                                    Save KYC
                                </button>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('update', $kyc)
        @push('scripts')
            <script>
                const KYC_TYPE = "{{ $kyc->type }}"
                const KYC_PROFILE = "{{ $kyc->profile_name }}"
            </script>
            <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
            <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
            <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
            <script src="{{ asset('assets/backend/js/user/kyc/dropzone.js?12345') }}"></script>
        @endpush
    @endcan
</x-backend.layouts.app>
