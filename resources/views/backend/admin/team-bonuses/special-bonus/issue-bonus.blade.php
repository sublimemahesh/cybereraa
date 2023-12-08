<x-backend.layouts.app>
    @section('title', 'Bonus Issue')
    @section('header-title', 'Confirmation of Bonus Issue')
    @section('plugin-styles')
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Issue Bonus</li>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="theme-form" enctype="multipart/form-data" id="issue-bonus-form">
                        <div class="mb-4">
                            <h4 class="card-title">BONUS TYPE: {{ $bonus->bonus }}</h4>

                            <div class="mb-2">
                                Required Investment:<code>{{$team_bonus_requirement['total_investment']}}</code>
                                <br/>
                                Required Direct Sale:<code>{{$team_bonus_requirement['direct_sales']}}</code>
                                <br/>
                                <hr/>
                                Achieved Total Investment:<code>{{ number_format($total_direct_team_investment, 2) }}</code>
                                <br/>
                                Achieved Direct Sale:<code>{{ $direct_sales_count }}</code>
                                <br/>
                                <hr/>
                                User ID: <code>{{ $bonus->user_id }}</code> | Username:
                                <code>{{ $bonus->user->username }}</code>
                                <br/>
                                <hr/>
                                Please note this <code class="text-uppercase">process cannot be reversed</code>.
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                @foreach($allowed_packages as $package)
                                    <div class="form-check custom-checkbox mb-3">
                                        <input type="checkbox" class="form-check-packages" data-amount="{{ $package->invested_amount }}" id="{{ $package->id }}" value="{{ $package->id }}" name="package_ids[]">
                                        <label class="form-check-label" for="{{ $package->id }}">
                                            #{{ $package->id }} - ${{ number_format($package->invested_amount, 2) }} | User: {{ $package->user->username }}
                                        </label>
                                    </div>
                                @endforeach
                                <input type="hidden" name="bonus" id="bonus" value="{{ $bonus->id }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="mb-2">
                                SELECTED PACKAGE AMOUNT: <code id="selected_package_amount"> 0 </code>
                            </div>
                            <div id="req-status"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="issue">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script !src="">
            const BONUS = "{{ $bonus->id }}";
            const REQUIRED_PACKAGE_AMOUNT = parseFloat({{ $team_bonus_requirement['total_investment'] }});

        </script>
        <script src="{{ asset('assets/backend/js/admin/bonuses/special-bonus-issue.js') }}"></script>
    @endpush
</x-backend.layouts.app>
