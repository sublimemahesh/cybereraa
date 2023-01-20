<x-backend.layouts.app>
    @section('title', 'withdraw | form')
    @section('header-title', 'withdraw | form')
    @section('plugin-styles')
        <!-- Datatable -->
        <link href="{{ asset('assets/backend/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Withdraw</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" wire:submit.prevent="save" id="withdraw-form">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="">Amount</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name='amount' id="amount">
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label" for="">Proof</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" name='proof' id='proof'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="create-withdraw-form" wire:loading.remove>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/backend/js/admin/transfers/withdraw_form.js') }}"></script>
    @endpush
</x-backend.layouts.app>
