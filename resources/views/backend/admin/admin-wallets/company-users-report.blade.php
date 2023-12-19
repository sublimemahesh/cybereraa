<x-backend.layouts.app>
    @section('title', 'Company Users | Reports')
    @section('header-title', 'Company Users | Reports' )
    @section('plugin-styles')
        <!-- Datatable -->
        @vite(['resources/css/app-jetstream.css'])
    @endsection

    @section('breadcrumb-items')
        <li class="breadcrumb-item">Company Users</li>
    @endsection

    <div class="row dark"> {{--! Tailwind css used. if using tailwind plz run npm run dev and add tailwind classes--}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display mb-1 table-responsive-my dt-responsive table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="fs-14 text-center"><strong>USER</strong></th>
                                    <th class="fs-14 text-center"><strong>INVESTMENT</strong></th>
                                    <th class="fs-14 text-center"><strong>COMMISSIONS</strong></th>
                                    {{--<th class="fs-14 text-center"><strong>total_qualified_commissions</strong></th>--}}
                                    {{--<th class="fs-14 text-center"><strong>lost_commissions</strong></th>--}}
                                    <th class="fs-14 text-center"><strong>PACKAGE EARNING</strong></th>
                                    <th class="fs-14 text-center">
                                        <strong>EARNING</strong> <br>
                                        <small>(Commission + Package)</small>
                                    </th>
                                    {{--<th class="fs-14 text-center"><strong>total_direct_commission_earnings</strong></th>--}}
                                    {{--<th class="fs-14 text-center"><strong>total_indirect_commission_earnings</strong></th>--}}
                                    {{--<th class="fs-14 text-center"><strong>TRADE INCOME</strong></th>--}}
                                    <th class="fs-14 text-center"><strong>BONUS/REWARDS</strong></th>
                                    {{--<th class="fs-14 text-center"><strong>total_indirect_earnings</strong></th>--}}
                                    <th class="fs-14 text-center"><strong>WALLET</strong></th>
                                    {{--<th class="fs-14 text-center"><strong>total_available_wallet_topup_balance</strong></th>--}}
                                    {{--<th class="fs-14 text-center"><strong>total_withdraw_limit_wallet_balance</strong></th>--}}
                                    <th class="fs-14 text-center"><strong>WITHDRAWAL</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company_users as $user)
                                    <tr>
                                        <td>
                                            ID: {{ $user->id }} <br>
                                            <a href="{{ route('admin.users.profile.show', $user) }}"><code>{{ $user->username }}</code></a>
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($user->total_sale_amount,2) }}
                                        </td>
                                        <td class="text-right">
                                            Total: {{ number_format($user->total_commissions,2) }} <br>
                                            Qualified: {{ number_format($user->total_qualified_commissions,2) }} <br>
                                            Disqualified: {{ number_format($user->lost_commissions,2) }} <br>
                                            Direct: {{ number_format($user->total_direct_commission_earnings,2) }} <br>
                                            Indirect: {{ number_format($user->total_indirect_commission_earnings,2) }} <br>
                                        </td>
                                        {{--<td> {{ number_format($user->total_qualified_commissions,2) }}</td>--}}
                                        {{--<td> {{ number_format($user->lost_commissions,2) }}</td>--}}
                                        <td class="text-right">
                                            Package Income: {{ number_format($user->total_package_earnings,2) }} <br>
                                            Direct Trade: {{ number_format($user->total_trade_earnings,2) }} <br>
                                            Indirect Trade: {{ number_format($user->total_indirect_earnings,2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($user->total_earnings,2) }}
                                        </td>
                                        {{--<td> {{ number_format($user->total_direct_commission_earnings,2) }}</td>--}}
                                        {{--<td> {{ number_format($user->total_indirect_commission_earnings,2) }}</td>--}}
                                        {{--<td>
                                            Direct Trade: {{ number_format($user->total_trade_earnings,2) }} <br>
                                            Indirect Trade: {{ number_format($user->total_indirect_earnings,2) }}
                                        </td>--}}
                                        <td class="text-right">
                                            {{ number_format($user->total_special_bonus_earnings,2) }}
                                        </td>
                                        {{--<td> {{ number_format($user->total_indirect_earnings,2) }}</td>--}}
                                        <td class="text-right">
                                            Internal Wallet: {{ number_format($user->total_available_wallet_balance,2) }} <br>
                                            External Wallet: {{ number_format($user->total_available_wallet_topup_balance,2) }} <br>
                                            Payout Limit: {{ number_format($user->total_withdraw_limit_wallet_balance,2) }}
                                        </td>
                                        {{--<td> {{ number_format($user->total_available_wallet_topup_balance,2) }}</td>--}}
                                        {{--<td> {{ number_format($user->total_withdraw_limit_wallet_balance,2) }}</td>--}}
                                        <td class="text-right">
                                            {{ number_format($user->total_withdraw,2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="fs-14">
                                        <strong>TOTAL</strong>
                                    </th>
                                    <th class="fs-14 text-right">
                                        {{ number_format($company_users->sum('total_sale_amount'),2) }}
                                    </th>
                                    <th class="text-right">
                                        Total: {{ number_format($company_users->sum('total_commissions'),2) }} <br>
                                        Qualified: {{ number_format($company_users->sum('total_qualified_commissions'),2) }} <br>
                                        Disqualified: {{ number_format($company_users->sum('lost_commissions'),2) }} <br>
                                        Direct: {{ number_format($company_users->sum('total_direct_commission_earnings'),2) }} <br>
                                        Indirect: {{ number_format($company_users->sum('total_indirect_commission_earnings'),2) }} <br>
                                    </th>
                                    {{--<td> {{ number_format($company_users->sum('total_qualified_commissions'),2) }}</td>--}}
                                    {{--<td> {{ number_format($company_users->sum('lost_commissions'),2) }}</td>--}}
                                    <th class="text-right">
                                        Package Income: {{ number_format($company_users->sum('total_package_earnings'),2) }} <br>
                                        Direct Trade: {{ number_format($company_users->sum('total_trade_earnings'),2) }} <br>
                                        Indirect Trade: {{ number_format($company_users->sum('total_indirect_earnings'),2) }}
                                    </th>
                                    <th class="text-right">
                                        {{ number_format($company_users->sum('total_earnings'),2) }}
                                    </th>
                                    {{--<td> {{ number_format($company_users->sum('total_direct_commission_earnings'),2) }}</td>--}}
                                    {{--<td> {{ number_format($company_users->sum('total_indirect_commission_earnings'),2) }}</td>--}}
                                    {{--<td>
                                        Direct Trade: {{ number_format($company_users->sum('total_trade_earnings'),2) }} <br>
                                        Indirect Trade: {{ number_format($company_users->sum('total_indirect_earnings'),2) }}
                                    </td>--}}
                                    <th class="text-right">
                                        {{ number_format($company_users->sum('total_special_bonus_earnings'),2) }}
                                    </th>
                                    {{--<td> {{ number_format($company_users->sum('total_indirect_earnings'),2) }}</td>--}}
                                    <th class="text-right">
                                        Internal Wallet: {{ number_format($company_users->sum('total_available_wallet_balance'),2) }} <br>
                                        External Wallet: {{ number_format($company_users->sum('total_available_wallet_topup_balance'),2) }} <br>
                                        Payout Limit: {{ number_format($company_users->sum('total_withdraw_limit_wallet_balance'),2) }}
                                    </th>
                                    {{--<td> {{ number_format($company_users->sum('total_available_wallet_topup_balance'),2) }}</td>--}}
                                    {{--<td> {{ number_format($company_users->sum('total_withdraw_limit_wallet_balance'),2) }}</td>--}}
                                    <th class="text-right">
                                        {{ number_format($company_users->sum('total_withdraw'),2) }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-backend.layouts.app>
