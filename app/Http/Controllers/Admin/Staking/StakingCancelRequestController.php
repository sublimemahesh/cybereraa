<?php

namespace App\Http\Controllers\Admin\Staking;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\PurchasedStakingPlan;
use App\Models\StakingCancelRequest;
use App\Models\Wallet;
use Auth;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

class StakingCancelRequestController extends Controller
{
    public function index(Request $request, PurchasedStakingPlan $purchase)
    {
        abort_if(Gate::denies('stakingCancel.viewAny'), Response::HTTP_FORBIDDEN);

        $cancel_requests = $purchase->cancelRequests;

        $package = $purchase->package_info_json?->package ?? $purchase->stakingPlan->package;
        $plan = $purchase->package_info_json ?? $purchase->stakingPlan;

        return view('backend.admin.users.staking-plans.cancellations', compact('cancel_requests', 'purchase', 'package', 'plan'));
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function process(Request $request, StakingCancelRequest $cancelRequest)
    {
        $this->authorize('process', $cancelRequest);

        \DB::transaction(function () use ($cancelRequest) {
            $cancelRequest->update([
                'status' => 'PROCESSING',
            ]);
            // TODO: SEND MAIL
        });

        $json['status'] = true;
        $json['message'] = 'Staking Cancel Processed';
        $json['icon'] = 'success'; // warning | info | question | success | error

        return response()->json($json);
    }


    /**
     * @throws Throwable
     */
    public function approve(Request $request, StakingCancelRequest $cancelRequest)
    {
        $this->authorize('approve', $cancelRequest);
        $purchase = $cancelRequest->purchasedStakingPlan;
        $user = Auth::user();
        $wallet = $user->wallet;

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'interest_rate' => 'nullable|numeric'
            ])->validate();

            $interest_rate = $validated['interest_rate'] ?? 0;

            \DB::transaction(function () use ($purchase, $interest_rate, $cancelRequest, $user) {

                $total_release_staking_amount = $purchase->invested_amount + ($purchase->invested_amount * $interest_rate / 100);

                $cancelRequest->update([
                    'status' => 'APPROVED',
                    'interest_rate' => $interest_rate,
                    'total_released_amount' => $total_release_staking_amount,
                ]);

                $purchase->update([
                    'status' => 'CANCELLED',
                ]);

                $purchase->earnings()->save(Earning::forceCreate([
                    'user_id' => $cancelRequest->user_id,
                    'currency' => 'USDT',
                    'amount' => $total_release_staking_amount,
                    'type' => 'STAKING',
                    'status' => 'RECEIVED'
                ]));

                $user_wallet = Wallet::firstOrCreate(
                    ['user_id' => $cancelRequest->user_id],
                    ['staking_balance' => 0]
                );

                $user_wallet->increment('staking_balance', $total_release_staking_amount);
            });

            // TODO: SEND MAIL

            $json['status'] = true;
            $json['message'] = 'Staking cancel request approved successfully!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.staking-cancel-request.index', $purchase);
            $json['data'] = $validated;

            return response()->json($json);
        }


        $package = $purchase->package_info_json?->package ?? $purchase->stakingPlan->package;
        $plan = $purchase->package_info_json ?? $purchase->stakingPlan;

        return view('backend.admin.users.staking-plans.approve-cancel-request', compact('cancelRequest', 'purchase', 'wallet', 'package', 'plan'));
    }

    /**
     * @throws Throwable
     */
    public function reject(Request $request, StakingCancelRequest $cancelRequest)
    {
        $this->authorize('reject', $cancelRequest);
        $purchase = $cancelRequest->purchasedStakingPlan;
        $user = Auth::user();
        $wallet = $user->wallet;

        if ($request->wantsJson() && $request->isMethod('post')) {
            $maturity_date = \Carbon::parse($purchase->maturity_date);
            if (!$maturity_date->isFuture()) {
                $json['status'] = false;
                $json['message'] = 'You cant reject this request. Because Maturity date is passed. Please accept the cancel request with suitable interest!';
                $json['icon'] = 'error'; // warning | info | question | success | error

                return response()->json($json);
            }

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required|string|max:250'
            ])->validate();

            \DB::transaction(function () use ($cancelRequest, $validated, $purchase, $user) {
                $cancelRequest->update([
                    'status' => 'REJECTED',
                    'repudiate_note' => $validated['repudiate_note']
                ]);

                $purchase->update([
                    'status' => 'ACTIVE',
                ]);
            });

            // TODO: SEND MAIL

            $json['status'] = true;
            $json['message'] = 'Staking cancel request rejected successfully!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.staking-cancel-request.index', $purchase);
            $json['data'] = $validated;

            return response()->json($json);
        }


        $package = $purchase->package_info_json?->package ?? $purchase->stakingPlan->package;
        $plan = $purchase->package_info_json ?? $purchase->stakingPlan;

        return view('backend.admin.users.staking-plans.reject-cancel-request', compact('cancelRequest', 'purchase', 'wallet', 'package', 'plan'));
    }
}
