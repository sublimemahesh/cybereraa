<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use URL;
use Validator;


class PayoutController extends Controller
{
    /**
     * @throws Throwable
     */
    public function p2pTransfer(Request $request)
    {
        $strategies = Strategy::whereIn('name', ['p2p_transfer_fee', 'minimum_payout_limit'])->get();
        $sender = Auth::user();
        $sender_wallet = $sender->wallet;

        $max_withdraw_limit = $sender_wallet->withdraw_limit;
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));

        $validated = Validator::make($request->all(), [
            'receiver' => 'required|exists:users,id',
            'amount' => ['required', 'numeric', 'min:' . $minimum_payout_limit->value, 'max:' . $max_withdraw_limit],
            'password' => 'required',
        ])->validate();

        if (!$sender->profile->is_kyc_verified) {
            $json['status'] = false;
            $json['message'] = 'Please submit your KYC for account verification. If you already submitted Contact us for verification.';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($validated['password'], $sender->password)) {
            $json['status'] = false;
            $json['message'] = 'Password is incorrect';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if ($sender_wallet->balance < $validated['amount']) {
            $json['status'] = false;
            $json['message'] = "Not enough funds in wallet to proceed!";
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        $receiver = User::find($validated['receiver']);

        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, new Strategy(['value' => 2.5]));

        $withdraw = DB::transaction(static function () use ($sender, $receiver, $validated, $p2p_transfer_fee, $sender_wallet) {
            $withdraw = Withdraw::create([
                'user_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $validated['amount'] - $p2p_transfer_fee->value,
                'transaction_fee' => $p2p_transfer_fee->value,
                'status' => 'SUCCESS',
                'type' => 'P2P'
            ]);

            $sender_wallet->decrement('balance', $validated['amount']);
            $sender_wallet->decrement('withdraw_limit', $validated['amount']);

            if ($sender_wallet->withdraw_limit <= 0) {
                $sender->activePackages()->update(['status' => 'EXPIRED']);
            }

            $withdraw->earnings()->save(Earning::forceCreate([
                'user_id' => $receiver->id,
                'currency' => 'USDT',
                'amount' => $withdraw->amount,
                'type' => 'P2P',
                'status' => 'RECEIVED'
            ]));

            $receiver_wallet = Wallet::firstOrCreate(
                ['user_id' => $receiver->id],
                ['balance' => 0, 'withdraw_limit' => 0]
            );

            $receiver_wallet->increment('balance', $withdraw->amount);

            return $withdraw;
        });

        $json['status'] = true;
        $json['message'] = "P2P Transaction is successful!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = URL::signedRoute('user.wallet.transfer.invoice', $withdraw); // warning | info | question | success | error
        return response()->json($json, Response::HTTP_OK);

    }
}
