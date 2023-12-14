<x-backend.layouts.app>
    @section('title', 'Strategies | Daily Leverages')
    @section('header-title', 'Strategies | Daily Leverages' )
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="">Commissions Daily Leverages</a>
        </li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Daily leverages
                    </h5>
                    <p>Mention the values in percentage of 100</p>
                    <hr>
                    <form class="theme-form" enctype="multipart/form-data" id="payable-percentage-form">
                        <div class="row">
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="investment_start_at">Package Earning Start Date</label>
                                <div class="col-sm-9">
                                    <input class="form-control" value="{{ $investment_start_at?->value ?? 2 }}" id="investment_start_at" name="investment_start_at" placeholder="Package Investment Start date from purchase date" type="number">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="package">Package</label>
                                <div class="col-sm-9">
                                    <input class="form-control" value="{{ $payable_percentages?->package ?? 1 }}" id="package" name="package" placeholder="Package Investment daily leverage" type="number">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="direct">
                                    <del>Direct</del>
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $payable_percentages->direct }}" id="direct" name="direct" placeholder="Direct commission daily leverage" type="text">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="indirect">
                                    <del>Indirect</del>
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $payable_percentages->indirect }}" id="indirect" name="indirect" placeholder="Indirect commission daily leverage" type="text">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="rank_bonus">
                                    <del>Rank bonus</del>
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" disabled value="{{ $payable_percentages->rank_bonus ?? 0.332 }}" id="rank_bonus" name="rank_bonus" placeholder="Rank bonus daily leverage" type="text">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" id="save-payable-percentage" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/admin/strategies/leverages/commission-leverage.js') }}"></script>
    @endpush
</x-backend.layouts.app>

