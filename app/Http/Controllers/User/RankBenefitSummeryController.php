<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RankBonusSummery;
use Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RankBenefitSummeryController extends Controller
{
    /**
     * @throws  Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', RankBonusSummery::class);

        if ($request->wantsJson()) {
            $earnings = RankBonusSummery::filter();

            return DataTables::eloquent($earnings)
                ->addColumn('period', function ($reward) {
                    return $reward->start_date . "<br/>" . $reward->end_date;
                })
                ->addColumn('eligible_rankers_str', function ($reward) {
                    $html = '';
                    foreach ($reward->eligible_rankers_array as $rank => $user_count) {
                        if (auth()->user()->currentRank->rank >= $rank) {
                            $html .= "Rank 0{$rank} => {$user_count}, <br>";
                        }
                    }
                    return $html;
                })
                ->addColumn('date', fn($reward) => $reward->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['period', 'eligible_rankers_str'])
                ->make();
        }

        return view('backend.user.ranks.benefits.summery');
    }

    public function requirements(Request $request)
    {
        $this->authorize('viewAny', RankBonusSummery::class);

        $user = \Auth::user();
        $validator = \Validator::make($request->all(), [
            'month' => 'required|date_format:Y-m',
        ]);
        if ($validator->fails()) {
            $month = \Carbon::now()->format('Y-m');
        } else {
            $validated = $validator->validated();
            $month = $validated['month'];

        }

        $summery_exists = RankBonusSummery::whereMonth('start_date', Carbon::parse($month)->format('m'))
            ->whereYear('start_date', Carbon::parse($month)->format('Y'));
        if (!$summery_exists->exists()) {
            $summery = new RankBonusSummery();
            $summery_exists = false;
        } else {
            $summery = $summery_exists->first();
            $summery_exists = true;
        }
        $user->loadMax('activePackages', 'invested_amount');

        $ranks_eligible_gifts = $summery->requirement;
        $current_rank = $user->currentRank->rank; //TODO: get selected month rank
        $highest_active_pkg = $user->active_packages_max_invested_amount;
        $bonus_cal_date_obj = Carbon::parse($month)->addMonth()->firstOfMonth();
        $bonus_cal_date = $bonus_cal_date_obj->format('Y-m-d');

        $highest_active_pkg_for_period = 'UNKNOWN';
        if (!$bonus_cal_date_obj->isFuture()) {
            $highest_active_pkg_for_period = $user->purchasedPackages()
                ->where('created_at', '<=', $bonus_cal_date)
                ->where(\DB::raw('COALESCE(`expiry_status_changed_at`, `updated_at`)'), '>=', $bonus_cal_date)
                ->max('invested_amount') ?? 0;
        }

        return view('backend.user.ranks.benefits.requirements', compact('bonus_cal_date', 'month', 'ranks_eligible_gifts', 'summery', 'summery_exists', 'current_rank', 'highest_active_pkg', 'highest_active_pkg_for_period'));
    }
}
