<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Models\RankBenefit;
use App\Models\Wallet;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RankController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rank.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {
            $ranks = Rank::with('user')
                ->when(!empty($request->get('user_id')),
                    static function ($query) use ($request) {
                        $query->where('user_id', $request->get('user_id'));
                    })
                ->filter();

            return DataTables::eloquent($ranks)
                ->addColumn('user', function ($rank) {
                    return
                        "ID: " . str_pad($rank->user_id, '4', '0', STR_PAD_LEFT) . " <br>
                        USERNAME: <code class='text-uppercase'>{$rank->user->username}</code>";
                })
                ->addColumn('requirement', function ($rank) {
                    if ($rank->rank === 1) {
                        return "Investment: 1000 <br>
                            Direct Team 10 &  <br>
                            Team Total 5000 Investment <br>
                            <center>OR</center>
                            Direct Team 5&  <br> Team Total 10000 Investment";
                    }
                    if ($rank->rank >= 2) {
                        return "R" . ($rank->rank - 1) . " x 5";
                    }
                    return '-';
                })
                ->addColumn('eligibility', function ($rank) {
                    if ($rank->completed_requirements === null) {
                        return '-';
                    }
                    $completed_requirements = $rank->completed_requirements;
                    if ($rank->rank === 1) {
                        $investment = $rank->user->purchasedPackages()->sum('invested_amount');

                        return "Investment: {$investment} <br>
                            Direct Team count: " . $completed_requirements['direct_sales_count'] . " <br>
                            Direct Team Investment " . $completed_requirements['cumulative_investment_of_direct_sales'];
                    }
                    if ($rank->rank === 2) {
                        return "R1 x " . $completed_requirements['rank_one_rankers_count'];
                    }

                    if ($rank->rank === 3) {
                        return "R2 x " . $completed_requirements['rank_two_rankers_count'];
                    }

                    if ($rank->rank === 4) {
                        return "R3 x " . $completed_requirements['rank_three_rankers_count'];
                    }
                    return '-';
//                    return $rank->eligibility_percentage . '%';
                })
                ->addColumn('rank', fn($rank) => "R{$rank->rank}")
                ->addColumn('status', fn($rank) => $rank->is_active ? "ACTIVE" : "INACTIVE")
                ->addColumn('activated', fn($rank) => $rank->activated_at ? Carbon::parse($rank->activated_at)->format('Y-m-d H:i:s') : '-')
                ->addColumn('created', fn($rank) => $rank->created_at->format('Y-m-d H:i:s'))
                ->addColumn('actions', function ($rank) {
                    $actions = 'Not Eligible';
                    if (Gate::allows('issueBonus', $rank)) {
//                    if ($rank->is_active) {
                        $actions = '<a href="javascript:void(0)" data-id="' . $rank->id . '" title="Issue Bonus" class="btn btn-xs btn-success sharp issue-bonus my-1 mr-1 shadow">
                                    <i class="fa fa-check-circle"></i>
                                </a>';
                    }
                    return $actions;
                })
                ->rawColumns(['user', 'eligibility', 'requirement', 'actions'])
                ->make();
        }


        return view('backend.admin.ranks.index');
    }

    /**
     */
    public function issueBonus(Request $request, Rank $rank)
    {
        $this->authorize('issueBonus', $rank);
//        abort_if(!$rank->is_active, 403);


        \DB::transaction(function () use ($rank) {

            $completed_requirements = $rank->completed_requirements;
            $bonus_amount = 0;
            if ($rank->rank === 1) {
                $rank_unlocked_cumulative_investment_of_direct_sales = $completed_requirements['rank_unlocked']['cumulative_investment_of_direct_sales'];
                $bonus_amount = ($rank_unlocked_cumulative_investment_of_direct_sales * 5) / 100;
            }

            if ($rank->rank === 2) {
                $cumulative_investments_of_rank_one_descendants = array_sum($completed_requirements['rank_unlocked']['cumulative_investments_of_rank_one_descendants']);
                $bonus_amount = ($cumulative_investments_of_rank_one_descendants * 5) / 100;
            }

            $benefit = RankBenefit::forceCreate([
                'user_id' => $rank->user_id,
                'rank_id' => $rank->id,
                'amount' => $bonus_amount,
                'paid' => 0,
                'type' => 'RANK_BONUS',
                'status' => 'QUALIFIED',
                'bonus_date' => Carbon::now()->subMonth()->format('Y-m-d')
            ]);

            $wallet = Wallet::firstOrCreate(
                ['user_id' => $benefit->user_id],
                ['topup_balance' => 0]
            );
            $wallet->increment('topup_balance', $benefit->amount);
            $benefit->update(['paid' => $benefit->amount, 'last_earned_at' => Carbon::now()]);

        });

        $json['status'] = true;
        $json['message'] = 'Bonus Issued';
        $json['icon'] = 'success'; // warning | info | question | success | error

        return response()->json($json);
    }
}
