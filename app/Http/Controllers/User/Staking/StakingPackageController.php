<?php

namespace App\Http\Controllers\User\Staking;

use App\Http\Controllers\Controller;
use App\Models\StakingPackage;
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
}
