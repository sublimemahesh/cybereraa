<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function viewSummary(User $user, Transaction $transaction)
    {
        if ($transaction->user_id === $user->id || $user->hasPermissionTo('transactions.viewAny')) {
            return true;
        }
    }

    public function editAmount(User $user, Transaction $transaction)
    {
        if ($transaction->status !== 'PENDING' || $transaction->pay_method !== 'MANUAL') {
            return false;
        }

        if ($user->hasPermissionTo('transactions.edit-amount')) {
            return true;
        }
    }

    public function approve(User $user, Transaction $transaction)
    {
        if ($transaction->status !== 'PENDING' || $transaction->pay_method !== 'MANUAL') {
            return false;
        }

        if ($user->hasPermissionTo('transactions.approve')) {
            return true;
        }
    }

    public function reject(User $user, Transaction $transaction)
    {
        if ($transaction->status !== 'PENDING' || $transaction->pay_method !== 'MANUAL') {
            return false;
        }

        if ($user->hasPermissionTo('transactions.reject')) {
            return true;
        }
    }
}
