<!--********************************** Sidebar start ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('user.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.kyc.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-file-earmark-check"></i>
                    <span class="nav-text">My KYC</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Buy Package</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.packages.active') }}" class="" aria-expanded="false">
                    <i class="bi bi-box"></i>
                    <span class="nav-text">Active Package</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.genealogy') }}" class="" aria-expanded="false">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span class="nav-text">My Genealogy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.transactions.index', ['status' => 'paid']) }}" class="" aria-expanded="false">
                    <i class="bi fa-chain-broken"></i>
                    <span class="nav-text">Transaction</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-currency-exchange"></i>
                    <span class="nav-text">My Incomes</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.incomes.commission') }}" class="" aria-expanded="false">
                            <span class="nav-text">Commissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.incomes.rewards') }}" class="" aria-expanded="false">
                            <span class="nav-text">Rewards</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('user.earnings.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-cash"></i>
                    <span class="nav-text">My Earnings</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-wallet2"></i>
                    <span class="nav-text">My Wallet</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.wallet.index') }}" class="" aria-expanded="false">
                            <span class="nav-text">Current Wallet</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.wallet.transfer') }}">
                            <span>Transfer Funds</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.wallet.withdraw') }}">
                            <span>Withdraw Funds</span>
                        </a>
                    </li>
                </ul>
            </li>
            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
