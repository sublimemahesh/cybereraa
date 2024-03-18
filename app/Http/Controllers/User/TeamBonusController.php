<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Strategy;
use App\Models\TeamBonus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamBonusController extends Controller
{
    /**
     * @throws \JsonException
     */
    public function requirements(Request $request)
    {
        abort(Response::HTTP_FORBIDDEN);
        $user = \Auth::user();
        $user?->load('specialBonuses');
        $user?->loadCount('directSales');

        $bonuses = TeamBonus::where('user_id', $user?->id)
            ->where('type', 'SPECIAL_BONUS');

        $special_bonus_requirement = Strategy::where('name', 'special_bonus_requirement')->firstOr(fn() => new Strategy(['value' => '{"1":{"direct_sales":"10","total_investment":"50000"},"2":{"direct_sales":"20","total_investment":"10000"},"3":{"direct_sales":"30","total_investment":"15000"}}']));
        $special_bonus_requirement = json_decode($special_bonus_requirement->value, true, 512, JSON_THROW_ON_ERROR);

        $total_direct_team_investment = $user?->total_direct_team_investment;
        $direct_sales = $user->direct_sales_count ?? 0;

        return view('backend.user.team-bonuses.special-bonus-requirements', compact(
            'bonuses',
            'special_bonus_requirement',
            'total_direct_team_investment',
            'direct_sales',
        ));
    }
}
