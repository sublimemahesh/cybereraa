<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade
        $intended = Redirect::intended(config('fortify.' . Auth::user()->getRoleNames()->first()));
        return $request->wantsJson()
            ? response()->json(['two_factor' => false, 'intended' => $intended->getTargetUrl()])
            : $intended;
    }
}
