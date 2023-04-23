<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Services\OTPService;
use App\Services\TwoFactorAuthenticateService;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log as Logger;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use URL;
use Validator;

class PayoutController extends Controller
{

    /**
     * @throws Exception
     */
    public function twoftVerifyP2P(Request $request, OTPService $otpService, TwoFactorAuthenticateService $authenticateService): \Illuminate\Http\JsonResponse
    {

        $validated = Validator::make($request->all(), [
            'receiver' => 'required|exists:users,id',
            'minimum_payout_limit' => 'required',
            'amount' => ['required', 'numeric', 'min:' . $request->minimum_payout_limit],
            'password' => 'required',
            'code' => 'nullable',
            'wallet_type' => 'required|in:main,topup',
            'remark' => 'nullable',
        ])->validate();

        try {
            $log_data = [
                'RESPONSIBLE USER' => auth()->user()?->only(['id', 'username', 'email', 'phone']),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'DATA' => $request->except(['password']),
                'HEADERS' => $request->headers->all(),
                'ACTION' => 'P2P_OTP_REQUEST',
            ];
            $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            Logger::channel('daily')->notice('P2P OTP REQUEST | DATA: ' . $log_data);
        } catch (Exception $e) {
        }

        return $otpService->sendOTP($validated, Auth::user(), $authenticateService);
    }

