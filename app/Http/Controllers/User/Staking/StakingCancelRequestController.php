<?php

namespace App\Http\Controllers\User\Staking;

use App\Http\Controllers\Controller;
use App\Models\PurchasedStakingPlan;
use Illuminate\Http\Request;

class StakingCancelRequestController extends Controller
{
    public function index(Request $request, PurchasedStakingPlan $purchase)
    {
        $cancel_requests = $purchase->cancelRequests;
        return view('backend.user.staking.cancellations', compact('cancel_requests', 'purchase'));
    }
}
