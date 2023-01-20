<x-backend.layouts.app>
    @section('title', 'Topup | Wallets')
    @section('header-title', 'Topup | Wallets' )
    @section('plugin-styles')
        <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item active">Topup | Wallets</li>
    @endsection
    <div class="row">
        <div class="col-xl-8 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="card-title">Topup</h4>
                        <p>
                            Send <code>USDT</code> directly to selected user. no transaction fee will be added.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="topup-form" encryption="multipart/form-data">
                                <div class="mb-3 mt-2">
                                    <label for="topup-user">Select User</label>
                                    <select name="receiver" class="single-select-placeholder js-states select2-hidden-accessible" id="topup-user">
                                        <option disabled>Start typing username</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="transfer-amount">Transfer Amount </label>
                                    <input name="amount" min="1" id="transfer-amount" type="number" class="form-control">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="proof-documentation">Receipt</label>
                                    <input name="proof_documentation" id="proof-documentation" type="file" class="form-control" accept="image/*,application/pdf">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="remark">Remark </label>
                                    <textarea name="remark" id="remark" type="number" class="form-control"> </textarea>
                                </div>
                                <hr>
                                <p>
                                    Please confirm access to your account by entering the <code>password</code> and
                                    <code>authentication code</code> provided by your authenticator application
                                </p>

                                <div class="mb-3 mt-2">
                                    <label for="password">Password</label>
                                    <input name="password" id="password" type="password" class="form-control" autocomplete="new-password">
                                </div>
                                @if(optional(Auth::user())->two_factor_secret && in_array( \Laravel\Fortify\TwoFactorAuthenticatable::class, class_uses_recursive(Auth::user()),true))
                                    <div class="mb-3 mt-2">
                                        <label for="code">Two Factor code / Recovery Code </label>
                                        <input name="code" id="code" type="password" class="form-control" autocomplete="one-time-password" placeholder="2FA code OR Recovery Code">
                                    </div>
                                @endif
                                <button type="submit" id="confirm-topup" class="btn btn-sm btn-success mb-2">Confirm & Transfer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

        <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/admin/users/wallets/topup.js') }}"></script>
    @endpush
</x-backend.layouts.app>
