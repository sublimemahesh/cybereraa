<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankBonusSummeryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function viewSummery(User $user)
    {
        return $user->currentRank->rank >= 3;
    }

    public function viewRequirement(User $user)
    {
        return true;
    }
}
