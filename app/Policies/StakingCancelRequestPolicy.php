<?php

namespace App\Policies;

use App\Models\PurchasedStakingPlan;
use App\Models\StakingCancelRequest;
use App\Models\User;
use Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class StakingCancelRequestPolicy
{
    use HandlesAuthorization;

    public function reverseCancel(User $user, StakingCancelRequest $cancelRequest): bool
    {
        return $user->hasRole('user') && $cancelRequest->user_id === $user->id &&
            $cancelRequest->status === 'PENDING' &&
            $cancelRequest->purchasedStakingPlan->status === 'HOLD' && Carbon::parse($cancelRequest->purchasedStakingPlan->maturity_date)->isFuture();
    }


    public function process(User $user, StakingCancelRequest $cancelRequest)
    {
        if ($cancelRequest->status !== 'PENDING') {
            return false;
        }
        if ($user->hasPermissionTo('stakingCancel.approve')) {
            return true;
        }
    }

    public function approve(User $user, StakingCancelRequest $cancelRequest)
    {
        if (!in_array($cancelRequest->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasPermissionTo('stakingCancel.approve')) {
            return true;
        }
    }


    public function reject(User $user, StakingCancelRequest $cancelRequest)
    {
        if (!in_array($cancelRequest->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasPermissionTo('stakingCancel.reject')) {
            return true;
        }
    }

    public function delete(User $user, PurchasedStakingPlan $purchasedStakingPlan)
    {
        return false;
    }


    public function restore(User $user, PurchasedStakingPlan $purchasedStakingPlan)
    {
        return false;
    }

    public function forceDelete(User $user, PurchasedStakingPlan $purchasedStakingPlan)
    {
        return false;
    }
}
