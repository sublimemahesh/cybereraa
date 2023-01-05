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
        return $user->hasRole(['admin', 'super_admin']) || $user->hasPermissionTo('view_any_strategies');
    }

    public function view(User $user, Strategy $strategy)
    {
        return $user->hasRole(['admin', 'super_admin']) || $user->hasPermissionTo('view_strategies');
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return $user->hasRole(['admin', 'super_admin']) || $user->hasPermissionTo('update_strategies');
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
