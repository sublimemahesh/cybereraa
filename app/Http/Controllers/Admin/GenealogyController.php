<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Artisan;
use Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


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

    /**
     * @throws Exception
     */
    public function teamList(Request $request, User|null $user = null)
    {
        if ($request->wantsJson()) {
            $users = User::withCount('directSales')
                ->with('sponsor', 'parent')
                ->when($user?->id !== null, function (Builder $q) use ($user) {
                    $q->where('super_parent_id', $user?->id);
                })
                ->when($request->get('status') === 'suspend', function (Builder $q) {
                    $q->whereNotNull('suspended_at');
                })
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
                ->addColumn('profile_photo', function ($userD) {
                    return "<img class='rounded-circle' width='35' src='" . $userD->profile_photo_url . "' alt='' />";
                })
                ->addColumn('user_details', function ($userD) {
                    return "<i class='fa fa-user-circle'></i> $userD->id <br>
                            <i class='fa fa-user'></i> $userD->username<br>
                            <i class='fa fa-user'></i> $userD->name<br>";
                })
                ->addColumn('contact_details', function ($userD) {
                    return "<i class='fa fa-phone'></i> $userD->phone <br>
                            <i class='fa fa-envelope'></i> $userD->email<br>";
                })
                ->addColumn('sponsor', function ($userD) {
                    return "{$userD->super_parent_id} - <code>{$userD?->sponsor?->username} </code>";
                })
                //                ->addColumn('parent', function ($userD) {
                //                    return "{$userD->parent_id} - <code>{$userD?->parent?->username} </code><br>Position: {$userD->position}";
                //                })
                ->addColumn('joined', fn($userD) => $userD->created_at->format('Y-m-d h:i A'))
                ->addColumn('suspended', function ($userD) {
                    if ($userD->is_suspended) {
                        return Carbon::parse($userD->suspended_at)->format('Y-m-d h:i A');
                    }
                    return '-';
                })
                ->addColumn('actions', function (User $userD) {
                    if ($userD->direct_sales_count > 0) {
                        /*return '<a class="btn btn-secondary btn-success btn-xxs p-1 view-downline-user" data-username="' . $userD->username . '">
                        <i class="fa fa-users"></i>
                    </a>';*/
                        return '<a class="btn btn-secondary btn-success btn-xxs p-1 " href="' . route('admin.team.users-levels', ['user' => $userD, 'depth' => 1]) . '">
                        <i class="fa fa-users"></i>
                    </a>';
                    }
                    return '-';
                })
                ->rawColumns(['profile_photo', 'user_details', 'contact_details', 'sponsor', 'actions'])
                ->make();
        }

        return view('backend.admin.genealogy.users-list');
    }

    /**
     * @throws Exception
     */
    public function userLevels(Request $request, User $user, int|string $depth = 'all')
    {
        $level = $depth;
        if ($depth !== 'all' && $depth > 4) {
            $level = 4;
        }
        if ($request->wantsJson()) {
            return (new \App\Http\Controllers\User\GenealogyController())->userLevelDatatable($user, $level, $request);
        }
        return view('backend.admin.genealogy.users-levels-list', compact('depth', 'user'));
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
