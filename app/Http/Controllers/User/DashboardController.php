<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Currency;
use App\Models\Earning;
use App\Models\Transaction;
use App\Models\Withdraw;
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
            ->where('type', '<>', 'P2P')
            ->sum('amount'), 2);

        $invest_income = number_format(Earning::where('user_id', Auth::user()->id)
            ->where('type', 'PACKAGE')
            ->where('status', 'RECEIVED')->sum('amount'), 2);

        $withdraw = number_format(Withdraw::where('user_id', Auth::user()->id)
            ->where('status', 'SUCCESS')
            ->sum(DB::raw('amount + transaction_fee')), 2);

        $qualified_commissions = number_format(Commission::where('user_id', Auth::user()->id)
            ->where('status', 'QUALIFIED')
            ->sum('amount'), 2);

        $lost_commissions = number_format(Commission::where('user_id', Auth::user()->id)
            ->whereStatus('DISQUALIFIED')
            ->sum('amount'), 2);

        Auth::user()->loadCount(['directSales as pending_direct_sales_count' => fn($query) => $query->whereNull('parent_id')->whereHas('activePackages')]);
        $wallet = Auth::user()->wallet;

        // records
        $commissions = Commission::with('purchasedPackage.user')
            ->where('user_id', Auth::user()->id)
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->limit(25)
            ->latest()
            ->get();

        $direct = $commissions->where('type', 'DIRECT');
        $indirect = $commissions->where('type', 'INDIRECT');

        $currency_carousel = Currency::all();

        return view('backend.user.dashboard',
            compact(
                'total_investment',
                'active_investment',
                'expired_investment',
                'direct',
                'indirect',
                'wallet',
                'income',
                'invest_income',
                'withdraw',
                'qualified_commissions',
                'lost_commissions',
                'currency_carousel'
            )
        );
    }
}
