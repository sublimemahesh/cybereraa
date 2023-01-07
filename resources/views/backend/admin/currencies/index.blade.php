<x-backend.layouts.app>
    @section('title', 'Currencies | CMS')
    @section('header-title', 'Currencies | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.currencies.index') }}">Currencies</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('backend.admin.currencies.save', ['btn_id' => 'create'])
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="currencies">
                        <thead>
                        <tr>
                            <th>ACTIONS</th>
                            <th>NAME</th>
                            <th>VALUE</th>
                            <th>CHANGE</th>
                            <th>LAST MODIFIED</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($currencies as $currency)
                            <tr>
                                <td class="py-2">
                                    {{-- @can('update', $currency) --}}
                                    <a class="btn btn-xs btn-info sharp" href="{{ route('admin.currencies.edit', $currency) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-xs btn-danger sharp delete-currency" data-currency="{{ $currency->id }}" href="javascript:void(0)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    {{-- @endcan --}}
                                </td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->value }} USD</td>
                                <td>{{ $currency->change }} %</td>
                                <td>{{ $currency->updated_at }}</td>
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
        <script src="{{ asset('assets/backend/js/admin/cms/currency.js') }}"></script>
    @endpush
</x-backend.layouts.app>

