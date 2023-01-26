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
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::username()),
            static function ($user, $token) {
                $user->notify(new ResetPasswordNotification($token));
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
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
