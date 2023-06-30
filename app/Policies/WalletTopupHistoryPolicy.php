<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WalletTopupHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletTopupHistoryPolicy
{
    use HandlesAuthorization;


    public function confirmRequest(User $user, WalletTopupHistory $topupHistory)
    {
        if ($topupHistory->status !== 'PENDING' || $topupHistory->proof_documentation === null) {
            return false;
        }
        if ($user->hasPermissionTo('wallet.topup')) {
            return true;
        }
    }
}
