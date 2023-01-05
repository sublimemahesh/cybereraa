<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\Withdraw;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $earnings = Commission::with('purchasedPackage.user')
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->limit(25)
            ->latest()
            ->get();

        $income = number_format(Earning::where('status', 'RECEIVED')->sum('amount'));
        $withdraw = Withdraw::where('status', 'SUCCESS')->sum(DB::raw('amount + transaction_fee'));
        $qualified_commissions = Commission::where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::whereStatus('DISQUALIFIED')->sum('amount');

        Auth::user()->loadCount(['directSales as pending_direct_sales_count' => fn($query) => $query->whereNull('parent_id')->whereHas('activePackages')]);
        $wallet = Auth::user()->wallet;

        $direct = $earnings->where('type', 'DIRECT');
        $indirect = $earnings->where('type', 'INDIRECT');
        return view('backend.user.dashboard', compact('direct', 'indirect', 'wallet', 'income', 'withdraw', 'qualified_commissions', 'lost_commissions'));
    }
}
