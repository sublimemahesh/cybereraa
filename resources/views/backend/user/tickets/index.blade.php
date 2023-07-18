<x-backend.layouts.app>
    @section('title', 'Support Tickets')
    @section('header-title', 'Support Tickets' )
    @section('plugin-styles')
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Support Tickets</li>
    @endsection
    <div class="row">


        <div class="col-xl-12  col-lg-12">
            <div class="card border-0 pb-0">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Support Tickets {{ count($tickets) }}</h4>
                    <a  href="{{ route('user.support.tickets.create') }}">
                        <button class="round-button" title='Open a New Ticket'>
                            <span class="cross-icon"></span>
                          </button>
                    </a>


                </div>
                <div class="card-body p-0">
                    <div id="DZ_W_Todo2" class="widget-media  my-4 px-4">
                        <ul class="timeline">

                            @foreach ($tickets as $key => $section)

                            <li>
                                <div class="timeline-panel">
                                    <div class="media me-2 media-info">
                                        ST
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mb-1">{{str_pad($section->id, 6, 0, STR_PAD_LEFT)}} | {{$section->subject}}</h5>
                                        <h5>

                                            <span title="Category" class="badge" style="background-color:{{$section->category->color}}">{{$section->category->name}}</span>
                                            <span title="Priority" class="badge" style="background-color:{{$section->priority->color}}">{{$section->priority->name}}</span>
                                            <span title="Status" class="badge" style="background-color:{{$section->status->color}}">{{$section->status->name}}</span>
                                            @if (!empty($section->attachment))

                                            <a title="Attachment" href='{{ storage("supports/tickets/" . $section->attachment) }}' target="_blank">
                                                <img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png"  alt="" width="25px"/>
                                            </a>


                                        @endif
                                        </h5>
                                        <small class="d-block">{{date('d F Y - h:i A', strtotime($section->created_at))}}</small>
                                    </div>
                                    <div class="dropdown">
                                        <button type="button" class="btn light sharp" data-bs-toggle="dropdown" style="background-color:{{$section->category->color}}">
                                            <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @can('view', $section)
                                            <a class="dropdown-item" href="{{ route('user.support.tickets.show', $section) }}">View</a>
                                            @endcan
                                            @can('update', $section)
                                            <a class="dropdown-item" href="{{ route('user.support.tickets.edit', $section) }}">Edit</a>
                                            @endcan
                                            @can('reopen', $section)
                                            <a class="dropdown-item reopen-ticket" data-id="{{ $section->id }}" href="javascript:void(0)">Open</a>
                                            @endcan
                                            @can('delete', $section)
                                            <a class="dropdown-item close-ticket"  data-id="{{ $section->id }}" href="javascript:void(0)">Close</a>
                                            @endcan
                                            @can('delete', $section)
                                            <a class="dropdown-item delete-ticket"  data-id="{{ $section->id }}" href="javascript:void(0)">Delete</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>




    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/global-datatable-extension.js') }}"></script>
        <script src="{{ asset('assets/backend/js/user/tickets/index.js') }}"></script>
    @endpush
</x-backend.layouts.app>



