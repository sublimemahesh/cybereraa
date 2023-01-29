<?php

namespace App\Policies;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('currency.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Currency $currency)
    {
        if ($user->hasPermissionTo('currency.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('currency.create')) {
            return true;
        }
    }

    public function update(User $user, Currency $currency)
    {
        if ($user->hasPermissionTo('currency.update')) {
            return true;
        }
    }

    public function delete(User $user, Currency $currency)
    {
        if ($user->hasPermissionTo('currency.delete')) {
            return true;
        }
    }

    public function restore(User $user, Currency $currency)
    {
        if ($user->hasPermissionTo('currency.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Currency $currency)
    {
        if ($user->hasPermissionTo('currency.delete')) {
            return true;
        }
    }
}
