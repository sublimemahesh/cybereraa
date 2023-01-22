<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RankGift;
use Auth;
use DataTables;
use Exception;
use Illuminate\Http\Request;

class RankGiftController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $ranks = RankGift::with('rank', 'user')
                ->where('user_id', Auth::user()->id)
                ->whereRelation('rank', function ($q) {
                    $q->whereNotNull('activated_at');
                })
                ->latest();

            return DataTables::eloquent($ranks)
                ->addColumn('image', static function ($gift) {
                    if ($gift->image_name !== null) {
                        return
                            "<a href='" . storage('ranks/gifts/' . $gift->rank->rank . '/proof/' . $gift->image_name) . "' target='_blank' >
                                <img src='" . storage('ranks/gifts/' . $gift->rank->rank . '/proof/' . $gift->image_name) . "' class='img-thumbnail my-2' width='50' alt='' /> 
                            </a>";
                    }
                    return '-';
                })
                ->addColumn('rank', fn($gift) => "Rank " . $gift->rank->rank)
                ->addColumn('status', fn($gift) => $gift->status)
                ->addColumn('created_at', fn($gift) => $gift->created_at->format('Y-m-d H:i:s'))
                ->addColumn('gift_requirement', function ($gift) {
                    return "Investment: <code class=''>{$gift->gift_requirement->total_investment}</code><br>" .
                        "Team: <code class=''>{$gift->gift_requirement->total_team_investment}</code><br>";
                })
                ->addColumn('total_investment', fn($gift) => number_format($gift->total_investment, 2))
                ->addColumn('total_team_investment', fn($gift) => number_format($gift->total_team_investment, 2))
                ->rawColumns(['image', 'gift_requirement'])
                ->make();
        }


        return view('backend.user.ranks.gifts.index');
    }

}
