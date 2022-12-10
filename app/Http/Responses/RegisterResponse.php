<?php

namespace App\Http\Responses;

use Auth;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $redirect = redirect(config('fortify.' . Auth::user()->getRoleNames()->first()));
        return $request->wantsJson()
            ? response()->json(['sign_up' => true, 'redirect' => $redirect->getTargetUrl()])
            : $redirect;
    }
}
