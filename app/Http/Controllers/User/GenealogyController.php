<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class GenealogyController extends Controller
{
    public function index(Request $request, User|null $user)
    {
        if (optional($user)->id === null) {
            $user = Auth::user();
        }
        $user->load('currentRank', 'descendants');
        $user->loadCount('activePackages');
        $descendants = $user->children()
            ->with('currentRank', 'descendants')
            ->withCount('activePackages')
            ->orderBy('position')
            ->get()
            ->keyBy('position');
        return view('backend.user.genealogy.index', compact('user', 'descendants'));
    }

    public function managePosition(Request $request, User $parent, $position)
    {
        $validator = Validator::make(compact('position'), [
            'position' => [
                'required',
                'lte:5',
                'gte:1',
                Rule::unique('users', 'position')
                    ->where('parent_id', $parent->id)
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.genealogy', $parent)
                ->withErrors($validator)
                ->withInput();
        }

        $loggedUser = Auth::user();
        $loggedUser->loadCount([
            'directSales',
            'directSales as pending_direct_sales_count' => fn($query) => $query->whereNull('parent_id')
        ]);

        $pendingUsers = $loggedUser->directSales()->whereNull('parent_id')->whereNull('position')->oldest()->get();
        $descendant_count = $loggedUser->descendants()->count();
        $parent->loadCount('children');

        $available_spaces = 5 - $parent->children_count;
        $available_percentage = ($available_spaces / 5) * 100;


        return view('backend.user.genealogy.manage-position', compact('parent', 'descendant_count', 'pendingUsers', 'position', 'loggedUser', 'available_spaces', 'available_percentage'));
    }

    public function assignPosition(Request $request, User $parent, $position)
    {
        $loggedUser = Auth::user();
        $parent->loadCount('children');
        $available_spaces = 5 - $parent->children_count;

        $validated = Validator::make([
            'position' => $position,
            'available_spaces' => $available_spaces,
            ...$request->all()
        ], [
            'available_spaces' => 'required|gte:1',
            'position' => [
                'required',
                'lte:5',
                'gte:1',
                Rule::unique('users', 'position')
                    ->where('parent_id', $parent->id)
            ],
            'pending_user' => [
                'required',
                Rule::exists('users', 'id')
                    ->where('super_parent_id', $loggedUser->id)
                    ->whereNull('parent_id')
                    ->whereNull('position')
            ]
        ])->validate();

        if ($parent->children()->where('position', $position)->exists()) {
            $json['status'] = false;
            $json['message'] = 'Position is no longer available!';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $assignedUser = User::find($validated['pending_user']);

        try {
            DB::transaction(static function () use ($assignedUser, $parent, $position) {
                $assignedUser->update(['parent_id' => $parent->id, 'position' => $position]);
                User::upgradeAncestorsRank($parent, 1);
            });
        } catch (\Throwable $e) {
            $json['status'] = false;
            $json['message'] = 'Something went wrong! Please try again';
            $json['icon'] = 'error';
            return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $json['status'] = true;
        $json['message'] = 'User (' . $assignedUser->username . ') Assigned to the position ' . $position . '!';
        $json['redirectUrl'] = route('user.genealogy', $parent); // warning | info | question | success | error
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);
    }

    public function registerForm(Request $request, User $parent, $position)
    {
        $validator = Validator::make([
            'position' => $position], [
            'position' => [
                'required',
                'lte:5',
                'gte:1',
                Rule::unique('users', 'position')
                    ->where('parent_id', $parent->id)
            ]
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.genealogy', $parent)
                ->withErrors($validator)
                ->withInput();
        }
        return view('backend.user.genealogy.create-new-user', compact('parent', 'position'));
    }

    public function register(Request $request)
    {
        // TODO: This is dummy function
        // TODO: Use this for cronJob if user docent assign newly comers until 3 days
        // Validate the request parameters
        $validatedData = $request->validate([
            'parent_id' => 'required | integer',
            'name' => 'required | string',
        ]);

        // Find the ancestor with the fewest children
        $ancestor = User::findAvailableSubLevel($validatedData['parent_id']);

        // Insert the new node into the genealogy table

        //return response()->json(['success', 'Node inserted successfully']);
    }
}
