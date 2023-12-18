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
use App\Models\Withdraw;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;

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

        $today_income = number_format(Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->whereIn('type', ['PACKAGE', 'TRADE_DIRECT', 'TRADE_INDIRECT', 'DIRECT', 'INDIRECT'])
            //            ->where('type', '<>', 'P2P')
            ->whereDate('created_at', \Carbon::today()->format('Y-m-d'))
            ->sum('amount'), 2);

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

        Auth::user()->loadCount([
            'directSales',
            'directSales as active_direct_sales' => fn(Builder $q) => $q->whereHas('purchasedPackages'),
        ]);
        $wallet = Auth::user()->wallet;
        // records
        $direct_indirect = Commission::with('purchasedPackage.user')
            ->where('user_id', Auth::user()->id)
            ->limit(20)
            ->latest()
            ->get();

        $trade_incomes = Earning::with('tradeIncomePackage.user')
            ->where('user_id', Auth::user()->id)
            ->whereIn('type', ['TRADE_DIRECT', 'TRADE_INDIRECT'])
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

        $total_package_payable = \DB::selectOne("
                SELECT SUM(package_interest - total_package_earnings) total_pending_return
                     FROM(
                         SELECT
                         (`invested_amount` * investment_profit / 100) package_interest,
                        COALESCE((select sum(`earnings`.`amount`) from
                         `earnings` where `purchased_package`.`id` = `earnings`.`earnable_id` and
                         `earnings`.`earnable_type` = 'App\\Models\\PurchasedPackage' and `earnings`.`deleted_at` is null), 0) as `total_package_earnings`
                        FROM `purchased_package` WHERE `purchased_package`.`user_id` = :user_id
                    ) package_tbl;", ['user_id' => Auth::user()->id])->total_pending_return;

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
                'direct_indirect',
                'trade_incomes',
                'wallet',
                'total_package_payable',

//                'income',
                'today_income',
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
