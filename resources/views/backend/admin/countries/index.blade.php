<x-backend.layouts.app>
    @section('title', 'Countries | CMS')
    @section('header-title', 'Countries | CMS' )
    @section('styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.countries.index') }}">Countries</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.countries.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="countries">
                        <thead>
                        <tr>
                            <th>ACTIONS</th>
                            <th>NAME</th>
                            <th>ISO</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>
                                    {{-- @can('update', $country) --}}
                                    <a class="btn btn-xs btn-info sharp" href="{{ route('admin.countries.edit', $country) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-xs btn-danger sharp delete-country" data-country="{{ $country->id }}" href="javascript:void(0)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    {{-- @endcan --}}
                                </td>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->iso }}</td>
                                <td>{{ $country->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Datatable -->
        <script src="{{ asset('assets/backend/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/cms/country.js') }}"></script>
    @endpush
</x-backend.layouts.app>

