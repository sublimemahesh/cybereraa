<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\RankBenefit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function commission(Request $request)
    {
        abort_if(Gate::denies('commissions.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $earnings = Commission::when(!empty($request->get('user_id')),
                static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->with('purchasedPackage', 'user')
                ->filter();

            return DataTables::of($earnings)
                ->addColumn('user', function ($commission) {
                    return str_pad($commission->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <a href='" . route('admin.users.profile.show', $commission->user) . "' target='_blank'>
                                    <code class='text-uppercase'>{$commission->user->username}</code>
                                </a>";
                })
                ->addColumn('package', fn($commission) => $commission->package_info_json->name)
                ->addColumn('amount', fn($commission) => number_format($commission->amount, 2))
                ->addColumn('paid', fn($commission) => number_format($commission->paid, 2))
                ->addColumn('date', fn($commission) => $commission->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user'])
                ->make();
        }

        $types = [
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
        ];

        return view('backend.admin.users.incomes.commission', compact('types'));
    }

    /**
     * @throws Exception
     */
    public function rewards(Request $request)
    {
        abort_if(Gate::denies('rank_bonus.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $earnings = RankBenefit::with('user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->filter()
                //->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('user', function ($commission) {
                    return str_pad($commission->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <a href='" . route('admin.users.profile.show', $commission->user) . "' target='_blank'>
                                    <code class='text-uppercase'>{$commission->user->username}</code>
                                </a>";
                })
                ->addColumn('package', fn($reward) => $reward->package_info_json->name)
                ->addColumn('amount', fn($reward) => number_format($reward->amount, 2))
                ->addColumn('paid', fn($reward) => number_format($reward->paid, 2))
                ->addColumn('date', fn($reward) => $reward->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user'])
                ->make();
        }

        $types = [
            'rank_bonus' => 'BONUS',
            'rank_gift' => 'GIFT',
        ];

        return view('backend.admin.users.incomes.rewards', compact('types'));
    }
}
