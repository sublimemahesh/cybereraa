<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rank;
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
                        "ID: " .str_pad($rank->user_id, '4', '0', STR_PAD_LEFT) . " <br>
                        USERNAME: <code class='text-uppercase'>{$rank->user->username}</code>";
                })
                ->addColumn('eligibility', function ($rank) {
                    return $rank->eligibility;
                })
                ->addColumn('status', fn($rank) => $rank->is_active ? "ACTIVE" : "INACTIVE")
                ->addColumn('activated', fn($rank) => $rank->activated_at ? Carbon::parse($rank->activated_at)->format('Y-m-d H:i:s') : '-')
                ->addColumn('created', fn($rank) => $rank->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user'])
                ->make();
        }


        return view('backend.admin.ranks.index');
    }
}
