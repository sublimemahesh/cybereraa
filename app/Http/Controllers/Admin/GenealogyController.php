<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class GenealogyController extends Controller
{
    public function index(Request $request, User|null $user)
    {
        abort_if(Gate::denies('users.genealogy'), Response::HTTP_FORBIDDEN);

        if ($user?->id === null) {
            $system_super_user = config('fortify.super_parent_id');
            $user = User::find($system_super_user);
        }
        $user->load('currentRank', 'descendants');
        $user->loadCount('activePackages');
        $descendants = $user->children()
            ->with('currentRank', 'descendants')
            ->withCount('activePackages')
            ->orderBy('position')
            ->get()
            ->keyBy('position');

        if ($request->wantsJson() && $request->isMethod('POST')) {
            $json['status'] = true;
            $json['username'] = $user->username;
            $json['message'] = 'Success';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['genealogy'] = view('backend.admin.genealogy.includes.genealogy', compact('user', 'descendants'))->render();

            return response()->json($json);
        }
        return view('backend.admin.genealogy.index', compact('user', 'descendants'));
    }

    public function placePendingUsersInGenealogy(): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('place_pending_members_in_genealogy'), Response::HTTP_FORBIDDEN);

        $res = Artisan::call('genealogy:assign');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }
}
