<!--********************************** Sidebar start ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false">
                    <i class="bi bi-grid"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index', ['status' => 'paid','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                    <i class="bi fa-chain-broken"></i>
                    <span class="nav-text"> User Payments </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.earnings.index', ['status' => 'received','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                    <i class="bi bi-cash-stack"></i>
                    <span class="nav-text"> User Earnings </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.p2p', ['status' => 'success','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                    <i class="bi fa-arrow-turn-down"></i>
                    <span class="nav-text"> P2P Transactions </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.withdrawals', ['status' => 'processing','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                    <i class="bi fa-arrow-turn-up"></i>
                    <span class="nav-text"> Withdrawals </span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-currency-exchange"></i>
                    <span class="nav-text"> User Incomes</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.incomes.commission', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                            <span class="nav-text">Commissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.incomes.rewards', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                            <span class="nav-text">Rewards</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Packages</span>
                </a>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">book</i>
                    <span class="nav-text">CMS</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.countries.index') }}">Country</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pages.index') }}">Pages</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blogs.index') }}">Bloge</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.currencies.index') }}">Currencies</a>
                    </li>
                </ul>
            </li>


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">book</i>
                    <span class="nav-text">Strategies</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.strategies.withdrawal.index') }}">Withdrawal</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.strategies.rank-level.index') }}">Rank level</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.strategies.commissions.index') }}">Commissions</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.strategies.daily-leverages') }}">Daily Leverages</a>
                    </li>

                </ul>
            </li>


            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
