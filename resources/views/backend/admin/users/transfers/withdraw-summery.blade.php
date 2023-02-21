<x-backend.layouts.app>
    @section('title', 'Withdraw Request Summery | Payouts')
    @section('header-title', 'Withdraw Request Summery')
    @section('plugin-styles')
        <!-- Datatable -->
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Withdraws</li>
        <li class="breadcrumb-item active">Withdraw Summery</li>
    @endsection

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        TRANSACTION ID: <code>#{{ str_pad($withdraw->id,4,0,STR_PAD_LEFT) }}</code> <br/>
                        Wallet: <code>{{ $withdraw->wallet_type }}</code><br/>
                        Withdraw Type: <code>{{ $withdraw->type }}</code><br/>
                        <hr/>
                        User ID: <code>{{ $withdraw->user_id }}</code><br/>
                        Username: <code>{{ $withdraw->user->username }}</code><br/>
                        Full Name: <code>{{ $withdraw->user->name }}</code><br/>
                        Email: <code>{{ $withdraw->user->email }}</code>
                        <br/>
                        <hr/>
                        Balance: <code>USDT {{ $withdraw->user->wallet->balance }}</code> <br/>
                        Payout limit: <code>USDT {{ $withdraw->user->wallet->withdraw_limit }}</code>
                        <hr/>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3 mt-2">
                                <label for="withdraw-amount">
                                    Requested Withdrawal Amount
                                </label>
                                <div class="form-control">{{ $withdraw->amount }}</div>
                                <div class="text-info">
                                    Transactions Fee: <code>{{ number_format($withdraw->transaction_fee,2) }}</code> /
                                    Total: <code>{{ number_format($withdraw->amount + $withdraw->transaction_fee,2) }}</code>
                                </div>
                            </div>
                            <div class="mb-3 mt-2">
                                <label for="remark">Remark</label>
                                <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->remark ?? '-' }}</div>
                            </div>
                            <div class="mb-3 mt-2">
                                <label for="payout_info">Payout Info</label>
                                <div id="payout_info" disabled rows="3" placeholder="Remark" class="form-control h-auto">
                                    <p class="mb-0"><b>Email:</b> {{ $payout_info->email }}</p>
                                    <p class="mb-0"><b>Id:</b> {{ $payout_info->id }}</p>
                                    <p class="mb-0"><b>Address:</b> {{ $payout_info->address }}</p>
                                    <p class="mb-0"><b>Phone:</b> {{ $payout_info->phone }}</p>
                                </div>
                                <div class="text-info">View Profile Details:
                                    @if(Auth::user()->hasRole('user'))
                                        <a href="{{ route('profile.show') }}">View Profile</a>
                                    @else
                                        <a href="{{ route('admin.users.profile.show', $withdraw->user) }}">View Profile</a>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 mt-2">
                                <label for="status">Status</label>
                                <div class="form-control h-100" style="min-height: 50px">
                                    Status: {{ $withdraw->status }} <br>
                                    Requested at: {{ $withdraw->created_at }} <br>
                                    @switch($withdraw->status)
                                        @case('SUCCESS')
                                            Processed at: {{ $withdraw->processed_at }} <br>
                                            Approved at: {{ $withdraw->approved_at }} <br>
                                            @if($withdraw->proof_document !== null)
                                                <div class="mb-3 mt-2">
                                                    <div class="text-info">
                                                        <label for="proof_document">Proof: </label>
                                                        <a href="{{ asset('storage/payouts/manual/' . $withdraw->proof_document) }}" target="_blank">View Proof</a>
                                                    </div>
                                                </div>
                                            @endif
                                            @break
                                        @case('PROCESSING')
                                            Processed at: {{ $withdraw->processed_at }} <br>
                                            @break
                                        @case('CANCELLED')
                                            Cancelled at: {{ $withdraw->cancelled_at }} <br>
                                            Reason: {{ $withdraw->repudiate_note }}
                                            @break
                                        @case('REJECT')
                                            Reject at: {{ $withdraw->reject_at }} <br>
                                            Reason: {{ $withdraw->repudiate_note }}
                                            @break
                                        @case('FAIL')
                                            Failed at: {{ $withdraw->failed_at }} <br>
                                            Reason: {{ $withdraw->repudiate_note }}
                                            @break
                                    @endswitch
                                </div>
                            </div>
                            @if($withdraw->expired_packages !== null)
                                <div class="mb-3 mt-2">
                                    <label for="remark">Expired Packages</label>
                                    <div class="form-control h-100" style="min-height: 50px">{{ $withdraw->expired_packages }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    @endpush
</x-backend.layouts.app>
