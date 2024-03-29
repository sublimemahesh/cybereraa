<x-backend.layouts.app>
    @section('title', 'Purchased Staking cancellation')
    @section('header-title', 'Purchased Staking cancellation' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('user.staking-packages.dashboard') }}">Staking</a>
        </li>
        <li class="breadcrumb-item">Request Cancellation</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('cancel', $purchase)
                        <div class="mb-4">
                            <a class="btn btn-dark btn-xs btn-rounded" href="{{ route('user.staking-cancel-request.request', $purchase) }}">
                                Request Cancellation
                            </a>
                        </div>
                        <hr>
                    @endcan
                    <div class="mb-4">
                        <h4 class="card-title">{{ $purchase->stakingPlan->package->name }} {{ $purchase->stakingPlan->name }} - Cancellation</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table display mb-1 table-responsive-my dt-responsive" style="table-layout: fixed">
                            <thead>
                            <tr>
                                <th class="fs-14">ACTION</th>
                                <th class="fs-14">STATUS</th>
                                <th class="fs-14">REMARK</th>
                                <th class="fs-14">REPUDIATE NOTE</th>
                                <th class="fs-14">RELEASED</th>
                                <th class="fs-14">PROCESSED</th>
                                <th class="fs-14">APPROVED</th>
                                <th class="fs-14">REJECT</th>
                                <th class="fs-14">CANCELLED</th>
                                <th class="fs-14">CREATED</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cancel_requests as  $cancellation)
                                <tr>
                                    <td>
                                        @can('reverseCancel', $cancellation)
                                            <a href="{{ route('user.staking-cancel-request.reverse', $cancellation) }}" class="btn btn-xs btn-warning sharp my-1 mr-1 shadow">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    <td>{{ $cancellation->status }}</td>
                                    <td class="text-wrap">{{ $cancellation->remark }}</td>
                                    <td class="text-wrap">{{ $cancellation->repudiate_note }}</td>
                                    <td>
                                        Interest: {{ $cancellation->interest_rate }}% <br>
                                        Released: {{ $cancellation->total_released_amount }}
                                    </td>
                                    <td class="text-wrap">{{ $cancellation->processed_at }}</td>
                                    <td class="text-wrap">{{ $cancellation->approved_at }}</td>
                                    <td class="text-wrap">{{ $cancellation->reject_at }}</td>
                                    <td class="text-wrap">{{ $cancellation->cancelled_at }}</td>
                                    <td class="text-wrap">{{ $cancellation->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"> NO CANCELLATION REQUESTS</td>
                                </tr>
                            @endforelse
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
