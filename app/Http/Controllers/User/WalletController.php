<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use Auth;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $latest_earnings = Earning::with('earnable')
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '<=', date('Y-m-d H:i:s'))
            ->latest()
            ->limit(8)
            ->get();

        $income = Earning::authUserCurrentMonth()->sum('amount');

        $withdraw = 0; // Withdrawal amount

        $qualified_commissions = Commission::authUserCurrentMonth()->where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::authUserCurrentMonth()->whereStatus('DISQUALIFIED')->sum('amount');

        $wallet = Auth::user()->wallet;

        return view('backend.user.wallet.index', compact('wallet', 'latest_earnings', 'income', 'withdraw', 'qualified_commissions', 'lost_commissions'));
    }
}
