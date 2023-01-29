<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return (new AdminDashboard())->index();

        //TODO: Develop Super admin dashboard
        //return view('backend.super_admin.dashboard');
    }
}
