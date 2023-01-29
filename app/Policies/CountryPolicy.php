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
        if ($user->hasPermissionTo('country.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Country $country)
    {
        if ($user->hasPermissionTo('country.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('country.create')) {
            return true;
        }
    }

    public function update(User $user, Country $country)
    {
        if ($user->hasPermissionTo('country.update')) {
            return true;
        }
    }

    public function delete(User $user, Country $country)
    {
        if ($user->hasPermissionTo('country.delete')) {
            return true;
        }
    }

    public function restore(User $user, Country $country)
    {
        if ($user->hasPermissionTo('country.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Country $country)
    {
        if ($user->hasPermissionTo('country.delete')) {
            return true;
        }
    }
}
