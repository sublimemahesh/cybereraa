<x-backend.layouts.app>
    @section('title', 'Team Rankers Count')
    @section('header-title', 'Team Rankers Count' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Rankers</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}

        <div class="col-12">
            @include('backend.user.teams.top-nav')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rewards-requirements" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14">LEVEL</th>
                                <th class="fs-14">REGISTER COUNT</th>
                                <th class="fs-14">PERCENTAGE</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($income_levels as $level)
                                <tr>
                                    <td>  {{ $numberFormatter->format($level->level) }} Level</td>
                                    <td>
                                        Registered Sales: {{ $level->member_count }}/{{ $level->total_possible_members }} <br>
                                        Active Sales: {{ $level->active_sales_count }}/{{ $level->member_count }}
                                    </td>
                                    <td>
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between">
                                                <h6> Registered Sales: {{ number_format(((int)$level->member_count * 100) / (int)$level->total_possible_members) }}%</h6>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: {{ number_format(($level->member_count * 100) / $level->total_possible_members) }}%"></div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <h6> Active Sales: {{ number_format(($level->active_sales_count/$level->member_count) * 100) }}%</h6>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: {{ number_format(($level->active_sales_count/$level->member_count) * 100) }}%"></div>
                                            </div>
                                        </div>
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
