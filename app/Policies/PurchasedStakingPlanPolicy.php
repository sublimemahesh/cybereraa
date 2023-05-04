<?php

namespace App\Policies;

use App\Models\PurchasedStakingPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasedStakingPlanPolicy
{
    use HandlesAuthorization;

    public function cancel(User $user, PurchasedStakingPlan $purchasedPlan): bool
    {
        return $user->hasRole('user') && $purchasedPlan->user_id === $user->id && $purchasedPlan->status === 'ACTIVE';
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
