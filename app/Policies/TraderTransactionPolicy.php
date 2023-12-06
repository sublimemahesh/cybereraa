<?php

namespace App\Policies;

use App\Models\TraderTransaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TraderTransactionPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('trader_transaction.viewAny')) {
            return true;
        }
    }

    public function view(User $user, TraderTransaction $transaction)
    {
        if ($user->hasPermissionTo('trader_transaction.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('trader_transaction.create')) {
            return true;
        }
    }

    public function update(User $user, TraderTransaction|null $transaction = null)
    {
        if ($user->hasPermissionTo('trader_transaction.update')) {
            return true;
        }
    }

    public function delete(User $user, TraderTransaction $transaction)
    {

        if ($user->hasPermissionTo('trader_transaction.delete')) {
            return true;
        }
    }

    public function restore(User $user, TraderTransaction $transaction)
    {
        if ($user->hasPermissionTo('trader_transaction.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, TraderTransaction $transaction)
    {

        if ($user->hasPermissionTo('trader_transaction.delete')) {
            return true;
        }
    }

}
