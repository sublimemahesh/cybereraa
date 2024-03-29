<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankGift;
use DB;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class RankGiftController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('rank_gift.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $ranks = RankGift::with('rank', 'user')
                ->when(!empty($request->get('user_id')),
                    static function ($query) use ($request) {
                        $query->where('user_id', $request->get('user_id'));
                    })
                ->whereRelation('rank', function ($q) {
                    $q->whereNotNull('activated_at');
                })
                ->filter()
                ->latest();

            return DataTables::eloquent($ranks)
                ->addColumn('user_id', function ($gift) {
                    return str_pad($gift->user_id, '4', '0', STR_PAD_LEFT) .
                        " <br> <code class='text-uppercase'>{$gift->user->username}</code>";
                })
                ->addColumn('image', static function ($gift) {
                    if ($gift->image_name !== null) {
                        return "<a href='" . storage('ranks/gifts/' . $gift->rank->rank . '/proof/' . $gift->image_name) . "' target='_blank' class='btn btn-info shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-eye'></i>
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
                ->addColumn('actions', function ($gift) {
                    if (Gate::allows('issue', $gift)) {
                        return "<a href='" . route('admin.ranks.gifts.issue', $gift) . "' class='btn btn-green btn-outline-success btn-xs me-1 my-1 shadow sharp'>
                                <i class='fas fa-gift'></i>
                            </a>";
                    }
                    if (Gate::allows('makeQualify', $gift)) {
                        return "<a href='javascript:void(0)' data-gift='" . $gift->id . "' class='btn btn-instagram make-qualify-gift btn-xs me-1 my-1 shadow sharp'>
                                <i class='fas fa-sync-alt'></i>
                            </a>";
                    }
                    return '-';
                })
                ->rawColumns(['user_id', 'image', 'gift_requirement', 'actions'])
                ->make();
        }


        return view('backend.admin.ranks.gifts.index');
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function makeQualify(Request $request, RankGift $gift): JsonResponse
    {

        $this->authorize('makeQualify', $gift);

        $gift = DB::transaction(static function () use ($gift) {
            return $gift->update([
                'status' => 'QUALIFIED'
            ]);
        });

        $json['status'] = true;
        $json['message'] = "Gift has been qualified";
        $json['icon'] = 'success'; // warning | info | question | success | error
        return response()->json($json, Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function issueGift(Request $request, RankGift $gift)
    {

        $this->authorize('issue', $gift);
        $gift->load(['rank', 'user']);

        if ($request->wantsJson()) {
            $validated = Validator::make($request->all(), [
                'issued-gift' => 'required|image'
            ])->validate();
            $gift = DB::transaction(static function () use ($validated, $gift) {

                $file = $validated['issued-gift'];
                $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                $file->storeAs('ranks/gifts/' . $gift->rank->rank . '/proof', $proof_documentation);

                return $gift->update([
                    'image_name' => $proof_documentation,
                    'status' => 'ISSUED'
                ]);
            });

            $json['status'] = true;
            $json['message'] = "Gift Issued";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.ranks.gifts');
            return response()->json($json, Response::HTTP_OK);
        }

        $shippingInfo = json_decode($gift->shipping_details ?? '{"name":"","address":"","mobile_number":"","shirt_size":""}', false, 512, JSON_THROW_ON_ERROR);

        return view('backend.admin.ranks.gifts.issue', compact('gift', 'shippingInfo'));
    }
}
