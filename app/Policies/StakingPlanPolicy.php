<?php

namespace App\Policies;

use App\Models\StakingPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StakingPlanPolicy
{
    use HandlesAuthorization;

    public function purchase($user, StakingPlan $plan)
    {
        return true;
    }

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('staking_package.viewAny')) {
            return true;
        }
    }


    public function view(User $user, StakingPlan $plan)
    {
        if ($user->hasPermissionTo('staking_package.viewAny')) {
            return true;
        }
    }


    public function create(User $user)
    {

        if ($user->hasPermissionTo('staking_package.create')) {
            return true;
        }
    }


    public function update(User $user, StakingPlan|null $plan = null)
    {
        if ($user->hasPermissionTo('staking_package.update')) {
            return true;
        }
    }


    public function delete(User $user, StakingPlan $plan)
    {
        $plan->loadCount('purchasedPackage');
        if ($plan->purchased_package_count > 0) {
            return false;
        }
        if ($plan->purchased_package_count === 0 && $user->hasPermissionTo('staking_package.delete')) {
            return true;
        }
        if ($user->hasPermissionTo('staking_package.delete')) {
            return true;
        }
    }


    public function restore(User $user, StakingPlan $plan)
    {
        if ($user->hasPermissionTo('staking_package.update')) {
            return true;
        }
    }


    public function forceDelete(User $user, StakingPlan $plan)
    {
        $plan->loadCount('purchasedPackage');
        if ($plan->purchased_package_count > 0) {
            return false;
        }
        if ($plan->purchased_package_count === 0 && $user->hasPermissionTo('staking_package.delete')) {
            return true;
        }
    }
}
