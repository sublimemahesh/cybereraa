<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function view(User $user, Country $country)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function create(User $user)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function update(User $user, Country $country)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function delete(User $user, Country $country)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function restore(User $user, Country $country)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }

    public function forceDelete(User $user, Country $country)
    {
        $role = $user->getRoleNames()->first();
        return $role === 'admin' || $role === 'super_admin';
    }
}
