<?php

namespace App\Policies;

use App\Models\PurchasedStakingPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasedStakingPlanPolicy
{
    use HandlesAuthorization;

    public function cancel(User $user, PurchasedStakingPlan $withdraw): bool
    {
        return $user->hasRole('user') && $withdraw->status === 'PENDING';
    }

    public function reverseCancel(User $user, PurchasedStakingPlan $withdraw): bool
    {
        return $user->hasRole('user') && $withdraw->status === 'HOLD';
    }


    public function process(User $user, PurchasedStakingPlan $plan)
    {
        if ($plan->status !== 'PENDING') {
            return false;
        }
        if ($user->hasPermissionTo('stakingCancel.approve')) {
            return true;
        }
    }

    public function approve(User $user, PurchasedStakingPlan $plan)
    {
        if (!in_array($plan->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasPermissionTo('stakingCancel.approve')) {
            return true;
        }
    }


    public function reject(User $user, PurchasedStakingPlan $withdraw)
    {
        if (!in_array($withdraw->status, ['PENDING', 'PROCESSING'])) {
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
