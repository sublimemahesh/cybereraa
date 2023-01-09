<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\RankBenefit;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EarningController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Earning::filter()
                ->with('earnable')
                ->where('user_id', Auth::user()->id)
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('amount', fn($commission) => number_format($commission->amount, 2))
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
                ->addColumn('created_at', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->make();
        }
        return view('backend.user.earnings.index');
    }


    /**
     * @throws Exception
     */
    public function commission(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Commission::filter()
                ->with('purchasedPackage')
                ->where('user_id', Auth::user()->id)
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($commission) => $commission->package_info_json->name)
                ->addColumn('amount', fn($commission) => number_format($commission->amount, 2))
                ->addColumn('paid', fn($commission) => number_format($commission->paid, 2))
                ->addColumn('created_at', fn($commission) => $commission->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        $types = [
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
        ];

        return view('backend.user.incomes.commissions', compact('types'));
    }

    /**
     * @throws Exception
     */
    public function rewards(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = RankBenefit::filter()
                ->where('user_id', Auth::user()->id)
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($reward) => $reward->package_info_json->name)
                ->addColumn('amount', fn($reward) => number_format($reward->amount, 2))
                ->addColumn('paid', fn($reward) => number_format($reward->paid, 2))
                ->addColumn('created_at', fn($reward) => $reward->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        $types = [
            'rank_bonus' => 'BONUS',
            'rank_gift' => 'GIFT',
        ];

        return view('backend.user.incomes.commissions', compact('types'));
    }
}
