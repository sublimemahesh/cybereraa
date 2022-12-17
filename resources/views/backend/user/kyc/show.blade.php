<x-backend.layouts.app>
    @section('title', 'Kyc Entry')
    @section('header-title', 'Kyc Entry' )
    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/css/user/kyc.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.kyc.index') }}">KYC</a>
        </li>
        <li class="breadcrumb-item">Entry</li>
    @endsection

    <div class="row">
        @foreach($kyc->documents as $document)
            <div class="col-lg-12">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="card-text col-sm-6">
                                <div>
                                    Document name:
                                    <div class="badge badge-xs badge-dark light">{{ $document->document_type_name }}</div>
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
                                                        <input type="file" id="{{ $kyc->type }}-{{ $document->type }}-image" class="dropzone" accept="image/*" required/>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $document->id }}" id="{{ $kyc->type }}-{{ $document->type }}-id"/>
                                    <button type="submit" id="{{ $kyc->type }}-{{ $document->type }}-submit" data-kyc="{{ $kyc->id }}" class="btn btn-block btn-primary">Save Document</button>
                                </form>
                            </section>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script>
            const KYC_TYPE = "{{ $kyc->type }}"
        </script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/binaryajax.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/exif.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/canvasResize/canvasResize.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/kyc/dropzone.js') }}"></script>
    @endpush
</x-backend.layouts.app>