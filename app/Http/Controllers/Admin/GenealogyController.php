<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GenealogyController extends Controller
{
    public function index(Request $request, User|null $user)
    {
        if (optional($user)->id === null) {
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
        return view('backend.admin.genealogy.index', compact('user', 'descendants'));
    }
}
