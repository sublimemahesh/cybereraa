<x-backend.layouts.app>
    @section('title', 'Rank Bonus Requirements')
    @section('header-title', 'Rank Bonus Requirements' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Monthly Bonus Requirements</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        @if(!$summery_exists)
            <div class="col-sm-12">
                <div class="alert alert-warning">This Month Rank bonus does not exist.</div>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">{{ $month }} - Rank bonus requirements</h4>
                        <p>
                            CURRENT HIGHEST ACTIVE PACKAGE ({{ \Carbon::now()->format('Y-m-d') }}): <code>USDT {{ number_format($highest_active_pkg,2) }}</code>
                            <br>
                            HIGHEST ACTIVE PACKAGE FOR {{ $bonus_cal_date }}: <code>USDT {{ $highest_active_pkg_for_period }}</code>
                            <br>
                            <br>
                            TOTAL TEAM INVESTMENT: <code>USDT {{ number_format($summery->total_team_investment,2) }}</code>
                            <br>
                            MONTHLY TEAM INVESTMENT: <code>USDT {{ number_format($summery->monthly_total_team_investment,2) }}</code>
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="rewards-requirements" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14">RANK</th>
                                <th class="fs-14">STATUS</th>
                                <th class="fs-14">REQUIREMENTS</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ranks_eligible_gifts as $rank => $requirement)
                                <tr>
                                    <td>Rank 0{{ $rank }}</td>
                                    <td>
                                        @if($rank <= $current_rank &&
                                                $summery->monthly_total_team_investment>= $requirement->total_team_investment &&
                                                $highest_active_pkg_for_period >= $requirement->active_investment)
                                            QUALIFIED
                                        @else
                                            NOT QUALIFIED
                                        @endif
                                    </td>
                                    <td>
                                        Investment: <code class=''>{{ $requirement->active_investment }}</code><br>
                                        Monthly Team: <code class=''>{{ $requirement->total_team_investment }}</code><br>
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

    @push('scripts')
    @endpush
</x-backend.layouts.app>
