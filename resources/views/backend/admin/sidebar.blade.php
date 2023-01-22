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
            {{-- <li>
                 <a href="{{ route('admin.packages.buyBackage') }}" class="" aria-expanded="false">
                     <i class="bi bi-wifi"></i>
                     <span class="nav-text">Purchase Package</span>
                 </a>
             </li>--}}
            <li>
                <a href="{{ route('admin.users.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Manage Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.wallet.topup') }}" class="" aria-expanded="false">
                    <i class="bi bi-send-plus"></i>
                    <span class="nav-text">Topup Wallet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.wallet.topup.history') }}" class="" aria-expanded="false">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span class="nav-text">Topup History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.genealogy') }}" class="" aria-expanded="false">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span class="nav-text">User Genealogy</span>
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
                            Commissions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.incomes.rewards', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .'to'.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                            Rewards
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.ranks.gifts') }}" class="" aria-expanded="false">
                    <i class="bi bi-trophy-fill"></i>
                    <span class="nav-text"> Rank Gifts </span>
                </a>
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
                        <a href="{{ route('admin.blogs.index') }}">Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.currencies.index') }}">Currencies</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">app_registration</i>
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
            <li>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="bi bi-question-diamond"></i>
                    <span class="nav-text"> Support Ticket </span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.support.tickets.index') }}"> User Tickets</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.support.tickets.category.create') }}">Ticket Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.support.tickets.priority.create') }}">Ticket Priorities
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.support.tickets.status.create') }}">Ticket Statuses
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.testimonials.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-wifi"></i>
                    <span class="nav-text">Testimonials</span>
                </a>
            </li>
            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
