<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::activePackages()->get();
        $logged_user = Auth::user()->loadCount('purchasedPackages');
        $is_gas_fee_added = $logged_user->purchased_packages_count <= 0;
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.packages.index', compact('packages', 'is_gas_fee_added'));
    }

    public function active(Request $request)
    {
        $activePackages = Auth::user()->activePackages;
        $activePackages->load('transaction');
        return view('backend.user.packages.active', compact('activePackages'));
    }

    public function buypackage(Request $request)
    {
        $activePackages = Auth::user()->activePackages;
        $activePackages->load('transaction');
        return view('backend.user.packages.buy_package', compact('activePackages'));
    }
}
