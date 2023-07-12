<x-backend.layouts.app>
    @section('title', 'Tutorial')
    @section('header-title', 'Tutorial' )
    @section('styles')
        @vite(['resources/css/app-jetstream.css'])
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">Tutorial</li>
    @endsection


        <!--**********************************
            Content body start
        ***********************************-->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Video Tutorial</h4>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($tutorials->children as $key => $section)
                    @if ($key== 0)
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#{{$section->slug}}"><i class="fa fa-book"></i><span>!&nbsp; {{$section->title}}</span></a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#{{$section->slug}}"><i class="fa fa-book"></i><span>!&nbsp;{{$section->title}}</span></a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($tutorials->children as $key => $section)
                    @if ($key== 0)
                    <div class="tab-pane fade show active" id="{{$section->slug}}" role="tabpanel">
                        <div class="pt-4">
                        {!! html_entity_decode($section->content) !!}
                        </div>
                    </div>
                    @else
                    <div class="tab-pane fade" id="{{$section->slug}}">
                        <div class="pt-4">
                            {!! html_entity_decode($section->content) !!}
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

  <!--**********************************
            Content body end
 ***********************************-->

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/kyc/create.js') }}"></script>
    @endpush
</x-backend.layouts.app>
