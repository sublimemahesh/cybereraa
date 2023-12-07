<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\YealyIncomeBarChartResource;
use App\Models\Commission;
use App\Models\Currency;
use App\Models\Earning;
use App\Models\Page;
use App\Models\PopupNotice;
use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\Withdraw;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $purchasedPackages = PurchasedPackage::where('user_id', Auth::user()->id)
            ->whereIn('status', ['ACTIVE', 'EXPIRED'])
            ->get();

        $total_purchased_packages_count = $purchasedPackages->count();

        $total_investment_profit = PurchasedPackage::where('user_id', Auth::user()->id)
            ->whereIn('status', ['ACTIVE', 'EXPIRED'])
            ->sum(DB::raw('investment_profit + level_commission_profit'));
        $total_avg_investment_profit = $total_purchased_packages_count === 0 ? 0 : $total_investment_profit / $total_purchased_packages_count;


        $total_investment_total_earned_profit = $purchasedPackages->sum('earned_profit');
        $total_investment_avg_earned_profit = $total_purchased_packages_count === 0 ? 0 : $total_investment_total_earned_profit / $total_purchased_packages_count;

//        dd($total_investment_profit,
//            $total_avg_investment_profit,
//            $total_purchased_packages_count,
//            $total_investment_total_earned_profit,
//            $total_investment_avg_earned_profit
//        );

        $total_investment = $purchasedPackages->sum('invested_amount');
        $active_investment = number_format($purchasedPackages->where('status', 'ACTIVE')->sum('invested_amount'), 2);
//        $expired_investment = number_format($purchasedPackages->where('status', 'EXPIRED')->sum('invested_amount'), 2);

//        $income = number_format(Earning::where('user_id', Auth::user()->id)
//            ->where('status', 'RECEIVED')
//            ->where('type', '<>', 'P2P')->sum('amount'), 2);

//        $today_income = number_format(Earning::where('user_id', Auth::user()->id)
//            ->where('status', 'RECEIVED')
//            ->where('type', '<>', 'P2P')
//            ->whereDate('created_at', \Carbon::today()->format('Y-m-d'))
//            ->sum('amount'), 2);

        $invest_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'PACKAGE')->sum('amount');
        $trade_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'TRADE_DIRECT')->sum('amount');
        $trade_team_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'TRADE_INDIRECT')->sum('amount');
        $direct_comm_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'DIRECT')->sum('amount');
        $indirect_comm_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'INDIRECT')->sum('amount');
//        $rank_bonus_income = Earning::where('user_id', Auth::user()->id)
//            ->where('status', 'RECEIVED')
//            ->where('type', 'RANK_BONUS')->sum('amount');

        //        $withdraw = number_format(Withdraw::where('user_id', Auth::user()->id)
        //            ->where('status', 'SUCCESS')
        //            ->sum(DB::raw('amount + transaction_fee')), 2);

//        $qualified_commissions = Commission::where('user_id', Auth::user()->id)
//            ->where('status', 'QUALIFIED')
//            ->sum('amount');
//
//        $paid_commissions = Commission::where('user_id', Auth::user()->id)
//            ->where('status', 'QUALIFIED')
//            ->sum('paid');
//
//        $pending_commissions = number_format($qualified_commissions - $paid_commissions, 2);
//        $qualified_commissions = number_format($qualified_commissions, 2);
//        $paid_commissions = number_format($paid_commissions, 2);
//
//        $lost_commissions = number_format(Commission::where('user_id', Auth::user()->id)
//            ->whereStatus('DISQUALIFIED')
//            ->sum('amount'), 2);

        Auth::user()->loadCount(['directSales']);
        $wallet = Auth::user()->wallet;

        // records
        $direct = Commission::with('purchasedPackage.user')
            ->where('user_id', Auth::user()->id)
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->where('type', 'DIRECT')
            ->limit(20)
            ->latest()
            ->get();

        $indirect = Commission::with('purchasedPackage.user')
            ->where('user_id', Auth::user()->id)
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->where('type', 'INDIRECT')
            ->limit(20)
            ->latest()
            ->get();

        $package_latest = Earning::with('earnable')
            ->where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'PACKAGE')
            ->limit(20)
            ->latest()
            ->get();

        $total_withdraws = number_format(Withdraw::where('user_id', Auth::user()->id)
            ->where('status', 'SUCCESS')
            ->whereIn('type', ['BINANCE', 'MANUAL'])
            ->sum('amount'), 2);

        $currency_carousel = Currency::all();

        $descendants = Auth::user()->descendants()->pluck('id')->toArray();
        $descendants_count = count($descendants);
        $descendants[] = Auth::user()->id;

//        $top_rankers = Rank::with('user.sponsor')
//            ->whereNotNull('activated_at')
//            ->whereIn('user_id', $descendants)
//            //->orderBy('rank', 'desc')
//            //->orderBy('total_rankers', 'desc')
//            ->latest('activated_at')
//            ->limit(20)
//            ->get();

        $yearlyIncome = DB::table('earnings')
            ->select(DB::raw('MONTH(created_at) AS month, type, SUM(amount) AS monthly_income'))
            ->whereYear('created_at', date('Y'))
            ->where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->orderBy('type')
            ->get();
        $yearlyIncomeChartData = new YealyIncomeBarChartResource($yearlyIncome);


        $popup = PopupNotice::whereDate('start_date', '<=', \Carbon::today()->format('Y-m-d'))
            ->whereDate('end_date', '>=', \Carbon::today()->format('Y-m-d'))
            ->whereIsActive(true)
            ->inRandomOrder()
            ->firstOrNew();


        $banners = Page::where(['slug' => 'banner'])->firstOrNew();
        $banners = $banners?->children;


        return view('backend.user.dashboard',
            compact(
                'banners',
                'total_avg_investment_profit',
                'total_investment_avg_earned_profit',
                'total_investment',

                'active_investment',
                'trade_income',
                'trade_team_income',
//                'expired_investment',
                'package_latest',
                'direct',
                'indirect',
                'wallet',

//                'income',
//                'today_income',
                'direct_comm_income',
                'indirect_comm_income',
//                'rank_bonus_income',
                'invest_income',
                'total_withdraws',

//                'withdraw',
//                'qualified_commissions',
//                'paid_commissions',
//                'pending_commissions',
//                'lost_commissions',
//                'top_rankers',

                'currency_carousel',
                'descendants_count',
                'yearlyIncomeChartData',
                'popup',
            )
        );


    }
}
