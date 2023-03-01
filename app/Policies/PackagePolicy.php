<?php

namespace App\Policies;

use App\Models\Package;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    public function purchase($user, Package $package, $max_amount)
    {
        return $max_amount <= $package->amount;
    }

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('package.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Package $package)
    {
        if ($user->hasPermissionTo('package.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('package.create')) {
            return true;
        }
    }

    public function update(User $user, Package|null $package = null)
    {
        if ($user->hasPermissionTo('package.update')) {
            return true;
        }
    }

    public function delete(User $user, Package $package)
    {
        $package->loadCount('purchasedPackages');
        if ($package->purchased_packages_count === 0 && $user->hasPermissionTo('package.delete')) {
            return true;
        }
    }

    public function restore(User $user, Package $package)
    {
        if ($user->hasPermissionTo('package.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Package $package)
    {
        $package->load('purchasedPackages');
        if ($package->purchased_packages_count === 0 && $user->hasPermissionTo('package.delete')) {
            return true;
        }
    }

}
