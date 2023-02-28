<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\Withdraw;
use Auth;
use Carbon\Carbon;
use DB;

class WalletController extends Controller
{
    public function index()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $latest_transactions = Withdraw::with('receiver')
            ->where('user_id', Auth::user()->id)
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->latest()
            ->limit(8)
            ->get();

        $income = Earning::authUserCurrentMonth()->where('status', 'RECEIVED')->sum('amount');
        $withdraw = Withdraw::authUserCurrentMonth()->where('status', 'SUCCESS')->sum(DB::raw('amount + transaction_fee'));
        $qualified_commissions = Commission::authUserCurrentMonth()->where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::authUserCurrentMonth()->whereStatus('DISQUALIFIED')->sum('amount');

        $income = number_format($income, 2);
        $withdraw = number_format($withdraw, 2);
        $qualified_commissions = number_format($qualified_commissions, 2);
        $lost_commissions = number_format($lost_commissions, 2);

        $wallet = Auth::user()->wallet;

        return view('backend.user.wallet.index', compact('wallet', 'latest_transactions', 'income', 'withdraw', 'qualified_commissions', 'lost_commissions'));
    }
}
