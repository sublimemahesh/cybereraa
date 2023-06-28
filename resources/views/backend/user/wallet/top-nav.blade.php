<div class="col-12">
    <div class="">
        <div class="card-header border-0  flex-wrap">
            <nav>
                <div class="order nav nav-tabs">
                    <a class="nav-link {{ request()->routeIs('user.wallet.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.index') ? route('user.wallet.index') : 'javascript:void(0)' }}">Current Wallet</a>
                    <a class="nav-link {{ request()->routeIs('user.wallet.transfer.to-wallet') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.transfer.to-wallet') ? route('user.wallet.transfer.to-wallet') : 'javascript:void(0)' }}">Between Wallet Transfer</a>
                    <a class="nav-link {{ request()->routeIs('user.wallet.transfer') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.transfer') ? route('user.wallet.transfer') : 'javascript:void(0)' }}">Transfer Funds (P2P)</a>
                    <a class="nav-link {{ request()->routeIs('user.wallet.withdraw') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.withdraw') ? route('user.wallet.withdraw') : 'javascript:void(0)' }}">Withdraw Funds</a>
                    <a class="nav-link {{ request()->routeIs('user.transfers.p2p') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transfers.p2p') ? route('user.transfers.p2p', ['status' => 'success']) : 'javascript:void(0)' }}">P2P History</a>
                    <a class="nav-link {{ request()->routeIs('user.transfers.withdrawals') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transfers.withdrawals') ? route('user.transfers.withdrawals') : 'javascript:void(0)' }}">Withdrawal History</a>
                </div>
            </nav>
        </div>
    </div>
</div>
