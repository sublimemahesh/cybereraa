<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\YealyIncomeBarChartResource;
use App\Models\Commission;
use App\Models\Currency;
use App\Models\Earning;
use App\Models\Page;
use App\Models\PopupNotice;
use App\Models\Rank;
use App\Models\Transaction;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)
            ->whereIn('status', ['PAID', 'EXPIRED'])
            ->get();

        $total_investment = number_format($transactions->sum('amount'), 2);
        $active_investment = number_format($transactions->where('status', 'PAID')->sum('amount'), 2);
        $expired_investment = number_format($transactions->where('status', 'EXPIRED')->sum('amount'), 2);

        $income = number_format(Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', '<>', 'P2P')->sum('amount'), 2);

        $today_income = number_format(Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', '<>', 'P2P')
            ->whereDate('created_at', \Carbon::today()->format('Y-m-d'))
            ->sum('amount'), 2);

        $invest_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'PACKAGE')->sum('amount');
        $direct_comm_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'DIRECT')->sum('amount');
        $indirect_comm_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'INDIRECT')->sum('amount');
        $rank_bonus_income = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'RANK_BONUS')->sum('amount');

        //        $withdraw = number_format(Withdraw::where('user_id', Auth::user()->id)
        //            ->where('status', 'SUCCESS')
        //            ->sum(DB::raw('amount + transaction_fee')), 2);

        $qualified_commissions = Commission::where('user_id', Auth::user()->id)
            ->where('status', 'QUALIFIED')
            ->sum('amount');

        $paid_commissions = Commission::where('user_id', Auth::user()->id)
            ->where('status', 'QUALIFIED')
            ->sum('paid');

        $pending_commissions = number_format($qualified_commissions - $paid_commissions, 2);
        $qualified_commissions = number_format($qualified_commissions, 2);
        $paid_commissions = number_format($paid_commissions, 2);

        //        $lost_commissions = number_format(Commission::where('user_id', Auth::user()->id)
        //            ->whereStatus('DISQUALIFIED')
        //            ->sum('amount'), 2);

        Auth::user()->loadCount(['directSales as pending_direct_sales_count' => fn($query) => $query->whereNull('parent_id')->whereHas('activePackages')]);
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

        $package_latest = Earning::where('user_id', Auth::user()->id)
            ->where('status', 'RECEIVED')
            ->where('type', 'PACKAGE')
            ->limit(20)
            ->latest()
            ->get();

        $currency_carousel = Currency::all();

        $descendants = Auth::user()->descendants()->pluck('id')->toArray();
        $descendants_count = count($descendants);
        $descendants[] = Auth::user()->id;

        $top_rankers = Rank::with('user.sponsor')
            ->whereNotNull('activated_at')
            ->whereIn('user_id', $descendants)
            ->orderBy('rank', 'desc')
            ->orderBy('total_rankers', 'desc')
            ->limit(20)
            ->get();

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
                'total_investment',
                'active_investment',
                'expired_investment',
                'package_latest',
                'direct',
                'indirect',
                'wallet',

                'income',
                'today_income',
                'direct_comm_income',
                'indirect_comm_income',
                'rank_bonus_income',
                'invest_income',

//                'withdraw',
                'qualified_commissions',
                'paid_commissions',
                'pending_commissions',
//                'lost_commissions',
                'currency_carousel',
                'descendants_count',
                'top_rankers',
                'yearlyIncomeChartData',
                'popup',
            )
        );


    }
}
