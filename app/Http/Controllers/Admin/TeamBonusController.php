<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\TeamBonus;
use App\Models\Wallet;
use DB;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class TeamBonusController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('special_bonus.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {

            $bonuses = TeamBonus::with(['user' => fn($q) => $q->withCount('directSales'), 'user.specialBonuses', 'user.directSales'])
                ->when(!empty($request->get('user_id')),
                    static function ($query) use ($request) {
                        $query->where('user_id', $request->get('user_id'));
                    })
                ->filter()
                ->where('type', 'SPECIAL_BONUS');
            $special_bonus_requirement = Strategy::where('name', 'special_bonus_requirement')->firstOr(fn() => new Strategy(['value' => '{"1":{"direct_sales":"10","total_investment":"50000"},"2":{"direct_sales":"20","total_investment":"10000"},"3":{"direct_sales":"30","total_investment":"15000"}}']));
            $special_bonus_requirement = json_decode($special_bonus_requirement->value, true, 512, JSON_THROW_ON_ERROR);

            return DataTables::eloquent($bonuses)
                ->addColumn('actions', function ($bonus) use ($special_bonus_requirement) {
                    if (Gate::allows('issueBonus', [$bonus, $special_bonus_requirement])) {
                        return "<a href='" . route('admin.special-bonus.issue', $bonus) . "' class='btn btn-green btn-outline-success btn-xs me-1 my-1 shadow sharp'>
                                <i class='fas fa-gift'></i>
                            </a>";
                    }
                    if ($bonus->status === 'QUALIFIED') {
                        return 'ISSUED';
                    }
                    return 'Not Eligible';
                })
                ->addColumn('user', function ($bonus) {
                    return
                        "ID: " . str_pad($bonus->user_id, '4', '0', STR_PAD_LEFT) . " <br>
                        USERNAME: <code class='text-uppercase'>{$bonus->user->username}</code>";
                })
                ->addColumn('requirement', function ($bonus) use ($special_bonus_requirement) {
                    $direct_sales = '';
                    $investment = '';
                    if ($bonus->bonus === '10_DIRECT_SALE') {
                        $direct_sales = "Direct Sales: {$special_bonus_requirement[1]['direct_sales']}";
                        $investment = "Team Investment: {$special_bonus_requirement[1]['total_investment']}";
                    }
                    if ($bonus->bonus === '20_DIRECT_SALE') {
                        $direct_sales = "Direct Sales: {$special_bonus_requirement[2]['direct_sales']}";
                        $investment = "Team Investment: {$special_bonus_requirement[2]['total_investment']}";
                    }
                    if ($bonus->bonus === '30_DIRECT_SALE') {
                        $direct_sales = "Direct Sales: {$special_bonus_requirement[3]['direct_sales']}";
                        $investment = "Team Investment: {$special_bonus_requirement[3]['total_investment']}";
                    }
                    return
                        "{$direct_sales} <br>" .
                        $investment;

                })
                ->addColumn('eligibility', function ($bonus) {
                    if ($bonus->package_ids === null) {
                        $investment = "Team Investment: {$bonus->user->total_direct_team_investment}";
                    } else {
                        $investment = PurchasedPackage::whereIn('id', explode(',', $bonus->package_ids))->sum('invested_amount');
                        $investment = "Team Investment: {$investment}";
                    }
                    return
                        "Direct Sales: {$bonus->user->direct_sales_count} <br>" .
                        $investment;
                })
                ->addColumn('created_at_format', function ($bonus) {
                    return $bonus->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['actions', 'user', 'eligibility', 'requirement'])
                ->make();
        }


        return view('backend.admin.team-bonuses.special-bonus.index');
    }

    /**
     * @throws Throwable
     */
    public function issueTeamBonus(Request $request, TeamBonus $bonus)
    {

        $bonus->load(['user' => fn($q) => $q->withCount('directSales'), 'user.specialBonuses', 'user.directSales']);
        $special_bonus_requirement = Strategy::where('name', 'special_bonus_requirement')->firstOr(fn() => new Strategy(['value' => '{"1":{"direct_sales":"10","total_investment":"50000"},"2":{"direct_sales":"20","total_investment":"10000"},"3":{"direct_sales":"30","total_investment":"15000"}}']));
        $special_bonus_requirement = json_decode($special_bonus_requirement->value, true, 512, JSON_THROW_ON_ERROR);

        $this->authorize('issueBonus', [$bonus, $special_bonus_requirement]);

        $team_bonus_requirement = null;
        if ($bonus->bonus === '10_DIRECT_SALE') {
            $team_bonus_requirement = $special_bonus_requirement[1];
        }
        if ($bonus->bonus === '20_DIRECT_SALE') {
            $team_bonus_requirement = $special_bonus_requirement[2];
        }
        if ($bonus->bonus === '30_DIRECT_SALE') {
            $team_bonus_requirement = $special_bonus_requirement[3];
        }

        $excludedPackageIds = $bonus->user->specialBonuses->pluck('package_ids')->flatten()->unique()->implode(',');


        if ($request->wantsJson()) {

            $validated = Validator::make($request->all(), [
                'package_ids' => 'required|array|not_in:' . $excludedPackageIds
            ])->validate();

            $package_amount = PurchasedPackage::whereIn('id', $validated['package_ids'])
                ->whereIn('user_id', $bonus->user->directSales->pluck('id')->toArray())
                ->sum('invested_amount');

            if ($package_amount < $team_bonus_requirement['total_investment']) {
                $json['status'] = false;
                $json['message'] = "Package Requirements not met!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $bonus = DB::transaction(static function () use ($package_amount, $team_bonus_requirement, $bonus, $validated) {

                $earned_amount = ($package_amount * $team_bonus_requirement['bonus']) / 100;
                $summary = [
                    'total_investment' => $package_amount,
                    'bonus_percentage' => $team_bonus_requirement['bonus'],
                    'earned_amount' => $earned_amount,
                    'requirement' => $team_bonus_requirement,
                ];

                $bonus->update([
                    'amount' => $earned_amount,
                    'paid' => $earned_amount,
                    'bonus_date' => date('Y-m-d'),
                    'status' => 'QUALIFIED',
                    'package_ids' => implode(',', $validated['package_ids']),
                    'summery' => json_encode($summary, JSON_THROW_ON_ERROR)
                ]);

                $bonus->earnings()->save(Earning::forceCreate([
                    'user_id' => $bonus->user_id,
                    'amount' => $earned_amount,
                    'payed_percentage' => $team_bonus_requirement['bonus'],
                    'type' => 'SPECIAL_BONUS',
                    'status' => 'RECEIVED',
                ]));

                $wallet = Wallet::firstOrCreate(
                    ['user_id' => $bonus->user_id],
                    ['topup_balance' => 0]
                );

                $wallet->increment('topup_balance', $earned_amount);

                return $bonus;
            });

            $json['status'] = true;
            $json['message'] = "Bonus Issued";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.special-bonus');
            return response()->json($json, Response::HTTP_OK);
        }

        $allowed_packages = PurchasedPackage::with('user')
            ->when(!empty($excludedPackageIds),
                function ($q) use ($excludedPackageIds) {
                    $q->whereNotIn('id', $excludedPackageIds);
                })
            ->whereIn('user_id', $bonus->user->directSales->pluck('id')->toArray())
            ->get();

        $total_direct_team_investment = $bonus->user->total_direct_team_investment;
        $direct_sales_count = $bonus->user->direct_sales_count;

        return view('backend.admin.team-bonuses.special-bonus.issue-bonus', compact('team_bonus_requirement', 'bonus', 'allowed_packages', 'total_direct_team_investment', 'direct_sales_count'));
    }
}
