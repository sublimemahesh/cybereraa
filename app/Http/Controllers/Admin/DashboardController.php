<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\User;
use App\Models\Withdraw;
use Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total_sale_amount = PurchasedPackage::whereNotIn('status', ['PENDING'])
            ->sum('invested_amount');
        $total_earnings = number_format(Earning::where('status', 'RECEIVED')->sum('amount'), 2);

        $total_commissions = Commission::sum('amount');
        $total_qualified_commissions = Commission::where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::whereStatus('DISQUALIFIED')->sum('amount');

        $total_p2p_transfers = Withdraw::where('status', 'SUCCESS')->Where('status', 'P2P')->sum(DB::raw('amount + transaction_fee'));

        $pending_sales_count = User::whereNull('parent_id')->whereHas('activePackages')->count();
        $registrations_count = User::count();

        $today_logins = DB::table('sessions')->where('last_activity', '>', Carbon::today()->timestamp)->count();
        $total_rankers = Rank::where('eligibility', 5)->count();

        // $rank_bonus_percentage = Strategy::where('name', 'rank_bonus')->firstOr(fn() => new Strategy(['value' => '10']));
        // $total_balance = Commission::count();

        return view('backend.admin.dashboard',
            compact(
                'total_sale_amount',
                'total_earnings',
                'total_commissions',
                'total_qualified_commissions',
                'lost_commissions',
                'pending_sales_count',
                'today_logins',
                'registrations_count',
                'total_rankers',
            )
        );
    }
}
