<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankBonusSummery;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RankBenefitSummeryController extends Controller
{
    /**
     * @throws  Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('rank_bonus.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $earnings = RankBonusSummery::filter();

            return DataTables::eloquent($earnings)
                ->addColumn('period', function ($reward) {
                    return $reward->start_date . "</br>" . $reward->end_date;
                })
                ->addColumn('eligible_rankers_str', function ($reward) {
                    $html = '';
                    foreach ($reward->eligible_rankers_array as $rank => $user_count) {
                        $html .= "Rank 0{$rank} => {$user_count}, <br>";
                    }
                    return $html;
                })
                ->addColumn('date', fn($reward) => $reward->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['period', 'eligible_rankers_str'])
                ->make();
        }

        return view('backend.admin.ranks.benefits.summery');
    }
}
