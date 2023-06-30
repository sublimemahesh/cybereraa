<x-backend.layouts.app>
    @section('title', 'Topup Request | Wallets')
    @section('header-title', 'Topup Request | Wallets' )
    @section('plugin-styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Topup Request | Wallets</li>
    @endsection
    <div class="row">
        @include('backend.user.wallet.top-nav')
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Topup Request</h4>
                        <p>
                            Request <code>USDT</code> directly to your topup wallet. Make deposit to our binance account and send us a receipt.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="topup-form" encryption="multipart/form-data">
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Request Amount</label>
                                    <input name="amount" data-input="form-input" min="1" id="transfer-amount" type="number" class="form-control">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="proof-documentation">Receipt</label>
                                    <input name="proof_documentation" id="proof-documentation" data-input="form-input" type="file" class="form-control" accept="image/*,application/pdf">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark</label>
                                    <textarea name="remark" id="remark" rows="3" type="number" placeholder="Enter your remarks, Ex: Transaction IDs" data-input="form-input" class="form-control h-auto"></textarea>
                                </div>
                                <hr>
                                <button type="submit" id="confirm-topup" class="btn btn-sm btn-success mb-2">Confirm & Request</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/js/user/wallet/request-topup.js') }}"></script>
    @endpush
</x-backend.layouts.app>
