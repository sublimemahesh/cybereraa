<x-backend.layouts.app>
    @section('title', 'Testimonials')
    @section('header-title', 'Testimonials' )
    @section('plugin-styles')
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Testimonials</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <div style="margin-bottom: 10px;" class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-dark btn-xs btn-rounded" href="{{ route('admin.testimonials.create') }}">
                                    New Testimonial
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="display" style="min-width: 845px" id="testimonial-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th style="max-width: 200px;">Comment</th> 
                                    <th>Status</th>
                                    <th style="max-width: 400px;" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($testimonials as $testimonial)
                                    <tr id="testimonial-record-{{ $testimonial->id }}">
                                        <td>{{ $testimonial->id }}</td>
                                        <td>{{ $testimonial->name }}</td>
                                        <td>{{ $testimonial->title }}</td>
                                        <td>{{ $testimonial->comment }} </td>
                                        <td id="testimonial-status-{{ $testimonial->id }}" class="text-uppercase">
                                            @if ($testimonial->is_active)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td class="text-center" id="testimonial-action-{{ $testimonial->id }}">
                                            <a class="btn btn-xs sharp btn-primary" href="{{ route('admin.testimonials.edit', $testimonial) }}">
                                                <i class="fa fa-pencil"> </i>
                                            </a>
                                            <a class="btn btn-xs sharp btn-danger delete-testimonial" href="javascript:void(0)" data-testimonial="{{ $testimonial->id }}" id="testimonial-delete-{{ $testimonial->id }}">
                                                <i class="fa fa-trash-alt"> </i>
                                            </a>
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
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/testimonials/main.js') }}"></script>
    @endpush
</x-backend.layouts.app>