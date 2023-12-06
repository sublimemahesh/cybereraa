<?php

namespace App\Policies;

use App\Models\Trader;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TraderPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('trader.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Trader $trader)
    {
        if ($user->hasPermissionTo('trader.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('trader.create')) {
            return true;
        }
    }

    public function update(User $user, Trader|null $trader = null)
    {
        if ($user->hasPermissionTo('trader.update')) {
            return true;
        }
    }

    public function delete(User $user, Trader $trader)
    {
        $trader->loadCount('traderTransactions');
        if ($trader->trader_transactions_count > 0) {
            return false;
        }
        if ($user->hasPermissionTo('trader.delete')) {
            return true;
        }
    }

    public function restore(User $user, Trader $trader)
    {
        if ($user->hasPermissionTo('trader.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Trader $trader)
    {
        $trader->loadCount('traderTransactions');
        if ($trader->trader_transactions_count !== 0) {
            return false;
        }
        if ($user->hasPermissionTo('trader.delete')) {
            return true;
        }
    }

}
