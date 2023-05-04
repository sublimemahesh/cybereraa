<?php

namespace App\Http\Controllers\Admin\Staking;

use App\Http\Controllers\Controller;
use App\Services\PurchaseStakingPlanService;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchasedStakingPlanController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, PurchaseStakingPlanService $purchaseStakingPlanService)
    {
        abort_if(Gate::denies('purchase_staking_plans.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            return $purchaseStakingPlanService->datatable($request->input('user_id'))
                ->addColumn('actions', function ($staking_pkg) {
                    if (Gate::allows('stakingCancel.viewAny', $staking_pkg)) {
                        $actions = '<a href="' . route('admin.staking-cancel-request.index', $staking_pkg) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-list"></i>
                                </a>';
                        /*$actions .= '<a href="' . route('admin.transfers.withdrawals.approve', $staking_pkg) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-check-double"></i>
                                </a>';*/
                    }
                    if (Gate::allows('reject', $staking_pkg)) {
                        /*$actions .= '<a href="' . route('admin.transfers.withdrawals.reject', $staking_pkg) . '" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
                                    <i class="fa fa-ban"></i>
                                </a>';*/
                    }
                    return $actions;
                })
                ->rawColumns(['actions', 'user', 'package', 'trx_id'])
                ->make(true);
        }

        $packages = \App\Models\StakingPackage::activePackages()->orderBy('order')->get();

        return view('backend.admin.users.staking-plans.index', compact('packages'));
    }
}
