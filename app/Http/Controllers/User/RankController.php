<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function teamRankers(Request $request)
    {
        $ranks = Rank::where('user_id', \Auth::user()->id)->get();
        return view('backend.user.ranks.team.rankers-count', compact('ranks'));
    }
}
