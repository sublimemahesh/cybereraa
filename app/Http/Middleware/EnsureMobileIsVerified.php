<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect;
use URL;

class EnsureMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$request->user() || (!$request->user()->is_mobile_verified)) {
            $sl_phone_match = $request->user()->phone === null || preg_match('/^\+94/i', $request->user()->phone);
            if ($sl_phone_match) {
                if ($request->expectsJson()) {
                    return abort(403, 'Your mobile number is not verified.');
                }
                return Redirect::guest(URL::route('mobile.verification.notice'));
            }
        }
        return $next($request);
    }
}
