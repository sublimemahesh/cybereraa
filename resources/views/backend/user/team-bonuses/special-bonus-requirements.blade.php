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
        @include('backend.user.ranks.top-nav')

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Special bonus requirements</h4>
                        <p>
                            ACHIEVED DIRECT SALES:<code>{{ $direct_sales }}</code>
                            <br/>
                        <hr/>
                        User ID: <code>{{ Auth::user()->id }}</code> | Username: <code>{{ Auth::user()->username }}</code>
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="rewards-requirements" class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                                <tr>
                                    <th class="fs-14">BONUS</th>
                                    <th class="fs-14">STATUS</th>
                                    <th class="fs-14">REQUIREMENTS</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($special_bonus_requirement as $type => $requirement)

                                    @php
                                        if($type === 1){
                                            $bonus = $bonuses->where('bonus', '10_DIRECT_SALE')->firstOrNew();
                                        }
                                        if($type === 2){
                                            $bonus = $bonuses->where('bonus', '20_DIRECT_SALE')->firstOrNew();
                                        }
                                        if($type === 3){
                                            $bonus = $bonuses->where('bonus', '30_DIRECT_SALE')->firstOrNew();
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $requirement['direct_sales'] }} DIRECT SALE</td>
                                        <td>
                                            @if($bonus->status === 'QUALIFIED')
                                                {{ $bonus->status }} <br>
                                                RECEIVED: {{ $bonus->amount }} $
                                            @else
                                                @if($bonus->bonus === '10_DIRECT_SALE' &&
                                                    $total_direct_team_investment>= $requirement['total_investment'] &&
                                                    $direct_sales >= $requirement['direct_sales'])
                                                    QUALIFIED
                                                @else
                                                    NOT QUALIFIED
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            Direct Sales: <code class=''>{{ $requirement['direct_sales'] }}</code><br>
                                            Team Investment: <code class=''>{{ $requirement['total_investment'] }}</code><br>
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
        <script src="{{ asset('assets/backend/js/user/ranks/bonus-requirement.js') }}"></script>
    @endpush
</x-backend.layouts.app>
