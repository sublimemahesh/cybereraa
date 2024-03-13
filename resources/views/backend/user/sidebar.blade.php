<!--********************************** Sidebar start ***********************************-->
<div class="deznav pt-md-0 mbo-100">
    <div class="deznav-scroll" data-devil="mt:30">
        <ul class="metismenu pt-0" id="menu">
            <li>
                <a href="{{ route('user.dashboard') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-columns-gap"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.calendar.events') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-calendar-event"></i>
                    <span class="nav-text">Calendar</span>
                </a>
            </li>

            {{-- @if(!App\Models\SupportTicket::whereRelation('category', 'slug', 'reschedule-plan')->where('user_id', Auth::user()->id)->exists())
                <li>
                    <a href="{{ URL::signedRoute('user.support.tickets.create', ['category' => 'reschedule-plan']) }}" class="rounded-1" aria-expanded="false">
                        <i class="bi bi-send-x"></i>
                        <span class="nav-text">Reschedule Request</span>
                    </a>
                </li>
            @endif --}}
            {{-- <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-icons">description</i>
                    <span class="nav-text">Reports</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="history.html">History</a></li>
                    <li><a href="orders.html">Orders</a></li>
                    <li><a href="reports.html">Report</a></li>
                    <li><a href="user.html">User</a></li>
                    <li><a href="contact.html">Contacts</a></li>
                    <li><a href="activity.html">Activity</a></li>
                </ul>
            </li> --}}


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-person-bounding-box"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('profile.show') }}">Personal Details</a>
                    </li>
                    <li>
                        <a href="{{ route('user.kyc.index') }}">KYC</a>
                    </li>
                </ul>
            </li>


            {{-- <li>
                <a href="{{ route('profile.show') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-person-bounding-box"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li> --}}
            {{-- <li>
                <a href="{{ route('user.kyc.index') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-check2-circle"></i>
                    <span class="nav-text">KYC Verification</span>
                </a>
            </li> --}}


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-piggy-bank"></i>
                    <span class="nav-text">Investment Asset</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.packages.custom') }}">Investment</a>
                    </li>
                    <li>
                        <a href="{{ route('user.packages.active') }}">My Asset Details</a>
                    </li>
                    <li>
                        <a href="{{ route('user.transactions.purchased.history') }}">Purchase History</a>
                    </li>
                    {{-- <li>
                         <a href="{{ route('user.wallet.request-topup-balance') }}">Topup Request</a>
                     </li>--}}
                    {{--<li>
                        <a href="{{ route('user.wallet.topup-request.history') }}">Topup History</a>
                    </li>--}}
                </ul>
            </li>


            {{-- <li>
                <a href="{{ route('user.packages.custom') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-piggy-bank"></i>
                    <span class="nav-text">Deposit Asset</span>
                </a>
            </li> --}}






            {{-- <li>
                <a href="{{ route('user.earnings.summary-report') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-cash-coin"></i>
                    <span class="nav-text">Withdraw Asset</span>
                </a>
            </li> --}}


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-cash-coin"></i>
                    <span class="nav-text">Withdraw Asset</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.wallet.withdraw') }}">Withdraw Asset</a>
                    </li>
                    <li>
                        <a href="{{ route('user.transfers.withdrawals') }}">Withdrawal History</a>
                    </li>
                    {{-- <li>
                         <a href="{{ route('user.wallet.transfer') }}">P2P Asset</a>
                     </li>--}}
                    {{--<li>
                        <a href="{{ route('user.transfers.p2p', ['status' => 'success', 'filter' => 'sent']) }}">P2P
                            History
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.transfers.p2p', ['status' => 'success', 'filter' => 'received']) }}">P2P
                            Received
                        </a>
                    </li>--}}
                </ul>
            </li>


            {{-- <li>
                <a href="{{ route('user.wallet.index') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-wallet"></i>
                    <span class="nav-text"> My Wallet </span>
                </a>
            </li> --}}


            <li>
                <a href="{{ route('user.wallet.index') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-wallet"></i>
                    <span class="nav-text">My Wallet </span>
                </a>
            </li>


            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-wallet"></i>
                    <span class="nav-text">My Wallet </span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.wallet.index') }}">Wallet Summery</a>
                    </li>
                    <li>
                        <a href="{{ route('user.wallet.transfer.to-wallet') }}">W2W Transfer</a>
                    </li>
                </ul>
            </li> --}}


            {{-- <li>
                <a href="{{ route('user.team.users-list') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-diagram-3"></i>
                    <span class="nav-text">Referral System</span>
                </a>
            </li> --}}


            <li>
                <a href="{{ route('user.team.users-levels') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">Referral System</span>
                </a>
            </li>



            {{-- <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">Referral System</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.team.users-list') }}">Team List</a>
                    </li>
                    <li>
                        <a href="{{ route('user.team.users-levels') }}">Referral Level</a>
                    </li>
                </ul>
            </li> --}}


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-bank"></i>
                    <span class="nav-text">Income Details</span>
                </a>
                <ul aria-expanded="false">

                    <li>
                        <a href="{{ route('user.earnings.index') }}">My Earning</a>
                    </li>
                    <li>
                        <a href="{{ route('user.incomes.commission') }}">My Commission</a>
                    </li>

                    <li>
                        <a href="{{ route('user.earnings.summary-report') }}">Income Summery</a>
                    </li>
                    <li>
                        <a href="{{ route('user.incomes.rewards') }}">My Rewards</a>
                    </li>
                    <li>
                        <a href="{{ route('user.team.incomes.commission') }}">Referral Income</a>
                    </li>
                    <li>
                        <a href="{{ route('user.earnings.team-income') }}">Highest Earners</a>
                    </li>

                </ul>
            </li>


            {{--
                        <li>
                            <a href="{{ route('user.ranks.summery') }}" class="rounded-1" aria-expanded="false">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span class="nav-text"> Summery </span>
                            </a>
                        </li> --}}


            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span class="nav-text">Summery</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.special-bonus') }}">Bonus Requirements</a>
                    </li>
                    <li>
                        <a href="{{ route('user.earnings.yearly-income-chart') }}">Income Chart</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="{{ route('user.support.tickets.index') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-question-octagon"></i>
                    <span class="nav-text">Customer Support</span>
                </a>
            </li>

            <li>
                <a href="{{ route('user.tutorials.index') }}" class="rounded-1" aria-expanded="false">
                    <i class="bi bi-journals"></i>
                    <span class="nav-text">Tutorials</span>
                </a>
            </li>


            {{-- <li>
                <a href="{{ route('user.staking-packages.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-stack"></i>
                    <span class="nav-text">Staking Packages</span>
                </a>
            </li> --}}

            {{--<li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-coin"></i>
                    <span class="nav-text">Coin Staking</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.staking-packages.dashboard') }}" class="" aria-expanded="false">
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.staking-packages.index') }}" class="" aria-expanded="false">
                            <span class="nav-text">Buy Staking</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.staking.transfers.withdrawals') }}" class="" aria-expanded="false">
                            Withdrawals
                        </a>
                    </li>
                </ul>
            </li>--}}

            {{-- <li>
                <a href="{{ route('user.packages.active') }}" class="" aria-expanded="false">
                    <i class="bi bi-box"></i>
                    <span class="nav-text">Active Packages</span>
                </a>
            </li>--}}
            {{--<li>
                <a href="{{ route('user.genealogy') }}" class="" aria-expanded="false">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span class="nav-text">My Genealogy</span>
                </a>
            </li>--}}
            {{--<li>
                <a href="{{ route('user.transactions.index') }}" class="" aria-expanded="false">
                    <i class="bi fa-chain-broken"></i>
                    <span class="nav-text">Transactions</span>
                </a>
            </li>--}}
            {{--<li>
                <a href="{{ route('user.transactions.purchased.history') }}" class="" aria-expanded="false">
                    <i class="bi bi-clipboard-data"></i>
                    <span class="nav-text">Purchase History</span>
                </a>
            </li>--}}
            {{-- <li>
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
            </li>--}}
            {{--<li>
                <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                    <i class="bi bi-person-hearts"></i>
                    <span class="nav-text">My Team</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.earnings.team-income') }}" class="" aria-expanded="false">
                            <span class="nav-text">Highest Income</span>
                        </a>
                    </li>
                </ul>
            </li>--}}
            {{--@canany(['viewSummery','viewRequirement'], \App\Models\RankBonusSummery::class)
            <li>
                <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
                    <i class="bi bi-trophy-fill"></i>
                    <span class="nav-text"> Ranks </span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('user.ranks.summery') }}" class="" aria-expanded="false">
                            <span class="nav-text">Team Rankers</span>
                        </a>
                    </li>
                    @can('viewSummery', \App\Models\RankBonusSummery::class)
                    <li>
                        <a href="{{ route('user.ranks.benefits.summery') }}" class="" aria-expanded="false">
                            <span class="nav-text">Bonus Summery</span>
                        </a>
                    </li>
                    @endcan
                    @can('viewRequirement', \App\Models\RankBonusSummery::class)
                    <li>
                        <a href="{{ route('user.ranks.benefits.requirements') }}" class="" aria-expanded="false">
                            <span class="nav-text">Bonus Requirement</span>
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
            </li>--}}
            {{--<li>
                <a href="{{ route('user.earnings.index') }}" class="" aria-expanded="false">
                    <i class="bi bi-cash"></i>
                    <span class="nav-text">My Earning</span>
                </a>
            </li>--}}
            {{--<li>
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
            </li>--}}


            @include('navigation-menu')
        </ul>

    </div>
</div>
<!--********************************** Sidebar end ***********************************-->
