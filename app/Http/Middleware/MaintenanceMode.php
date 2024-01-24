<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        abort(
            Response::HTTP_SERVICE_UNAVAILABLE,
            "We're currently performing scheduled maintenance on our website to enhance your experience.
                    During this time, the site will be temporarily unavailable. We apologize for any inconvenience this may cause and appreciate your patience.
                    Our team is working hard to bring the site back online as soon as possible. Thank you for your understanding."
        );
//        return $next($request);
    }
}
