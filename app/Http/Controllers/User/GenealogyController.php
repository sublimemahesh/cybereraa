<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SaleLevelCommissionJob;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class GenealogyController extends Controller
{
    public function index(Request $request, User|null $user)
    {

        if ($user?->id === null) {
            $user = Auth::user();
        }
        $user?->load('currentRank', 'descendants');
        $user?->loadCount('activePackages');
        $descendants = $user?->children()
            ->with('currentRank', 'descendants')
            ->withCount('activePackages')
            ->orderBy('position')
            ->get()
            ->keyBy('position');

        if ($request->expectsJson() && $request->isMethod('POST')) {
            $json['status'] = true;
            $json['username'] = $user?->username;
            $json['message'] = 'Success';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['genealogy'] = view('backend.user.genealogy.includes.genealogy', compact('user', 'descendants'))->render();

            return response()->json($json);
        }
        return view('backend.user.genealogy.index', compact('user', 'descendants'));
    }

    /**
     * @throws Exception
     */
    public function teamList(Request $request)
    {

        if ($request->wantsJson()) {
            $users = User::with('sponsor', 'parent')
                //                ->find(Auth::user()->id)
                //                ->descendants()
                ->when($request->get('status') === 'suspend', function (Builder $q) {
                    $q->whereNotNull('suspended_at');
                })
                ->whereIn('id', Auth::user()->descendants()->pluck('id')->toArray())
                ->when($request->get('status') === 'active', function (Builder $q) {
                    $q->whereNull('suspended_at');
                })
                ->when($request->get('date-range'), function (Builder $q) {
                    $period = explode(' to ', request()->input('date-range'));
                    try {
                        $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                        $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                        $q->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                    } finally {
                        return;
                    }
                });
            //dd($users);
            return DataTables::eloquent($users)
                ->addColumn('profile_photo', function ($user) {
                    return "<img class='rounded-circle' width='35' src='" . $user->profile_photo_url . "' alt='' />";
                })
                ->addColumn('user_details', function ($user) {
                    return "<i class='fa fa-user-circle'></i> $user->id <br>
                            <i class='fa fa-user'></i> $user->username<br>
                            <i class='fa fa-user'></i> $user->name<br>";
                })
                ->addColumn('contact_details', function ($user) {
                    return "<i class='fa fa-phone'></i> $user->phone <br>
                            <i class='fa fa-envelope'></i> $user->email<br>";
                })
                ->addColumn('sponsor', function ($user) {
                    return "{$user->super_parent_id} - <code>{$user?->sponsor?->username} </code>";
                })
                ->addColumn('parent', function ($user) {
                    return "{$user->parent_id} - <code>{$user?->parent?->username} </code><br>Position: {$user->position}";
                })
                ->addColumn('joined', fn($user) => $user->created_at->format('Y-m-d h:i A'))
                ->addColumn('suspended', function ($user) {
                    if ($user->is_suspended) {
                        return Carbon::parse($user->suspended_at)->format('Y-m-d h:i A');
                    }
                    return '-';
                })
                ->rawColumns(['profile_photo', 'user_details', 'contact_details', 'sponsor', 'parent'])
                ->make();
        }

        return view('backend.user.teams.users-list');
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
            'directSales as pending_direct_sales_count' => fn($query) => $query->whereNull('parent_id')->whereHas('activePackages')
        ]);

        $pendingUsers = $loggedUser->directSales()
            ->whereNull('parent_id')
            ->whereNull('position')
            ->whereHas('activePackages')
            ->oldest()->get();

        $descendant_count = $loggedUser->descendants()->count();
        $parent->loadCount('children');

        $available_spaces = 5 - $parent->children_count;
        $available_percentage = ($available_spaces / 5) * 100;


        return view('backend.user.genealogy.manage-position', compact('parent', 'descendant_count', 'pendingUsers', 'position', 'loggedUser', 'available_spaces', 'available_percentage'));
    }

    public function assignPosition(Request $request, User $parent, $position): \Illuminate\Http\JsonResponse
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
                User::upgradeAncestorsRank($parent, 1, $position);

                $pending_commission_purchased_packages = $assignedUser->activePackages()->whereNull('commission_issued_at')->get();
                foreach ($pending_commission_purchased_packages as $package) {
                    SaleLevelCommissionJob::dispatch($assignedUser, $package)->afterCommit()->onConnection('sync');
                }

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

    public function registerForm(Request $request)
    {
        $user = Auth::user();
        if ($user->id !== config('fortify.super_parent_id')) {
            abort_if($user->parent_id === null || $user->position === null, 403, 'Your genealogy position is still not available. Please contact your up link user or contact us to solve the problem');
        }
        return view('backend.user.genealogy.create-new-user');
    }

}
