<?php

namespace App\Policies;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankPolicy
{
    use HandlesAuthorization;

    public function issueBonus(User $user, Rank $rank)
    {
        return $rank->is_active && $rank->rank <= 2 && $rank->benefits()->doesntExist();
    }

    public function viewAny(User $user)
    {
        //
    }


    public function view(User $user, Rank $rank)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Rank $rank)
    {
        //
    }

    public function delete(User $user, Rank $rank)
    {
        //
    }

    public function restore(User $user, Rank $rank)
    {
        //
    }

    public function forceDelete(User $user, Rank $rank)
    {
        //
    }
}
