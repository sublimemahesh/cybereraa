<?php

namespace App\Policies;

use App\Models\TeamBonus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamBonusPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('special_bonus.viewAny')) {
            return true;
        }
    }

    public function view(User $user, TeamBonus $teamBonus)
    {
        if ($user->hasPermissionTo('special_bonus.viewAny')) {
            return true;
        }
    }


    public function create(User $user)
    {
        return false;
    }

    public function issueBonus(User $user, TeamBonus $teamBonus, array $special_bonus_requirement)
    {
        if ($teamBonus->status === 'QUALIFIED' || $teamBonus->package_ids !== null) {
            return false;
        }

        $investment = $teamBonus->user->total_direct_team_investment;
        $direct_sales = $teamBonus->user->direct_sales_count;
//        if ($teamBonus->user_id === 5) {
//            dd(
//                $direct_sales,
//                $investment,
//                (int)$special_bonus_requirement[1]['direct_sales'],
//                (float)$special_bonus_requirement[1]['total_investment'],
//                ($teamBonus->bonus === '10_DIRECT_SALE'),
//                $direct_sales < (int)$special_bonus_requirement[1]['direct_sales'],
//                $investment < (float)$special_bonus_requirement[1]['total_investment']
//            );
//        }
        if (($teamBonus->bonus === '10_DIRECT_SALE')) {
            if ($direct_sales < $special_bonus_requirement[1]['direct_sales'] || $investment < $special_bonus_requirement[1]['total_investment']) {
                return false;
            }
        }
        if ($teamBonus->bonus === '20_DIRECT_SALE') {
            if ($direct_sales < $special_bonus_requirement[2]['direct_sales'] || $investment < $special_bonus_requirement[2]['total_investment']) {
                return false;
            }
        }
        if ($teamBonus->bonus === '30_DIRECT_SALE') {
            if ($direct_sales < $special_bonus_requirement[3]['direct_sales'] || $investment < $special_bonus_requirement[3]['total_investment']) {
                return false;
            }
        }

        if ($user->hasPermissionTo('special_bonus.issue_bonus')) {
            return true;
        }

    }

    public function update(User $user, TeamBonus $teamBonus)
    {
        return false;
    }

    public function delete(User $user, TeamBonus $teamBonus)
    {
        return false;
    }

    public function restore(User $user, TeamBonus $teamBonus)
    {
        return false;
    }

    public function forceDelete(User $user, TeamBonus $teamBonus)
    {
        return false;
    }
}
