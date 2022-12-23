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
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.packages.index', compact('packages'));
    }

    public function active(Request $request)
    {
        $activePackages = Auth::user()->activePackages;
        $activePackages->load('package', 'transaction');
        return view('backend.user.packages.active', compact('activePackages'));
    }
}
