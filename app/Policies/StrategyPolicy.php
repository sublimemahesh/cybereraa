<?php

namespace App\Policies;

use App\Models\Strategy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StrategyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('strategy.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Strategy $strategy)
    {
        if ($user->hasPermissionTo('strategy.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        if ($user->hasPermissionTo('strategy.update')) {
            return true;
        }
    }

    public function delete(User $user, Strategy $strategy)
    {
        return false;
    }


    public function restore(User $user, Strategy $strategy)
    {
        return false;
    }

    public function forceDelete(User $user, Strategy $strategy)
    {
        return false;
    }
}
