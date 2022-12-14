<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::whereIsActive(true)->get();
//        dd(json_encode($packages->pluck('slug')));
        return view('backend.user.packages.index', compact('packages'));
    }
}
