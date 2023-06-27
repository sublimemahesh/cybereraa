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
            @include('backend.user.ranks.top-nav')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rewards-requirements" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14">RANK</th>
                                <th class="fs-14">YOUR ELIGIBILITY</th>
                                <th class="fs-14">COUNT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ranks as $rank)
                                <tr>
                                    <td>Rank {{ $rank->rank }}</td>
                                    <td>
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between">
                                                <h6> {{ $rank->eligibility_percentage }}%</h6>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: {{ $rank->eligibility_percentage }}%"></div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        {{ $rank->total_rankers }}
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
