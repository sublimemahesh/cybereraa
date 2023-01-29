<?php

namespace App\Policies;

use App\Models\RankGift;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankGiftPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('rank_gift.viewAny')) {
            return true;
        }
    }

    public function view(User $user, RankGift $gift)
    {
        if (($gift->user_id === $user->id || $user->hasPermissionTo('rank_gift.viewAny'))) {
            return true;
        }
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, RankGift $gift)
    {
        return false;
    }

    public function issue(User $user, RankGift $gift)
    {
        if ($gift->status === 'QUALIFIED' && $user->hasPermissionTo('rank_gift.issue_gift')) {
            return true;
        }
    }

    public function delete(User $user, RankGift $gift)
    {
        return false;
    }


    public function restore(User $user, RankGift $gift)
    {
        return false;
    }

    public function forceDelete(User $user, RankGift $gift)
    {
        return false;
    }
}
