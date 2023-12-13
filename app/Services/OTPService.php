<?php

namespace App\Services;

use App\Mail\SendOTPMail;
use App\Models\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class OTPService
{
    /**
     * @throws Exception
     */
    public function sendOTP($validated, User $user, TwoFactorAuthenticateService $authenticateService): \Illuminate\Http\JsonResponse
    {
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
        return $this->sendOTPCode($user, $validated);
    }

    /**
     * @throws Exception
     */
    public function sendOTPCode(User $user, array $validated = []): \Illuminate\Http\JsonResponse
    {
        $otp = random_int(100000, 999999);
        // $otp = 123456;
        $hashed_code = hash("sha512", $otp);
        $hashed_username = hash("sha512", $user?->username);
        session()->put($hashed_username, $hashed_code);

        \Mail::to($user?->email)->send(new SendOTPMail($user, $otp, $validated));

        $phone_validator = Validator::make(['phone' => $user?->phone], [
            'phone' => 'required|regex:/^\+94/i',
        ]);

        $json['sms_error'] = null;
//        if ($phone_validator->passes()) {
//            $validated = $phone_validator->validated();
//            $username = $user->username;
//            $message = "{$otp} is your one-time password (OTP) to complete your Transaction from username: {$username}. Thank you. coin1m.com";
//            try {
//                if (!sendSMS($validated['phone'], $message)) {
//                    $json['sms_error'] = "SMS send failed!.";
//                }
//            } catch (Exception $e) {
//                $json['sms_error'] = "Something went wrong!";
//            }
//        }

        $json['status'] = true;
        $json['sent_verify_code'] = true;
        $json['message'] = "OTP sent successfully. Please check your inbox!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        return response()->json($json);
    }
}
