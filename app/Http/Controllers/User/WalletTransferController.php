<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WalletTransfer;
use App\Services\TwoFactorAuthenticateService;
use Auth;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class WalletTransferController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * @throws \Throwable
     */
    public function transfer(Request $request, TwoFactorAuthenticateService $authenticateService)
    {
        $user = Auth::user();
        $wallet = Auth::user()->wallet;
        $max_withdraw_limit = $wallet->withdraw_limit;

        if ($request->wantsJson() && $request->isMethod('POST')) {

            $validated = Validator::make($request->all(), [
                'to_wallet' => 'required|in:topup',
                'amount' => ['required', 'numeric', 'max:' . $max_withdraw_limit],
                'password' => 'required',
                'code' => 'nullable',
                'remark' => 'nullable',
            ])->validate();

            if (!$user?->profile->is_kyc_verified) {
                $json['status'] = false;
                $json['message'] = 'Please submit your KYC for account verification. If you already submitted Contact us for verification.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
            if (!$authenticateService->checkPassword($user, $validated['password'] ?? null)) {
                $json['status'] = false;
                $json['message'] = 'Password is incorrect';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if ($authenticateService->isTwoFactorEnabled($user)) {

                if ($validated['code'] === null) {
                    $json['status'] = false;
                    $json['message'] = 'The two factor authentication code is required.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }

                if (!$authenticateService->checkTwoFactor($user, $validated['code'])) {
                    $json['status'] = false;
                    $json['message'] = 'The provided two factor authentication code was invalid.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }
            }

            if ($wallet->balance < $validated['amount']) {
                $json['status'] = false;
                $json['message'] = "Not enough funds in wallet to proceed!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if ($wallet->withdraw_limit < $validated['amount']) {
                $json['status'] = false;
                $json['message'] = "Withdraw Limit exceeded!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            DB::transaction(static function () use ($user, $validated, $wallet) {
                $withdraw = WalletTransfer::create([
                    'user_id' => $user->id,
                    'from' => 'main',
                    'to' => 'topup',/*$validated['to_wallet']*/
                    'amount' => $validated['amount'],
                    'fee' => 0,
                    'remark' => $validated['remark'] ?? null
                ]);

                if (strtolower($withdraw->from) === 'main') {
                    $wallet->decrement('balance', $validated['amount']);
                    $wallet->decrement('withdraw_limit', $validated['amount']);
                }
                if (strtolower($withdraw->to) === 'topup') {
                    $wallet->increment('topup_balance', $validated['amount']);
                }
                /* if ($withdraw->from === 'topup') {
                     $wallet->decrement('topup_balance', $validated['amount']);
                 }
                 if ($withdraw->to === 'main') {
                     $wallet->increment('balance', $validated['amount']);
                 }*/

                if ($wallet->withdraw_limit <= 0) {
                    $user->activePackages()->update(['status' => 'EXPIRED']);
                }

                return $withdraw;
            });

            $json['status'] = true;
            $json['message'] = "Transaction is successful!";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('user.wallet.index',); // warning | info | question | success | error
            return response()->json($json, Response::HTTP_OK);
        }

        $transfer_histories = WalletTransfer::where('user_id', Auth::user()->id)
            ->latest()
            ->paginate(25);
        return view('backend.user.wallet.transfer-between-wallets', compact('transfer_histories', 'max_withdraw_limit', 'wallet'));
    }

}
