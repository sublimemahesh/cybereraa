<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserHasAnyRole
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
        if (Auth::check() && User::where('id', Auth::user()->id)->doesntHave('roles')->exists()) {
            if ($request->expectsJson()) {
                return abort(403, 'Insufficient permissions to complete the request.');
            }
            return redirect(RouteServiceProvider::HOME)->with('warning', 'Insufficient permissions to complete the request.');
        }
        return $next($request);
    }
}
