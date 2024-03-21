{{-- <li>
     <a href="{{ route('admin.packages.buyBackage') }}" class="" aria-expanded="false">
         <i class="bi bi-wifi"></i>
         <span class="nav-text">Purchase Package</span>
     </a>
 </li>--}}
@can('transactions.viewAny')
    {{--<li>
        <a href="{{ route('admin.transactions.index', ['date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}"
           class="" aria-expanded="false">
            <i class="bi fa-chain-broken"></i>
            <span class="nav-text"> User Payments </span>
        </a>
    </li>--}}
    <li>
        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
            <i class="bi fa-chain-broken"></i>
            <span class="nav-text"> User Payments </span>
            @if($counts['pending_transactions'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['pending_transactions'] }}</span>
            @endif
        </a>
        <ul aria-expanded="false">
            <li>
                <a href="{{ route('admin.transactions.index') }}" class="" aria-expanded="false">
                    All Payments
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="" aria-expanded="false">
                    Pending Payments
                    @if($counts['pending_transactions'] > 0)
                        <span class="sidebar-pending-notification">{{ $counts['pending_transactions'] }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index', ['status' => 'paid']) }}"
                   class="" aria-expanded="false">
                    Approved Payments
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index', ['status' => 'rejected']) }}"
                   class="" aria-expanded="false">
                    Rejected Payments
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('kyc.viewAny')
    <li>
        <a href="{{ route('admin.users.pending.kycs') }}" class="" aria-expanded="false">
            <i class="bi bi-bag-check"></i>
            <span class="nav-text">Pending KYC</span>
            @if($counts['pending_kycs'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['pending_kycs'] }}</span>
            @endif
        </a>
    </li>
@endcan

@can('withdrawals.viewAny')
    <li>
        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
            <i class="bi fa-arrow-turn-up"></i>
            <span class="nav-text"> Withdrawals </span>
            @if($counts['pending_n_processing_withdrawals'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['pending_n_processing_withdrawals'] }}</span>
            @endif
        </a>
        <ul aria-expanded="false">
            <li>
                <a href="{{ route('admin.transfers.withdrawals') }}"
                   class="" aria-expanded="false">
                    All Withdrawals
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.withdrawals', ['status' => 'pending']) }}"
                   class="" aria-expanded="false">
                    Pending
                    @if($counts['pending_withdrawals'] > 0)
                        <span class="sidebar-pending-notification">{{ $counts['pending_withdrawals'] }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.withdrawals', ['status' => 'processing']) }}" class="" aria-expanded="false">
                    Processing
                    @if($counts['processing_withdrawals'] > 0)
                        <span class="sidebar-pending-notification">{{ $counts['processing_withdrawals'] }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.withdrawals', ['status' => 'success']) }}"
                   class="" aria-expanded="false">
                    Approved
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transfers.withdrawals', ['status' => 'reject']) }}"
                   class="" aria-expanded="false">
                    Rejected
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('users.genealogy')
    <li>
        <a href="{{ route('admin.team.users-list') }}" class="" aria-expanded="false">
            <i class="bi bi-diagram-3-fill"></i>
            <span class="nav-text">User Levels</span>
        </a>
    </li>
@endcan

@canany(['support_ticket.viewAny','support_ticket.category.viewAny','support_ticket.priority.viewAny','support_ticket.status.viewAny'])
    <li>
        <a class="has-arrow" href="javascript:void(0)">
            <i class="bi bi-question-diamond"></i>
            <span class="nav-text"> Support Ticket </span>
            @if($counts['open_support_tickets'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['open_support_tickets'] }}</span>
            @endif
        </a>
        <ul>
            @can('support_ticket.viewAny')
                <li>
                    <a href="{{ route('admin.support.tickets.index') }}"> User Tickets
                        @if($counts['open_support_tickets'] > 0)
                            <span class="sidebar-pending-notification">{{ $counts['open_support_tickets'] }}</span>
                        @endif
                    </a>
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

@can('trader.viewAny')
    <li>
        <a href="{{ route('admin.traders.index') }}" class="" aria-expanded="false">
            <i class="bi bi-person-lines-fill"></i>
            <span class="nav-text">Traders</span>
        </a>
    </li>
@endcan

@canany(['admin_wallet.viewAny','admin_wallet_transactions.viewAny','admin_wallet_withdrawal.viewAny'])
    <li>
        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
            <i class="bi bi-wallet"></i>
            <span class="nav-text">Admin Wallet</span>
        </a>
        <ul aria-expanded="false">
            @can('admin_wallet.viewAny')
                <li>
                    <a href="{{ route('admin.admin-wallet-profits') }}">Wallets</a>
                </li>
            @endcan
            @can('admin_wallet_transactions.viewAny')
                <li>
                    <a href="{{ route('admin.admin-wallet-transaction.index') }}">History</a>
                </li>
            @endcan
            @can('admin_wallet_withdrawal.viewAny')
                <li>
                    <a href="{{ route('admin.admin-wallet-withdrawal.index') }}">Withdrawal</a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

@can('users.viewAny')
    <li>
        <a href="{{ route('admin.users.index') }}" class="" aria-expanded="false">
            <i class="bi bi-people-fill"></i>
            <span class="nav-text">Manage Users</span>
        </a>
    </li>
@endcan

{{--@can('users.import-bulk')
    <li>
        <a href="{{ route('admin.users.import') }}" class="" aria-expanded="false">
            <i class="bi bi-person-up"></i>
            <span class="nav-text">Import Users</span>
        </a>
    </li>
@endcan--}}

@can('users.custom-free-package.purchase')
    <li>
        <a href="{{ route('admin.users.custom-investment') }}" class="" aria-expanded="false">
            <i class="bi bi-person-up"></i>
            <span class="nav-text">Custom Investment</span>
        </a>
    </li>
@endcan

@can('company_users.viewAny')
    <li>
        <a href="{{ route('admin.reports.company-users') }}" class="" aria-expanded="false">
            <i class="bi bi-person-lines-fill"></i>
            <span class="nav-text">Company Users</span>
        </a>
    </li>
@endcan

@can('purchase_packages.viewAny')
    <li>
        <a href="{{ route('admin.purchased-packages', ['date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}"
           class="" aria-expanded="false">
            <i class="bi bi-box"></i>
            <span class="nav-text"> User Packages </span>
        </a>
    </li>
@endcan

@can('earnings.viewAny')
    <li>
        <a href="{{ route('admin.earnings.index', ['status' => 'received',/*'date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')*/]) }}"
           class="" aria-expanded="false">
            <i class="bi bi-cash-stack"></i>
            <span class="nav-text"> User Earnings </span>
            @if($counts['earningPendingActivePackages'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['earningPendingActivePackages'] }}</span>
            @endif
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
                    <a href="{{ route('admin.incomes.commission', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}"
                       class="" aria-expanded="false">
                        Commissions
                    </a>
                </li>
            @endcan
            {{--@can('rank_bonus.viewAny')
                <li>
                    <a href="{{ route('admin.incomes.rewards', ['status' => 'qualified','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}"
                       class="" aria-expanded="false">
                        Rewards
                    </a>
                </li>
            @endcan--}}
        </ul>
    </li>
@endcan

@can('rank_bonus.viewAny')
    <li>
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <i class="bi bi-trophy-fill"></i>
            <span class="nav-text"> Ranks System </span>
            @if($counts['pending_rank_activations'] > 0)
                <span class="sidebar-pending-notification">{{ $counts['pending_rank_activations'] }}</span>
            @endif
        </a>
        <ul aria-expanded="false">
            <li>
                <a href="{{ route('admin.ranks', ['status'=>'active']) }}" class="" aria-expanded="false">
                    <span class="nav-text">Ranks</span>
                    @if($counts['pending_rank_activations'] > 0)
                        <span class="sidebar-pending-notification">{{ $counts['pending_rank_activations'] }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.incomes.rewards') }}" class="" aria-expanded="false">
                    <span class="nav-text">Rewards</span>
                </a>
            </li>
            {{-- <li>
                 <a href="{{ route('admin.ranks.benefits.summery') }}" class="" aria-expanded="false">
                     <span class="nav-text">Summery</span>
                 </a>
             </li>--}}
            {{--<li>
                <a href="{{ route('admin.ranks.benefits.requirements') }}" class="" aria-expanded="false">
                    <span class="nav-text">Requirement</span>
                </a>
            </li>--}}
        </ul>
    </li>
@endcan
{{--@can('special_bonus.viewAny')
    <li>
        <a href="{{ route('admin.special-bonus') }}" class="" aria-expanded="false">
            <i class="bi bi-diagram-3-fill"></i>
            <span class="nav-text"> Special Bonus </span>
        </a>
    </li>
@endcan--}}

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
            @can('popup-notice.viewAny')
                <li>
                    <a href="{{ route('admin.popup-notices.index') }}">Popup Notices</a>
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
                <!-- <li>
                    <a href="{{ route('admin.currencies.index') }}">Currencies</a>
                </li>!-->
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
                <a href="{{ route('admin.strategies.site-settings') }}">Site Settings</a>
            </li>
            <li>
                <a href="{{ route('admin.strategies.withdrawal.index') }}">Withdrawal</a>
            </li>
            <li>
                <a href="{{ route('admin.strategies.special-bonus') }}">Special Bonus</a>
            </li>
            <li>
                <a href="{{ route('admin.strategies.rank-level.index') }}">Rank Bonus</a>
            </li>
            <li>
                <a href="{{ route('admin.strategies.rank-gift-level.index') }}">Rank Gift</a>
            </li>
            {{-- <li>
                <a href="{{ route('admin.strategies.rank-level.index') }}">P2P Restrictions</a>
            </li>--}}
            <li>
                <a href="{{ route('admin.strategies.commissions.index') }}">Commissions</a>
            </li>
            <li>
                <a href="{{ route('admin.strategies.daily-leverages') }}">Daily Leverages</a>
            </li>

        </ul>
    </li>
@endcan


{{--@canany(['transactions.viewAny','purchase_staking_plans.viewAny','withdrawals.viewAny','staking_package.viewAny','earnings.viewAny'])
    <li>
        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
            <i class="bi bi-coin"></i>
            <span class="nav-text"> Coin Staking</span>
        </a>
        <ul aria-expanded="false">
            <li>
                <a href="{{ route('admin.staking.dashboard') }}" class="" aria-expanded="false">
                    Dashboard
                </a>
            </li>
            @can('transactions.viewAny')
                <li>
                    <a href="{{ route('admin.staking.transactions.index') }}" class="" aria-expanded="false">
                        Manage Payments
                    </a>
                </li>
            @endcan
            @can('purchase_staking_plans.viewAny')
                <li>
                    <a href="{{ route('admin.staking-purchased-packages') }}" class="" aria-expanded="false">
                        Sales
                    </a>
                </li>
            @endcan
            @can('earnings.viewAny')
                <li>
                    <a href="{{ route('admin.staking.earnings.index') }}" class="" aria-expanded="false">
                        Earnings
                    </a>
                </li>
            @endcan
            @can('withdrawals.viewAny')
                <li>
                    <a href="{{ route('admin.staking.transfers.withdrawals', ['status' => 'pending']) }}" class="" aria-expanded="false">
                        Withdrawals
                    </a>
                </li>
            @endcan
            @can('staking_package.viewAny')
                <li>
                    <a href="{{ route('admin.staking-packages.index') }}" class="" aria-expanded="false">
                        Package/Plans
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan--}}

{{--@can('wallet.topup')
    <li>
        <a href="{{ route('admin.wallet.topup') }}" class="" aria-expanded="false">
            <i class="bi bi-send-plus"></i>
            <span class="nav-text">Topup Wallet</span>
        </a>
    </li>
@endcan--}}

{{--@can('wallet.topup-history.viewAny')
    <li>
        <a href="{{ route('admin.wallet.topup.history') }}" class="" aria-expanded="false">
            <i class="bi bi-receipt-cutoff"></i>
            <span class="nav-text">Topup History</span>
        </a>
    </li>
@endcan--}}

{{--@can('withdraw.p2p.viewAny')
    <li>
        <a href="{{ route('admin.transfers.p2p', ['status' => 'success','date-range' => Carbon::now()->firstOfMonth()->format('Y-m-d') .' to '.Carbon::now()->endOfMonth()->format('Y-m-d')]) }}"
           class="" aria-expanded="false">
            <i class="bi fa-arrow-turn-down"></i>
            <span class="nav-text"> P2P Transactions </span>
        </a>
    </li>
@endcan--}}

{{--@can('wallet.transfers-history.viewAny')
    <li>
        <a href="{{ route('admin.transfers.wallets') }}" class="" aria-expanded="false">
            <i class="bi bi-arrow-clockwise"></i>
            <span class="nav-text"> Wallet Transactions </span>
        </a>
    </li>
@endcan--}}

{{--@can('rank.viewAny')
    <li>
        <a href="{{ route('admin.ranks') }}" class="" aria-expanded="false">
            <i class="bi bi-star-fill"></i>
            <span class="nav-text"> Ranks </span>
        </a>
    </li>
@endcan--}}


{{--@can('rank_gift.viewAny')
    <li>
        <a href="{{ route('admin.ranks.gifts') }}" class="" aria-expanded="false">
            <i class="bi bi-gift"></i>
            <span class="nav-text"> Rank Gifts </span>
        </a>
    </li>
@endcan--}}
