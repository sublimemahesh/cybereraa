<?php

namespace App\Policies;

use App\Models\Package;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function view(User $user, Package $package)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function create(User $user)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function update(User $user, Package $package)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function delete(User $user, Package $package)
    {
        $package->loadCount('purchasedPackages');
        $role = $user->getRoleNames()->first();
        return $package->user_packages_count === 0 && ($role === 'admin' || $role === 'super_admin');
    }

    public function restore(User $user, Package $package)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function forceDelete(User $user, Package $package)
    {
        $package->load('purchasedPackages');
        $role = $user->getRoleNames()->first();
        return $package->user_packages_count === 0 && ($role === 'admin' || $role === 'super_admin');
    }

}
