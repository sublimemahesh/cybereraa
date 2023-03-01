<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::activePackages()->get();
        //$logged_user = Auth::user()->loadCount('purchasedPackages');
        //$is_gas_fee_added = $logged_user->purchased_packages_count <= 0;
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.packages.index', compact('packages'));
    }

    public function active(Request $request)
    {
        $activePackages = Auth::user()->activePackages;
        $activePackages->load('transaction');
        return view('backend.user.packages.active', compact('activePackages'));
    }

    public function manualPurchase(Request $request, Package $package, User|null $purchase_for = null)
    {
        if ($purchase_for !== null) {
            $user = $purchase_for;
            $purchased_by = Auth::user();
        } else {
            $user = Auth::user();
            $purchased_by = $user;
        }

        $user->loadMax('purchasedPackages', 'invested_amount');
        $max_amount = $user->purchased_packages_max_invested_amount;
        if (Gate::inspect('purchase', [$package, $max_amount])->denied()) {
            session()->flash('error', "Please select a package amount is higher than or equal to USDT " . $user->purchased_packages_max_invested_amount);
        }

        return view('backend.user.packages.manual-purchase', compact('package', 'purchase_for', 'max_amount'));
    }
}
