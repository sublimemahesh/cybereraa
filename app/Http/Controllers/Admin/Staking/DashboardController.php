<?php

namespace App\Http\Controllers\Admin\Staking;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\PurchasedStakingPlan;
use App\Models\StakingCancelRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdraw;

class DashboardController extends Controller
{
    public function index()
    {
        $total_sale_amount = PurchasedStakingPlan::whereNotIn('status', ['PENDING'])->sum('invested_amount');
        $total_sale_gas_fees = number_format(Transaction::where('status', 'PAID')
            ->where('package_type', 'STAKING')
            ->sum('gas_fee'), 2);

        $total_earnings = Earning::where('status', 'RECEIVED')->whereIn('type', ['STAKING'])->sum('amount');
        $total_earnings = number_format($total_earnings, 2);

        $total_hold_staking_amount = PurchasedStakingPlan::where('status', 'HOLD')->sum('invested_amount');
        $total_hold_staking_count = PurchasedStakingPlan::where('status', 'HOLD')->count();
        $total_canceled_staking_amount = PurchasedStakingPlan::where('status', 'CANCELLED')->sum('invested_amount');
        $total_canceled_staking_amount_with_interest = StakingCancelRequest::whereRelation('purchasedStakingPlan', 'status', 'CANCELLED')
            ->sum('total_released_amount');

        $total_available_wallet_balance = number_format(Wallet::sum('staking_balance'), 2);

        $total_manual_transactions = number_format(Transaction::where('status', 'PAID')
            ->where('pay_method', 'MANUAL')->where('package_type', 'STAKING')->sum('amount'), 2);
        $total_manual_transactions_gas_fees = number_format(Transaction::where('status', 'PAID')
            ->where('package_type', 'STAKING')
            ->where('pay_method', 'MANUAL')->sum('gas_fee'), 2);

        $total_pending_withdrawal_balance = number_format(Withdraw::whereIn('status', ['PENDING', 'PROCESSING'])
            ->whereIn('type', ['BINANCE', 'MANUAL'])->where('wallet_type', 'STAKING')->sum('amount'), 2);

        $total_withdraws = number_format(Withdraw::where('status', 'SUCCESS')
            ->where('wallet_type', 'STAKING')
            ->whereIn('type', ['BINANCE', 'MANUAL'])
            ->sum('amount'), 2);

        $total_withdraws_transaction_fees = Withdraw::where('status', 'SUCCESS')
            ->where('wallet_type', 'STAKING')
            ->whereIn('type', ['BINANCE', 'MANUAL'])
            ->sum('transaction_fee');


        return view('backend.admin.staking-package.dashboard',
            compact(
                'total_sale_amount',
                'total_sale_gas_fees',
                'total_earnings',


                'total_available_wallet_balance',


                'total_manual_transactions',
                'total_manual_transactions_gas_fees',


                'total_pending_withdrawal_balance',

                'total_withdraws',

                'total_withdraws_transaction_fees',

                'total_hold_staking_amount',
                'total_hold_staking_count',
                'total_canceled_staking_amount',
                'total_canceled_staking_amount_with_interest',
            )
        );
    }
}
