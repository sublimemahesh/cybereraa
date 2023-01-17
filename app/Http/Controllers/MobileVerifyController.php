<?php

namespace App\Http\Controllers;

use Auth;
use Carbon;
use Exception;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MobileVerifyController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->is_mobile_verified || ($request->user()->phone !== null && !preg_match('/^\+94/i', $request->user()->phone))) {
            return redirect()->route(Auth::user()->getRoleNames()->first() . '.dashboard')->with('info', 'Already verified!');
        }
        return view('auth.verify-mobile');
    }

    /**
     * @throws Exception
     */
    public function sendVerifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\+94/i',
        ]);

        $code = $this->generateAccountVerificationCodeAndStore($request->get('phone'));
        sendSMS($request->get('phone'), "Use verification code {$code} for www.safesttrades.com account verification.");
        return response()->json(['sent_verify_code' => true]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function verifyPhone(Request $request): \Illuminate\Http\JsonResponse
    {
        $hashed_phone = hash("sha512", $request->get('phone'));
        $hashed_code = hash("sha512", $request->get('verify_code'));
        $redirect = redirect()->route(Auth::user()->getRoleNames()->first() . '.dashboard');
        if (session()->has($hashed_phone) && session()->get($hashed_phone) === $hashed_code) {
            session()->forget($hashed_phone);
            Auth::user()->update([
                'phone' => $request->get('phone'),
                'phone_verified_at' => Carbon::now(),
            ]);
            return response()->json(['verify_code' => true, 'redirect' => $redirect->getTargetUrl()]);
        }

        return response()->json(['verify_code' => false]);
    }

    /**
     * @throws Exception
     */
    private function generateAccountVerificationCodeAndStore($phone): int
    {
        $rand_no = random_int(100000, 999999);
        // $rand_no = 123456;
        $hashed_code = hash("sha512", $rand_no);
        $hashed_phone = hash("sha512", $phone);
        session()->put($hashed_phone, $hashed_code);
        return $rand_no;
    }
}
