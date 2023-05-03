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
                    <span class="nav-text">Buy Packages</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('user.staking-packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Staking Packages</span>
                </a>
            </li> --}}

            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Staking</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.staking-packages.index') }}" class="" aria-expanded="false">
                            <span class="nav-text">Staking Packages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.staking-packages.dashboard') }}" class="" aria-expanded="false">
                            <span class="nav-text">Staking Dashboard</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('user.packages.active') }}" class="" aria-expanded="false">
                    <i class="bi bi-box"></i>
                    <span class="nav-text">Active Packages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.genealogy') }}" class="" aria-expanded="false">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span class="nav-text">My Genealogy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.transactions.index') }}" class="" aria-expanded="false">
                    <i class="bi fa-chain-broken"></i>
                    <span class="nav-text">My Packages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.transactions.purchased.history') }}" class="" aria-expanded="false">
                    <i class="bi bi-clipboard-data"></i>
                    <span class="nav-text">Purchase History</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-currency-exchange"></i>
                    <span class="nav-text">My Income</span>
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
            @canany(['viewSummery','viewRequirement'], \App\Models\RankBonusSummery::class)
                <li>
                    <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                        <i class="bi bi-trophy-fill"></i>
                        <span class="nav-text"> Rank Bonus </span>
                    </a>
                    <ul aria-expanded="false">
                        @can('viewSummery', \App\Models\RankBonusSummery::class)
                            <li>
                                <a href="{{ route('user.ranks.benefits.summery') }}" class="" aria-expanded="false">
                                    <span class="nav-text">Summery</span>
                                </a>
                            </li>
                        @endcan
                        @can('viewRequirement', \App\Models\RankBonusSummery::class)
                            <li>
                                <a href="{{ route('user.ranks.benefits.requirements') }}" class=""
                                   aria-expanded="false">
                                    <span class="nav-text">Requirement</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <li>
                <a href="{{ route('user.ranks.gifts') }}" class="" aria-expanded="false">
                    <i class="bi bi-gift"></i>
                    <span class="nav-text"> Rank Gifts </span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.earnings.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-cash"></i>
                    <span class="nav-text">My Earning</span>
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
                        <a href="{{ route('user.wallet.transfer.to-wallet') }}">
                            <span>Between Wallet Transfer</span>
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
            <li>
                <a href="{{ route('user.transfers.p2p', ['status' => 'success']) }}" class="" aria-expanded="false">
                    <i class="bi fa-arrow-turn-down"></i>
                    <span class="nav-text"> P2P History </span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.transfers.withdrawals') }}" class="" aria-expanded="false">
                    <i class="bi fa-arrow-turn-up"></i>
                    <span class="nav-text"> Withdrawal History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.support.tickets.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-question-circle"></i>
                    <span class="nav-text">Support Ticket</span>
                </a>
            </li>
            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
