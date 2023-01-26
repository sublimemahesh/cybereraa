<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total_sale_amount = PurchasedPackage::whereNotIn('status', ['PENDING'])->sum('invested_amount');
        $total_sale_gas_fees = number_format(Transaction::where('status', 'PAID')->sum('gas_fee'), 2);

        $total_earnings = Earning::where('status', 'RECEIVED')->whereNotIn('type', ['P2P', 'RANK_GIFT'])->sum('amount');
        $total_earnings = number_format($total_earnings, 2);
        $total_commissions = Commission::sum('amount');
        $total_qualified_commissions = Commission::where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::whereStatus('DISQUALIFIED')->sum('amount');

        $total_package_earnings = Earning::where('status', 'RECEIVED')->where('type', 'PACKAGE')->sum('amount');
        $total_direct_commission_earnings = Earning::where('status', 'RECEIVED')->where('type', 'DIRECT')->sum('amount');
        $total_indirect_commission_earnings = Earning::where('status', 'RECEIVED')->where('type', 'INDIRECT')->sum('amount');
        $total_rank_bonus_earnings = Earning::where('status', 'RECEIVED')->where('type', 'RANK_BONUS')->sum('amount');

        $total_package_earnings = number_format($total_package_earnings, 2);
        $total_direct_commission_earnings = number_format($total_direct_commission_earnings, 2);
        $total_indirect_commission_earnings = number_format($total_indirect_commission_earnings, 2);
        $total_rank_bonus_earnings = number_format($total_rank_bonus_earnings, 2);

        $total_available_wallet_balance = number_format(Wallet::sum('balance'), 2);
        $total_withdraw_limit_wallet_balance = number_format(Wallet::sum('withdraw_limit'), 2);
        $total_active_package_balance = number_format(PurchasedPackage::activePackages()->sum('invested_amount'), 2);
        $total_expired_package_balance = number_format(PurchasedPackage::expiredPackages()->sum('invested_amount'), 2);

        $total_pending_withdrawal_balance = number_format(Withdraw::where('status', 'PROCESSING')->Where('type', 'BINANCE')->sum('amount'), 2);
        $total_p2p_transfers = number_format(Withdraw::where('status', 'SUCCESS')->Where('type', 'P2P')->sum('amount'), 2);
        $total_withdraws = number_format(Withdraw::where('status', 'SUCCESS')->Where('type', 'BINANCE')->sum('amount'), 2);
        $total_p2p_transaction_fees = Withdraw::where('status', 'SUCCESS')->Where('type', 'P2P')->sum('transaction_fee');
        $total_withdraws_transaction_fees = Withdraw::where('status', 'SUCCESS')->Where('type', 'BINANCE')->sum('transaction_fee');

        $pending_sales_count = User::whereNull('parent_id')->whereHas('activePackages')->count();
        $registrations_count = User::count();

        $today_logins = DB::table('sessions')->where('last_activity', '>', Carbon::today()->timestamp)->count();
        $total_rankers = Rank::where('eligibility', 5)->count();

        // $rank_bonus_percentage = Strategy::where('name', 'rank_bonus')->firstOr(fn() => new Strategy(['value' => '10']));
        // $total_balance = Commission::count();

        return view('backend.admin.dashboard',
            compact(
                'total_sale_amount',
                'total_sale_gas_fees',
                'total_earnings',
                'total_commissions',
                'total_qualified_commissions',
                'lost_commissions',

                'total_package_earnings',
                'total_direct_commission_earnings',
                'total_indirect_commission_earnings',
                'total_rank_bonus_earnings',

                'total_available_wallet_balance',
                'total_withdraw_limit_wallet_balance',
                'total_active_package_balance',
                'total_expired_package_balance',

                'total_pending_withdrawal_balance',
                'total_p2p_transfers',
                'total_withdraws',
                'total_p2p_transaction_fees',
                'total_withdraws_transaction_fees',

                'pending_sales_count',
                'today_logins',
                'registrations_count',
                'total_rankers',
            )
        );
    }
}
