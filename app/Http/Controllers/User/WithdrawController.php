<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Strategy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WithdrawController extends Controller
{

    public function p2pTransfer()
    {
        $strategies = Strategy::whereIn('name', ['p2p_transfer_fee', 'minimum_payout_limit'])->get();
        $wallet = Auth::user()->wallet;

        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, new Strategy(['value' => 2.5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.p2p-transfer', compact('p2p_transfer_fee', 'max_withdraw_limit', 'minimum_payout_limit', 'wallet'));
    }

    public function withdraw()
    {
        $strategies = Strategy::whereIn('name', ['payout_transfer_fee', 'minimum_payout_limit'])->get();
        $wallet = Auth::user()->wallet;

        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, new Strategy(['value' => 5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.binance-payouts', compact('payout_transfer_fee', 'max_withdraw_limit', 'minimum_payout_limit', 'wallet'));
    }

    public function findUser(User $user): \Illuminate\Http\JsonResponse
    {
        $json = [];
        $code = Response::HTTP_NOT_FOUND;
        if (Auth::user()->id !== $user->id) {
            $json['status'] = true;
            $json['message'] = 'Request successful';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['user'] = [
                'id' => $user->id,
                'text' => $user->name . " - " . $user->username
            ];
            $code = Response::HTTP_OK;
        }
        return response()->json($json, $code);
    }

    public function findUsers($search_text): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            ->where('id', '<>', Auth::user()->id)
            ->where('id', '>', 3)
            ->get();
        return Select2UserResource::collection($users);
    }
}
