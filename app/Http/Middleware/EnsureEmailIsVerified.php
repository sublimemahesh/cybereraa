<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $redirectToRoute
     * @return Response|RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user() || ($request->user() instanceof MustVerifyEmail && !$request->user()->hasVerifiedEmail())) {
            $sl_phone_match = preg_match('/^\+94/i', $request->user()->phone);
            if (!$sl_phone_match) {
                if ($request->expectsJson()) {
                    return abort(403, 'Your email address is not verified.');
                }
                return Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            }
        }

        return $next($request);
    }
}
