<?php

namespace App\Http\Controllers\User\Staking;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\StakingPackage;
use App\Models\Withdraw;
use App\Services\PurchaseStakingPlanService;
use Auth;
use DB;
use Illuminate\Http\Request;

class StakingPackageController extends Controller
{
    public function index()
    {
        $packages = StakingPackage::activePackages()->get();
        //$logged_user = Auth::user()->loadCount('purchasedPackages');
        //$is_gas_fee_added = $logged_user->purchased_packages_count <= 0;
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.staking.index', compact('packages'));
    }

    public function plans(Request $request, StakingPackage $package)
    {
//        if (Gate::inspect('purchase', [$package, $max_amount])->denied()) {
//            session()->flash('error', "Please select a package amount is higher than or equal to USDT " . $user->purchased_packages_max_invested_amount);
//        }
        $plans = $package->plans;
        return view('backend.user.staking.purchase-plan', compact('package', 'plans'));
    }


    public function dashboard(Request $request, PurchaseStakingPlanService $purchaseStakingPlanService)
    {
        $user = Auth::user();

        if ($request->wantsJson()) {
            return $purchaseStakingPlanService->datatable(\Auth::user()->id)
                ->addColumn('actions', function ($staking_pkg) {
                    $actions = '<a href="' . route('user.staking-cancel-request.index', $staking_pkg) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-list"></i>
                                </a>';
                    if (\Gate::allows('cancel', $staking_pkg)) {
                        $actions .= '<a href="' . route('user.staking-cancel-request.request', $staking_pkg) . '" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
                                    <i class="fa fa-close"></i>
                                </a>';
                    }
                    return $actions;
                })
                ->rawColumns(['actions', 'user', 'package', 'trx_id'])
                ->make(true);
        }
        $income = Earning::authUserCurrentMonth()->where('status', 'RECEIVED')->where('type', 'STAKING')->sum('amount');
        $withdraw = Withdraw::authUserCurrentMonth()
            ->where('status', 'SUCCESS')
            ->where('wallet_type', 'STAKING')
            ->sum(DB::raw('amount + transaction_fee'));
        $income = number_format($income, 2);
        $withdraw = number_format($withdraw, 2);

        $packages = StakingPackage::activePackages()->get();
        $wallet = $user->wallet;

        return view('backend.user.staking.dashboard', compact('packages', 'wallet', 'income', 'withdraw'));
    }


}
