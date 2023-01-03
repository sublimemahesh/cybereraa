<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StrategyController extends Controller
{

    public function withdrawal()
    {

     return view('backend.admin.strategies.withdrawal.index');
     //return view('backend.admin.strategies.withdrawal.index');
    }

    public function rankLevel()
    {

     return view('backend.admin.strategies.rank_level.index');

    }

    public function commissions()
    {

     return view('backend.admin.strategies.commissions.index');

    }

    public function payablePercentage()
    {

     return view('backend.admin.strategies.payable_percentage.index');

    }


}
