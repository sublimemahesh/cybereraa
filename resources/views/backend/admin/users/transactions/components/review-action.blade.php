<div class="card mb-0">
    <div class="card-body">
        <form class="theme-form" enctype="multipart/form-data" id="approval-form">
            {{-- <div class="mb-2">
                 <h4 class="card-title">Approve/Reject Transaction</h4>
                 <hr>
             </div>--}}
            <div class="row">
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <p data-devil="fs:15"><b>Payment id:</b> {{ $transaction->id }}</p>
                                <p data-devil="fs:15"><b>User:</b> {{ $transaction->user_id }} - {{ $transaction->user->username }}</p>
                                <p data-devil="fs:15"><b>Purchased By:</b> {{ $transaction->purchaser_id }} - {{
                                                $transaction->purchaser->username }}</p>
                                <p data-devil="fs:15"><b>Package:</b> {{ $transaction->create_order_request_info->goods->goodsName ??
                                                '-' }}</p>
                                <p data-devil="fs:15"><b>Currency:</b> {{ $transaction->currency }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-2">

                                <p data-devil="fs:15"><b>Amount:</b> {{ $transaction->amount }}USDT</p>
                                <p data-devil="fs:15"><b>Gas Fee: </b> {{ $transaction->gas_fee }}USDT</p>
                                <p data-devil="fs:15"><b>Pay Method:</b> {{ $transaction->type }}/{{ $transaction->pay_method }}</p>
                                @if($transaction->status === 'REJECTED')
                                    <p data-devil="fs:15"><b>Repudiate note:</b> {{ $transaction->repudiate_note }}</p>
                                @endif
                                <p data-devil="fs:15"><b>Status:</b> {{ $transaction->status }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="fs-30 text-center font-w600" data-devil="c:#fff mb:15" id="transaction-total-amount" data-edit-url="{{ URL::signedRoute('admin.transactions.edit-amount', $transaction) }}" data-transaction-amount="{{ $transaction->amount }}">
                            Total Amount: {{ $transaction->amount + $transaction->gas_fee }}
                            <small> USDT</small>
                            <span class="cursor-pointer" id="edit-transaction-amount" data-transaction-id="{{ $transaction->id }}">
                                <i class="fa fa-pencil fs-26"></i>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <div class="mb-2 mt-2">
                                <div class="text-info">
                                    <label for="proof_document">Proof:</label>
                                    <a href="{{ asset('storage/user/manual-purchase/' . $transaction->proof_document) }}"
                                       target="_blank">View Proof
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3 mt-1">
                                <div class="text-info">
                                    <label for="proof_document">Transaction ID:</label>
                                    <a href="javascript:void(0)" data-clipboard-text="{{ $transaction->transaction_id }}" id="copy-to-clipboard" class="copy-to-clipboard d-flex form-control justify-content-between" title="Copy to Clipboard">
                                        {{$transaction->transaction_id }}
                                        <i class="fa fa-clone my-auto" style="font-size: 17px;" data-devil="ml:5"></i>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <p>
                                Please confirm access to your account by entering the <code>password</code>
                                and
                                <code>authentication code</code> provided by your authenticator application
                            </p>

                            <div class="mb-3 mt-2">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" data-input='payout'
                                       class="form-control" autocomplete="new-password">
                            </div>
                            @if(Auth::user()?->two_factor_secret && in_array(
                            \Laravel\Fortify\TwoFactorAuthenticatable::class,
                            class_uses_recursive(Auth::user()),true))
                                <div class="mb-3 mt-2">
                                    <label for="code">Two Factor code / Recovery Code</label>
                                    <input id="code" name="code" type="password" data-input='payout'
                                           class="form-control" autocomplete="one-time-password"
                                           placeholder="2FA code OR Recovery Code">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly mt-2" id="actions-container">
                        <button class="btn btn-success" id="approveTrx">APPROVE</button>
                        <button id="reject-trx" class="btn btn-danger">REJECT</button>
                    </div>
                </div>
                <div class="col-sm-5 m-auto text-center">
                    <img src="{{ storage('user/manual-purchase/' . $transaction->proof_document) }}" alt=""
                         class="img-thumbnail mw-100" data-devil="mt:-92" data-dxs="mt:15">
                </div>
            </div>
        </form>
    </div>
</div>
