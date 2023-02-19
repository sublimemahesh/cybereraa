<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('withdrawals.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Withdraw $withdraw)
    {
        if ($user->hasPermissionTo('withdrawals.viewAny')) {
            return true;
        }
    }

    public function approveWithdraw(User $user, Withdraw $withdraw)
    {
        if (!in_array($withdraw->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasPermissionTo('withdraw.approve')) {
            return true;
        }
    }

    public function rejectWithdraw(User $user, Withdraw $withdraw)
    {
        if (!in_array($withdraw->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasPermissionTo('withdraw.reject')) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->hasRole('user');
    }

    public function update(User $user, Withdraw $withdraw)
    {
        return false;
    }

    public function delete(User $user, Withdraw $withdraw)
    {
        return false;
    }

    public function restore(User $user, Withdraw $withdraw)
    {
        return false;
    }


    public function forceDelete(User $user, Withdraw $withdraw)
    {
        return false;
    }
}
