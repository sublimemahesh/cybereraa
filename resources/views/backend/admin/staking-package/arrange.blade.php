<x-backend.layouts.app>
    @section('title', 'Packages | Arrange | CMS')
    @section('header-title', 'Arrange | CMS' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-packages.index') }}">Staking Packages</a>
        </li>

        <li class="breadcrumb-item active">Arrange Packages</li>
    @endsection

    <div class="row ui-sortable" id="draggableMultiple">
        @foreach ($packages as $package)
            <div class="col-auto col-sm-2" data-id="{{ $package->id }}">
                <div class="card cursor-pointer">
                    <div class="card-body p-2 text-center">
                        <p class="card-text">{{ $package->name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/dragable/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/dragable/sortable.js') }}"></script>
        <!-- Datatable -->
        <script !src="">
            $(function () {
                $("#draggableMultiple").sortable({
                    revert: true,
                    animation: 150,
                    update: function (e, ui) {
                        let sortData = $("#draggableMultiple").sortable("toArray", {
                            attribute: "data-id",
                        });
                        axios.post("{{ route('admin.staking-packages.arrange.store') }}", {ids: sortData})
                            .then(response => {
                                Toast.fire({
                                    icon: response.data.icon, title: response.data.message,
                                })
                            })
                            .catch(error => {
                                Toast.fire({
                                    icon: 'error', title: error.response.data.message || "Something went wrong!",
                                })
                            });
                    },
                });
            });
        </script>
    @endpush
</x-backend.layouts.app>
