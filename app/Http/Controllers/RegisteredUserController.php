<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        $sponsor = new User;
        if ($request->get('ref', false)) {
            abort_if(!$request->hasValidSignature(), Response::HTTP_UNAUTHORIZED, 'Invalid referral link!');
            $parent = $request->get('ref', null);
            $sponsor = User::whereUsername($parent)->firstOrFail();
        }

        return view('auth.register', compact('sponsor'));
    }

    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        abort(Response::HTTP_SERVICE_UNAVAILABLE);

        event(new Registered($user = $creator->create($request->all())));
        Auth::login($user);
        return app(RegisterResponse::class);
    }
}
