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
                                    <td>-</td>
                                    <td>{{ $cancellation->status }}</td>
                                    <td>{{ $cancellation->remark }}</td>
                                    <td>{{ $cancellation->repudiate_note }}</td>
                                    <td>{{ $cancellation->processed_at }}</td>
                                    <td>{{ $cancellation->approved_at }}</td>
                                    <td>{{ $cancellation->reject_at }}</td>
                                    <td>{{ $cancellation->cancelled_at }}</td>
                                    <td>{{ $cancellation->created_at }}</td>
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
