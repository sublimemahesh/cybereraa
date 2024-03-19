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
        if ($withdraw->user_id === $user->id || $user->hasPermissionTo('withdrawals.viewAny')) {
            return true;
        }
    }

    public function processWithdraw(User $user, Withdraw $withdraw)
    {
        if ($withdraw->status !== 'PENDING') {
            return false;
        }
        if ($user->hasAnyPermission(['withdraw.approve', 'withdraw.bulk.process'])) {
            return true;
        }
    }

    public function approveWithdraw(User $user, Withdraw $withdraw)
    {
        if (!in_array($withdraw->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasAnyPermission(['withdraw.approve', 'withdraw.bulk.approve'])) {
            return true;
        }
    }

    public function cancelWithdraw(User $user, Withdraw $withdraw)
    {
        return $user->hasRole('user') && $withdraw->status === 'PENDING';
    }

    public function rejectWithdraw(User $user, Withdraw $withdraw)
    {
        if (!in_array($withdraw->status, ['PENDING', 'PROCESSING'])) {
            return false;
        }
        if ($user->hasAnyPermission(['withdraw.reject', 'withdraw.bulk.reject'])) {
            return true;
        }
    }

    public function p2pConfirm(User $user, Withdraw $withdraw)
    {
        return $user->hasRole('user') && $withdraw->receiver_id === $user->id && $withdraw->type === 'P2P' && $withdraw->proof_document === null;
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
