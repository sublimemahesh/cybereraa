<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\RankBenefit;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function commission(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Commission::when(!empty($request->get('user_id')),
                static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->with('purchasedPackage', 'user')
                ->filter()
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('user_id', fn($commission) => str_pad($commission->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('username', fn($commission) => $commission->user->username)
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

        return view('backend.admin.users.incomes.commissions', compact('types'));
    }

    /**
     * @throws Exception
     */
    public function rewards(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = RankBenefit::with('user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->filter()
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('user_id', fn($reward) => str_pad($reward->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('username', fn($reward) => $reward->user->username)
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

        return view('backend.admin.users.incomes.commissions', compact('types'));
    }
}
