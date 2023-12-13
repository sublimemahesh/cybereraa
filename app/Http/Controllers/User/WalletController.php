<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyEarningLineChart;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\Withdraw;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DB;

class WalletController extends Controller
{
    public function index()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $startDate = Carbon::now()->startOfWeek(CarbonInterface::SUNDAY);
        $endDate = Carbon::now()->endOfWeek(CarbonInterface::SATURDAY);

        $earnings = Earning::selectRaw('DAYOFWEEK(created_at) AS day, type, SUM(amount) AS earnings')
            ->where('user_id', Auth::user()->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day', 'type')
            ->get();

        $line_chart_data = new WeeklyEarningLineChart($earnings);

        $commission_categories = Commission::without('purchasedPackage')
            ->selectRaw('type, SUM(amount) AS total_amount, SUM(paid) AS total_paid')
            ->where('user_id', Auth::user()->id)
            ->groupBy('type')
            ->get();

        $latest_transactions = Withdraw::with('receiver')
            ->where('user_id', Auth::user()->id)
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->latest()
            ->limit(8)
            ->get();

        $income = Earning::authUserCurrentMonth()->where('status', 'RECEIVED')->sum('amount');
        $withdraw = Withdraw::authUserCurrentMonth()->where('status', 'SUCCESS')->sum(DB::raw('amount + transaction_fee'));

        $qualified_commissions = Commission::authUserCurrentMonth()->where('status', 'QUALIFIED')->sum('paid');
//        $lost_commissions = Commission::authUserCurrentMonth()->selectRaw('(SUM(`amount`) - SUM(`paid`)) as disqualified')->first();
//        $lost_commissions = Commission::authUserCurrentMonth()->sum(DB::raw('amount - paid'));
        $lost_commissions = Commission::authUserCurrentMonth()->whereStatus('DISQUALIFIED')->sum('amount');
        
        $income = number_format($income, 2);
        $withdraw = number_format($withdraw, 2);
        $qualified_commissions = number_format($qualified_commissions, 2);
        $lost_commissions = number_format($lost_commissions, 2);

        $wallet = Auth::user()->wallet;

        return view('backend.user.wallet.index', compact('commission_categories', 'line_chart_data', 'wallet', 'latest_transactions', 'income', 'withdraw', 'qualified_commissions', 'lost_commissions'));
    }
}
