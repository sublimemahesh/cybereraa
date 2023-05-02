<?php

namespace App\Policies;

use App\Models\StakingPackage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StakingPackagePolicy
{
    use HandlesAuthorization;

    public function purchase($user, StakingPackage $StakingPackage)
    {
        return true;
    }

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('staking_package.viewAny')) {
            return true;
        }
    }


    public function view(User $user, StakingPackage $package)
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


    public function update(User $user, StakingPackage|null  $package = null)
    {
        if ($user->hasPermissionTo('staking_package.update')) {
            return true;
        }
    }


    public function delete(User $user, StakingPackage $package)
    {
        if ($package->plans_count > 0) {
            return false;
        }
        if ($package->plans_count === 0 && $user->hasPermissionTo('staking_package.delete')) {
            return true;
        }
    }


    public function restore(User $user, StakingPackage $package)
    {
        if ($user->hasPermissionTo('staking_package.update')) {
            return true;
        }
    }


    public function forceDelete(User $user, StakingPackage $package)
    {
        if ($package->plans_count > 0) {
            return false;
        }
        if ($package->plans_count === 0 && $user->hasPermissionTo('staking_package.delete')) {
            return true;
        }
    }
}
