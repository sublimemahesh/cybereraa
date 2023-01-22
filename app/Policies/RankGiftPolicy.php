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
        return (/*$user->hasAnyPermission(['issue_rank_gift', 'view_any_rank_gift']) ||*/ $user->hasRole('admin'));
    }

    public function view(User $user, RankGift $gift)
    {
        return ($gift->user_id === $user->id || /*$user->hasAnyPermission(['issue_rank_gift', 'view_any_rank_gift']) ||*/ $user->hasRole('admin'));
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
        return $gift->status === 'QUALIFIED' && (/*$user->hasPermissionTo('issue_gift') ||*/ $user->hasRole('admin'));
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
