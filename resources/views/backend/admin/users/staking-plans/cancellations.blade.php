<x-backend.layouts.app>
    @section('title', 'Purchased Staking cancellation')
    @section('header-title', 'Purchased Staking cancellation' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.staking-purchased-packages') }}">Staking</a>
        </li>
        <li class="breadcrumb-item">Review Cancellation</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">{{ $purchase->stakingPlan->package->name }} {{ $purchase->stakingPlan->name }} - Cancellation</h4>
                        <p>
                            <b>Package: </b> {{ $plan->name }} <br>
                            <b>Price: </b>USDT {{ $package->amount }} <br>
                            <b>Duration: </b>{{ $plan->duration }} Days <br>
                            <b>Interest: </b>{{ $plan->interest_rate }}% <br>
                            <b>Maturity Date: </b>{{ $purchase->maturity_date }}
                        </p>
                        <p>
                            <b>Username:</b> <code>{{ $purchase->user->username }}</code> <br>
                            <b>Email:</b> {{ $purchase->user->email }} <br>
                            <b>Phone:</b> {{ $purchase->user->phone }} <br>
                        </p>
                    </div>
                    <hr>
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
                                        @can('process', $cancellation)
                                            <a href="javascript:void(0)" data-id="{{ $cancellation->id }}" class="process-request btn btn btn-xs btn-google sharp sharp my-1 mr-1 shadow">
                                                <i class="fa fa-history"></i>
                                            </a>
                                        @endcan
                                        @can('approve', $cancellation)
                                            <a href="{{ route('admin.staking-cancel-request.approve', $cancellation) }}" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                                <i class="fa fa-check-double"></i>
                                            </a>
                                        @endcan
                                        @can('reject', $cancellation)
                                            <a href="{{ route('admin.staking-cancel-request.reject', $cancellation) }}" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
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
        <script !src="">
            $(document).on("click", ".process-request", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are You Sure?",
                    text: "Process This Request?. Please note this process cannot be reversed.",
                    icon: "info",
                    showCancelButton: true,
                }).then((process) => {
                    if (process.isConfirmed) {
                        loader()
                        let cancelRequest = $(this).data('id')
                        // formData.append(proof_document, proof_document)
                        axios.post(`${APP_URL}/admin/reports/users/staking-purchased-packages/cancellations/${cancelRequest}/process`)
                            .then(response => {
                                Toast.fire({
                                    icon: response.data.icon, title: response.data.message,
                                }).then(res => {
                                    location.reload();
                                })
                            })
                            .catch((error) => {
                                Toast.fire({
                                    icon: 'error', title: error.response.data.message || "Something went wrong!",
                                })
                            })
                    }
                });
            });

        </script>
    @endpush
</x-backend.layouts.app>