    /**
     * @throws Throwable
     */
    public function p2pTransfer(Request $request, TwoFactorAuthenticateService $authenticateService)
    {

        $strategies = Strategy::whereIn('name', ['p2p_transfer_fee', 'minimum_payout_limit'])->get();
        $sender = Auth::user();
        $sender_wallet = $sender?->wallet;

        $max_withdraw_limit = $sender_wallet->withdraw_limit;
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));

        $validated = Validator::make($request->all(), [
            'receiver' => 'required|exists:users,id',
            'amount' => ['required', 'numeric', 'min:' . $minimum_payout_limit->value],
            'password' => 'required',
            'otp' => 'required|digits:6',
            'code' => 'nullable',
            'wallet_type' => 'required|in:main,topup',
            'remark' => 'nullable',
        ])->validate();

        try {
            $log_data = [
                'RESPONSIBLE USER' => auth()->user()?->only(['id', 'username', 'email', 'phone']),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'DATA' => $request->except(['password']),
                'HEADERS' => $request->headers->all(),
                'ACTION' => 'P2P_REQUEST_POST',
            ];
            $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            Logger::channel('daily')->notice('P2P REQUEST | DATA: ' . $log_data);
        } catch (Exception $e) {
        }

        $hashed_username = hash("sha512", auth()->user()?->username);
        $hashed_code = hash("sha512", $validated['otp']);
        if (!session()->has($hashed_username) || session()->get($hashed_username) !== $hashed_code) {
            $json['status'] = false;
            $json['message'] = 'Entered OTP code is invalid!';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        $receiver = User::find($validated['receiver']);

//        $p2p_restricted_users = Strategy::where('name', 'p2p_restricted_users')->firstOr(fn() => new Strategy(['value' => '[3]']));
//        $p2p_restricted_users = json_decode($p2p_restricted_users->value, true, 512, JSON_THROW_ON_ERROR);
//        if (in_array($receiver->id, $p2p_restricted_users, true)) {
//            $json['status'] = false;
//            $json['message'] = 'Selected Receiver cannot accept P2P funds! Please contact web administrator for further information.!';
//            $json['icon'] = 'error'; // warning | info | question | success | error
//            return response()->json($json, Response::HTTP_UNAUTHORIZED);
//        }

        if (!$sender?->profile->is_kyc_verified) {
            $json['status'] = false;
            $json['message'] = 'Please submit your KYC for account verification. If you already submitted Contact us for verification.';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if (!$authenticateService->checkPassword($sender, $validated['password'] ?? null)) {
            $json['status'] = false;
            $json['message'] = 'Password is incorrect';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if ($authenticateService->isTwoFactorEnabled($sender)) {

            if ($validated['code'] === null) {
                $json['status'] = false;
                $json['message'] = 'The two factor authentication code is required.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if (!$authenticateService->checkTwoFactor($sender, $validated['code'])) {
                $json['status'] = false;
                $json['message'] = 'The provided two factor authentication code was invalid.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
        }

        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, new Strategy(['value' => 2.5]));
        $total_amount = $validated['amount'] + $p2p_transfer_fee->value;

        if ($validated['wallet_type'] === 'main') {
            if ($sender_wallet->balance < $total_amount) {
                $json['status'] = false;
                $json['message'] = "Not enough funds in wallet to proceed!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
            if ($sender_wallet->withdraw_limit < $total_amount) {
                $json['status'] = false;
                $json['message'] = "Withdraw Limit exceeded!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
        }

        if (($validated['wallet_type'] === 'topup') && $sender_wallet->topup_balance < $total_amount) {
            $json['status'] = false;
            $json['message'] = "Not enough funds in wallet to proceed!";
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        $withdraw = DB::transaction(static function () use ($sender, $receiver, $validated, $p2p_transfer_fee, $sender_wallet, $total_amount) {
            $withdraw = Withdraw::create([
                'user_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $validated['amount'],
                'transaction_fee' => $p2p_transfer_fee->value,
                'status' => 'SUCCESS',
                'type' => 'P2P',
                'wallet_type' => strtoupper($validated['wallet_type']),
                'remark' => $validated['remark'] ?? null
            ]);

            if ($withdraw->wallet_type === 'MAIN') {
                $sender_wallet->decrement('balance', $total_amount);
                $sender_wallet->decrement('withdraw_limit', $total_amount);

                if ($sender_wallet->withdraw_limit <= 0) {
                    $sender->activePackages()->update(['status' => 'EXPIRED']);
                }
            }

            if ($withdraw->wallet_type === 'TOPUP') {
                $sender_wallet->decrement('topup_balance', $total_amount);
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
                ['topup_balance' => 0, 'withdraw_limit' => 0]
            );

            $receiver_wallet->increment('topup_balance', $withdraw->amount);

            return $withdraw;
        });

        session()->forget($hashed_username);
        $json['status'] = true;
        $json['message'] = "P2P Transaction is successful!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = URL::signedRoute('user.wallet.transfer.invoice', $withdraw); // warning | info | question | success | error
        return response()->json($json, Response::HTTP_OK);

    }

    public function twoftVerifyWithdraw(Request $request, OTPService $otpService, TwoFactorAuthenticateService $authenticateService)
    {
        $validated = Validator::make($request->all(), [
            'minimum_payout_limit' => 'required',
            'amount' => ['required', 'numeric', 'min:' . $request->minimum_payout_limit],
            'password' => 'required',
            'code' => 'nullable',
            'wallet_type' => 'required|in:main,topup',
            'remark' => 'nullable',
        ])->validate();

        try {
            $log_data = [
                'RESPONSIBLE USER' => auth()->user()?->only(['id', 'username', 'email', 'phone']),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'DATA' => $request->except(['password']),
                'HEADERS' => $request->headers->all(),
                'ACTION' => 'MANUAL_WITHDRAWAL_OTP_REQUEST',
            ];
            $log_data = json_encode($log_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
            Logger::channel('daily')->notice('MANUAL WITHDRAWAL OTP REQUEST | DATA: ' . $log_data);
        } catch (Exception $e) {
        }

        return $otpService->sendOTP($validated, Auth::user(), $authenticateService);
    }

    /**
     * @throws Throwable
     */
    public function withdraw(Request $request, TwoFactorAuthenticateService $authenticateService)
    {
        $user = Auth::user();
        $user_wallet = $user?->wallet;

        $strategies = Strategy::whereIn('name', ['payout_transfer_fee', 'minimum_payout_limit'])->get();
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $user_wallet->withdraw_limit;

        $validated = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:' . $minimum_payout_limit->value],
            'wallet_type' => ['required', 'in:main,topup'],
            'password' => 'required',
            'otp' => 'required|digits:6',
            'code' => 'nullable',
            'remark' => 'nullable',
        ])->validate();

        $hashed_username = hash("sha512", auth()->user()?->username);
        $hashed_code = hash("sha512", $validated['otp']);
        if (!session()->has($hashed_username) || session()->get($hashed_username) !== $hashed_code) {
            $json['status'] = false;
            $json['message'] = 'Entered OTP code is invalid!';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

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
        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, new Strategy(['value' => 5]));

        $total_amount = $validated['amount'] + $payout_transfer_fee->value;

        if ($validated['wallet_type'] === 'main') {
            if ($user_wallet->balance < $total_amount) {
                $json['status'] = false;
                $json['message'] = "Not enough funds in wallet to proceed!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if ($user_wallet->withdraw_limit < $total_amount) {
                $json['status'] = false;
                $json['message'] = "Withdraw Limit exceeded!";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
        }

        if (($validated['wallet_type'] === 'topup') && $user_wallet->topup_balance < $total_amount) {
            $json['status'] = false;
            $json['message'] = "Not enough funds in wallet to proceed!";
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }
        $withdraw = DB::transaction(static function () use ($user, $validated, $payout_transfer_fee, $user_wallet, $total_amount) {

            $payout_details = [
                'email' => $user->profile->binance_email,
                'id' => $user->profile->binance_id,
                'address' => $user->profile->wallet_address,
                'phone' => $user->profile->binance_phone,
            ];

            $withdraw = Withdraw::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'transaction_fee' => $payout_transfer_fee->value,
                'status' => 'PENDING',
                'type' => 'MANUAL',
                'wallet_type' => strtoupper($validated['wallet_type']),
                'remark' => $validated['remark'] ?? null,
                'payout_details' => json_encode($payout_details, JSON_THROW_ON_ERROR)
            ]);

            if ($withdraw->wallet_type === 'MAIN') {
                $user_wallet->decrement('balance', $total_amount);
                $user_wallet->decrement('withdraw_limit', $total_amount);

                if ($user_wallet->withdraw_limit <= 0) {
                    $withdraw->update([
                        'expired_packages' => implode(',', $user->activePackages()->pluck('id')->toArray())
                    ]);
                    $user->activePackages()->update(['status' => 'EXPIRED']);
                }
            }

            if ($withdraw->wallet_type === 'TOPUP') {
                $user_wallet->decrement('topup_balance', $total_amount);
            }
            return $withdraw;
        });

        $json['status'] = true;
        $json['message'] = "Withdrawal request send! You will receive request amount within 3 business days";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = URL::signedRoute('user.wallet.transfer.invoice', $withdraw); // warning | info | question | success | error
        return response()->json($json, Response::HTTP_OK);
    }
}
