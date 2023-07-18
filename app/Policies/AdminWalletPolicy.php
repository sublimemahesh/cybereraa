<?php

namespace App\Policies;

use App\Models\AdminWallet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminWalletPolicy
{
    use HandlesAuthorization;


    public function withdraw(User $user, AdminWallet $wallet)
    {
        if ($wallet->wallet_type === "BONUS_PENDING") {
            return false;
        }
        if ($user->hasPermissionTo('admin_wallet_withdrawal.create')) {
            return true;
        }
    }
}
