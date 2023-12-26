<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

class PasswordResetLinkController extends Controller
{

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return Responsable
     */
    public function store(Request $request): Responsable
    {
        $request->validate([Fortify::username() => 'required|exists:users,username']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // Check if the last OTP request time is stored in the session
        $lastOTPRequestTime = session("password_reset_link_last_otp_requested_at");

        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            // Calculate the remaining time until they can request a new OTP
            $remainingTime = 5 - now()->diffInMinutes($lastOTPRequestTime);

            // Add an error with the remaining time
            session()->flash('error', "We have sent the password reset link to your email address. " .
                "If you do not receive the email, kindly wait for {$remainingTime} minutes. " .
                "Please refrain from resending password reset email until the specified time has passed.");
            $status = Password::RESET_THROTTLED;
            return app(FailedPasswordResetLinkRequestResponse::class, compact('status'));
        }

        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::username()),
            static function ($user, $token) {
                $user->notify(new ResetPasswordNotification($token));
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            session(["password_reset_link_last_otp_requested_at" => now()]);
            return app(SuccessfulPasswordResetLinkRequestResponse::class, compact('status'));
        }
        return app(FailedPasswordResetLinkRequestResponse::class, compact('status'));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
