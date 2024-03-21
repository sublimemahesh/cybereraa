<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RankController extends Controller
{

    public function myRanks(Request $request)
    {
        $ranks = Rank::where('user_id', Auth::user()->id)->orderBy('rank')->get();
        $highestRank = Auth::user()->highest_rank;
        return view('backend.user.ranks.rank-summary', compact('ranks', 'highestRank'));
    }

    public function RankSummary(Request $request)
    {
        $ranks = Rank::where('user_id', \Auth::user()->id)->get();
        return view('backend.user.ranks.team.rankers-count', compact('ranks'));
    }

    /**
     * @throws Exception
     */
    public function teamRankers(Request $request)
    {
        if ($request->wantsJson()) {
            $ranks = Rank::with('user')
                ->whereIn('user_id', Auth::user()->descendantsAndSelf()->pluck('id')->toArray())
                ->when(!empty($request->get('user_id')),
                    static function ($query) use ($request) {
                        $query->where('user_id', $request->get('user_id'));
                    })
                ->filter()
                ->orderBy('rank', 'desc')
                ->orderBy('total_rankers', 'desc');

            return DataTables::eloquent($ranks)
                ->addColumn('user', function ($rank) {
                    return
                        "ID: " . str_pad($rank->user_id, '4', '0', STR_PAD_LEFT) . " <br>
                        USERNAME: <code class='text-uppercase'>{$rank->user->username}</code>";
                })
                ->addColumn('eligibility', function ($rank) {
                    return $rank->eligibility_percentage . '%';
                })
                ->addColumn('status', fn($rank) => $rank->is_active ? "ACTIVE" : "INACTIVE")
                ->addColumn('activated', fn($rank) => $rank->activated_at ? Carbon::parse($rank->activated_at)->format('Y-m-d H:i:s') : '-')
                ->addColumn('created', fn($rank) => $rank->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user'])
                ->make();
        }


        return view('backend.user.ranks.team.downline-rankers-list');
    }
}
