{{-- <li>
     <a href="{{ route('admin.packages.buyBackage') }}" class="" aria-expanded="false">
         <i class="bi bi-wifi"></i>
         <span class="nav-text">Purchase Package</span>
     </a>
 </li>--}}
@canany(['users.viewAny','kyc.viewAny'])
    <li>
        <a href="{{ route('admin.users.index') }}" class="" aria-expanded="false">
            <i class="bi bi-people-fill"></i>
            <span class="nav-text">Manage Users</span>
        </a>
    </li>
@endcan
@canany(['users.manage-permissions','admin.users.viewAny'])
    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-icons fs-28" style="margin-right: 5px !important;">manage_accounts</i>
            <span class="nav-text">User Roles</span>
        </a>
        <ul aria-expanded="false">
            @can('permission.manage')
                <li>
                    <a href="{{ route('super_admin.permissions.index') }}">Permissions</a>
                </li>
            @endcan
            @can('role.manage')
                <li>
                    <a href="{{ route('super_admin.roles.index') }}">Roles</a>
                </li>
            @endcan
            <li>
                <a href="{{ route('super_admin.users.index') }}">Users</a>
            </li>
        </ul>
    </li>
@endcan
@can('wallet.topup')
    <li>
        <a href="{{ route('admin.wallet.topup') }}" class="" aria-expanded="false">
            <i class="bi bi-send-plus"></i>
            <span class="nav-text">Topup Wallet</span>
        </a>
    </li>
@endcan
@can('wallet.topup-history.viewAny')
    <li>
        <a href="{{ route('admin.wallet.topup.history') }}" class="" aria-expanded="false">
            <i class="bi bi-receipt-cutoff"></i>
            <span class="nav-text">Topup History</span>
        </a>
    </li>
@endcan
@can('users.genealogy')
    <li>
        <a href="{{ URL::signedRoute('admin.genealogy') }}" class="" aria-expanded="false">
            <i class="bi bi-diagram-3-fill"></i>
            <span class="nav-text">User Genealogy</span>
        </a>
    </li>
@endcan
@can('transactions.viewAny')
    <li>
        <a href="{{ route('admin.transactions.index', ['date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
            <i class="bi fa-chain-broken"></i>
            <span class="nav-text"> User Payments </span>
        </a>
    </li>
@endcan
@can('purchase_packages.viewAny')
    <li>
        <a href="{{ route('admin.purchased-packages', ['date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
            <i class="bi bi-box"></i>
            <span class="nav-text"> User Packages </span>
        </a>
    </li>
@endcan
@can('earnings.viewAny')
    <li>
        <a href="{{ route('admin.earnings.index', ['status' => 'received','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
            <i class="bi bi-cash-stack"></i>
            <span class="nav-text"> User Earnings </span>
        </a>
    </li>
@endcan

@can('withdraw.p2p.viewAny')
    <li>
        <a href="{{ route('admin.transfers.p2p', ['status' => 'success','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
            <i class="bi fa-arrow-turn-down"></i>
            <span class="nav-text"> P2P Transactions </span>
        </a>
    </li>
@endcan

@can('withdrawals.viewAny')
    <li>
        <a href="{{ route('admin.transfers.withdrawals', ['status' => 'pending']) }}" class="" aria-expanded="false">
            <i class="bi fa-arrow-turn-up"></i>
            <span class="nav-text"> Withdrawals </span>
        </a>
    </li>
@endcan

@canany(['commissions.viewAny', 'rank_bonus.viewAny'])
    <li>
        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
            <i class="bi bi-currency-exchange"></i>
            <span class="nav-text"> User Incomes</span>
        </a>
        <ul aria-expanded="false">
            @can('commissions.viewAny')
                <li>
                    <a href="{{ route('admin.incomes.commission', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                        Commissions
                    </a>
                </li>
            @endcan
            @can('rank_bonus.viewAny')
                <li>
                    <a href="{{ route('admin.incomes.rewards', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}" class="" aria-expanded="false">
                        Rewards
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

@can('rank_gift.viewAny')
    <li>
        <a href="{{ route('admin.ranks.gifts') }}" class="" aria-expanded="false">
            <i class="bi bi-trophy-fill"></i>
            <span class="nav-text"> Rank Gifts </span>
        </a>
    </li>
@endcan

@can('package.viewAny')
    <li>
        <a href="{{ route('admin.packages.index') }}" class="" aria-expanded="false">
            <i class="bi bi-stack"></i>
            <span class="nav-text">Packages</span>
        </a>
    </li>
@endcan
@canany(['country.viewAny','page.viewAny','blogs.viewAny', 'currency.viewAny'])
    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="material-icons">book</i>
            <span class="nav-text">CMS</span>
        </a>
        <ul aria-expanded="false">
            @can('blogs.viewAny')
                <li>
                    <a href="{{ route('admin.blogs.index') }}">Blog</a>
                </li>
            @endcan
            @can('page.viewAny')
                <li>
                    <a href="{{ route('admin.pages.index') }}">Pages</a>
                </li>
            @endcan
            @can('country.viewAny')
                <li>
                    <a href="{{ route('admin.countries.index') }}">Countries</a>
                </li>
            @endcan
            @can('currency.viewAny')
                <li>
                    <a href="{{ route('admin.currencies.index') }}">Currencies</a>
                </li>
            @endcan
            @can('testimonial.viewAny')
                <li>
                    <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
@can('strategy.viewAny')
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
@endcan
@canany(['support_ticket.viewAny','support_ticket.category.viewAny','support_ticket.priority.viewAny','support_ticket.status.viewAny'])
    <li>
        <a class="has-arrow" href="javascript:void(0)">
            <i class="bi bi-question-diamond"></i>
            <span class="nav-text"> Support Ticket </span>
        </a>
        <ul>
            @can('support_ticket.viewAny')
                <li>
                    <a href="{{ route('admin.support.tickets.index') }}"> User Tickets</a>
                </li>
            @endcan
            @can('support_ticket.category.viewAny')
                <li>
                    <a href="{{ route('admin.support.tickets.category.create') }}">Ticket Categories
                    </a>
                </li>
            @endcan
            @can('support_ticket.priority.viewAny')
                <li>
                    <a href="{{ route('admin.support.tickets.priority.create') }}">Ticket Priorities
                    </a>
                </li>
            @endcan
            @can('support_ticket.status.viewAny')
                <li>
                    <a href="{{ route('admin.support.tickets.status.create') }}">Ticket Statuses
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
