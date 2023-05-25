<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RankGift;
use Auth;
use DataTables;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

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
                    if (\Gate::allows('addShippingInfo', $gift)) {
                        return
                            "<a href='" . route('user.ranks.gifts.shipping-info', $gift) . "' class='btn btn-info shadow btn-xs my-1 sharp me-1' >
                                <i class='fas fa-truck'></i>
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


    /**
     * @throws Throwable
     */
    public function shippingInfo(Request $request, RankGift $gift)
    {
        $this->authorize('addShippingInfo', $gift);
        $gift->load(['rank', 'user']);
        if ($request->wantsJson()) {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string',
                'address' => 'required|string',
                'mobile_number' => 'required|string',
                'shirt_size' => ['nullable', Rule::requiredIf($gift->rank->rank === 1)],
            ])->validate();

            $gift = DB::transaction(static function () use ($validated, $gift) {
                $shippingInfo = json_encode($validated, JSON_THROW_ON_ERROR);
                return $gift->update([
                    'shipping_details' => $shippingInfo,
                ]);
            });

            $json['status'] = true;
            $json['message'] = "Shipping info saved successfully";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('user.ranks.gifts');
            return response()->json($json, Response::HTTP_OK);
        }

        $shippingInfo = json_decode($gift->shipping_details ?? '{"name":"","address":"","mobile_number":"","shirt_size":""}', false, 512, JSON_THROW_ON_ERROR);

        return view('backend.user.ranks.gifts.shipping-info', compact('gift', 'shippingInfo'));
    }
}
