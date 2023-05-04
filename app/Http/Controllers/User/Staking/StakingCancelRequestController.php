<?php

namespace App\Http\Controllers\User\Staking;

use App\Http\Controllers\Controller;
use App\Models\PurchasedStakingPlan;
use App\Models\StakingCancelRequest;
use Auth;
use Illuminate\Http\Request;
use Throwable;
use URL;
use Validator;

class StakingCancelRequestController extends Controller
{
    public function index(Request $request, PurchasedStakingPlan $purchase)
    {
        abort_if(auth()->user()->id !== $purchase->user_id, 403);

        $cancel_requests = $purchase->cancelRequests;
        return view('backend.user.staking.cancellations', compact('cancel_requests', 'purchase'));
    }

    /**
     * @throws Throwable
     */
    public function request(Request $request, PurchasedStakingPlan $purchase)
    {
        $this->authorize('cancel', $purchase);
        $user = Auth::user();
        $wallet = $user->wallet;

        if ($request->wantsJson() && $request->isMethod('post')) {
            $maturity_date = \Carbon::parse($purchase->maturity_date)->subDays(2);
            if (!$maturity_date->isFuture()) {
                $json['status'] = false;
                $json['message'] = 'You cant send cancel requests to this staking. Please contact our support center.!';
                $json['icon'] = 'error'; // warning | info | question | success | error
                $json['redirectUrl'] = route('user.staking-cancel-request.index', $purchase);

                return response()->json($json);
            }

            $validated = Validator::make($request->all(), [
                'remark' => 'required|string|max:500'
            ])->validate();

            \DB::transaction(function () use ($user, $purchase, $validated) {
                $staking_cancel = StakingCancelRequest::create([
                    'user_id' => $user->id,
                    'purchased_staking_plan_id' => $purchase->id,
                    'status' => 'PENDING',
                    'remark' => $validated['remark']
                ]);

                $purchase->update([
                    'status' => 'HOLD',
                ]);
            });

            $json['status'] = true;
            $json['message'] = 'Staking cancel request successfully!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = URL::signedRoute('user.staking-cancel-request.index', $purchase);
            $json['data'] = $validated;

            return response()->json($json);
        }

        $package = $purchase->package_info_json?->package ?? $purchase->stakingPlan->package;
        $plan = $purchase->package_info_json ?? $purchase->stakingPlan;

        return view('backend.user.staking.cancel-request', compact('purchase', 'wallet', 'package', 'plan'));
    }


    /**
     * @throws Throwable
     */
    public function reverse(Request $request, StakingCancelRequest $cancelRequest)
    {
        $this->authorize('reverseCancel', $cancelRequest);
        $purchase = $cancelRequest->purchasedStakingPlan;
        $user = Auth::user();
        $wallet = $user->wallet;

        if ($request->wantsJson() && $request->isMethod('post')) {
            $maturity_date = \Carbon::parse($purchase->maturity_date)->subDays(2);
            if (!$maturity_date->isFuture()) {
                $json['status'] = false;
                $json['message'] = 'You cant reverse this request. Please contact our support center.!';
                $json['icon'] = 'error'; // warning | info | question | success | error
                $json['redirectUrl'] = route('user.staking-cancel-request.index', $purchase);

                return response()->json($json);
            }

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required|string|max:250'
            ])->validate();

            \DB::transaction(function () use ($cancelRequest, $validated, $purchase, $user) {
                $cancelRequest->update([
                    'status' => 'CANCELLED',
                    'repudiate_note' => $validated['repudiate_note']
                ]);

                $purchase->update([
                    'status' => 'ACTIVE',
                ]);
            });

            $json['status'] = true;
            $json['message'] = 'Staking cancel request reversed successfully!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = URL::signedRoute('user.staking-cancel-request.index', $purchase);
            $json['data'] = $validated;

            return response()->json($json);
        }


        $package = $purchase->package_info_json?->package ?? $purchase->stakingPlan->package;
        $plan = $purchase->package_info_json ?? $purchase->stakingPlan;

        return view('backend.user.staking.reverse-cancel-request', compact('cancelRequest', 'purchase', 'wallet', 'package', 'plan'));
    }
}
