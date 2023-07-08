<div class="col-12">
    <div class="order nav nav-tabs">
        <a class="nav-link {{ request()->routeIs('user.wallet.index') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.index') ? route('user.wallet.index') : 'javascript:void(0)' }}">Wallet Hub</a>
        <a class="nav-link {{ request()->routeIs('user.wallet.request-topup-balance') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.request-topup-balance') ? route('user.wallet.request-topup-balance') : 'javascript:void(0)' }}">Request Topup</a>
        <a class="nav-link {{ request()->routeIs('user.wallet.topup-request.history') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.topup-request.history') ? route('user.wallet.topup-request.history') : 'javascript:void(0)' }}">Topup History</a>
        <a class="nav-link {{ request()->routeIs('user.wallet.transfer.to-wallet') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.transfer.to-wallet') ? route('user.wallet.transfer.to-wallet') : 'javascript:void(0)' }}">Wallet 2 Wallet Transfer</a>
        <a class="nav-link {{ request()->routeIs('user.wallet.transfer') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.transfer') ? route('user.wallet.transfer') : 'javascript:void(0)' }}">P2P Transfer</a>
        <a class="nav-link {{ request()->routeIs('user.transfers.p2p') && request()->input('filter') !== 'received' ? 'active' : '' }}" href="{{ !request()->routeIs('user.transfers.p2p') || request()->input('filter') === 'received' ? route('user.transfers.p2p', ['status' => 'success', 'filter' => 'sent']) : 'javascript:void(0)' }}">P2P History</a>
        <a class="nav-link {{ request()->routeIs('user.transfers.p2p') && request()->input('filter') === 'received' ? 'active' : '' }}" href="{{ !request()->routeIs('user.transfers.p2p') || request()->input('filter') !== 'received' ? route('user.transfers.p2p', ['status' => 'success', 'filter' => 'received']) : 'javascript:void(0)' }}">Received P2P</a>
        <a class="nav-link {{ request()->routeIs('user.wallet.withdraw') ? 'active' : '' }}" href="{{ !request()->routeIs('user.wallet.withdraw') ? route('user.wallet.withdraw') : 'javascript:void(0)' }}">Binance Transfer</a>
        <a class="nav-link {{ request()->routeIs('user.transfers.withdrawals') ? 'active' : '' }}" href="{{ !request()->routeIs('user.transfers.withdrawals') ? route('user.transfers.withdrawals') : 'javascript:void(0)' }}">Binance History</a> 
    </div>
</div>
