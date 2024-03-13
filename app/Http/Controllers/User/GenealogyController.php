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
use NumberFormatter;
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
    public function userLevels(Request $request, int|string $depth = 'all')
    {
        $level = $depth;
        if ($depth !== 'all' && $depth > 4) { 
            $level = 4;
        }
        $authUser = Auth::user();
        //dd($authUser->id, $descendants);
        if ($request->wantsJson()) {
            return $this->userLevelDatatable($authUser, $level, $request);
        }
        return view('backend.user.teams.users-list', compact('depth'));
    }

    /**
     * @throws Exception
     */
    public function teamList(Request $request, User|null $user = null)
    {
        if ($user?->id === null) {
            $user = auth()->user();
        }

        if ($request->wantsJson()) {
            $users = User::with('sponsor', 'parent')
                ->withCount('directSales')
                ->where('super_parent_id', $user?->id)
                //                ->find(Auth::user()->id)
                //                ->descendants()
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
                //                ->addColumn('parent', function ($user) {
                //                    return "{$user->parent_id} - <code>{$user?->parent?->username} </code><br>Position: {$user->position}";
                //                })
                ->addColumn('joined', fn($user) => $user->created_at->format('Y-m-d h:i A'))
                ->addColumn('suspended', function ($user) {
                    if ($user->is_suspended) {
                        return Carbon::parse($user->suspended_at)->format('Y-m-d h:i A');
                    }
                    return '-';
                })
                ->addColumn('actions', function ($user) use ($request,) {
                    if ($user->direct_sales_count > 0 && $request->get('depth') < 4) {
                        return '<a class="btn btn-secondary btn-success btn-xxs p-1 " href="' . route("user.team.users-list", [$user, "depth" => $request->get("depth") + 1]) . '">
                        <i class="fa fa-users"></i>
                    </a>';
                    }
                    return '-';
                })
                ->rawColumns(['profile_photo', 'user_details', 'contact_details', 'sponsor', 'actions'])
                ->make();
        }

        return view('backend.user.teams.users-list', ['depth' => $request->get('depth')]);
    }

    public function IncomeLevels(Request $request)
    {
        $user = Auth::user();

        $income_levels = DB::select("WITH RECURSIVE member_levels AS (
                                SELECT id, parent_id, 1 AS level
                                FROM users
                                WHERE id = :user_id
                                UNION ALL
                                SELECT u.id, u.parent_id, ml.level + 1
                                FROM users u
                                INNER JOIN member_levels ml ON u.parent_id = ml.id
                            )
                            SELECT
                                ml.level,
                                POWER(5, ml.level - 1) AS total_possible_members,
                                COUNT(*) AS member_count,
                                SUM(CASE WHEN EXISTS (SELECT 1 FROM purchased_package pp WHERE pp.user_id = ml.id AND pp.status = 'active' AND pp.expired_at >= :expired_at) THEN 1 ELSE 0 END) AS active_sales_count
                            FROM member_levels ml
                            GROUP BY ml.level;", ['user_id' => $user->id, 'expired_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);

        return view('backend.user.teams.income-level', compact('income_levels', 'numberFormatter'));
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

    /**
     * @throws Exception
     */
    public function userLevelDatatable(User $user, int|string $level, Request $request): \Illuminate\Http\JsonResponse
    {
        $start = request()->input('start', 0);
        $length = request()->input('length', 10);

        $query = $user?->descendants()
            ->with('sponsor', 'parent', 'profile')
            ->withCount('directSales')
            ->withSum(['withdraws' => fn($q) => $q->where('status', 'SUCCESS')->where('type', 'MANUAL')], 'amount')
            ->withSum(['withdraws' => fn($q) => $q->where('status', 'SUCCESS')->where('type', 'MANUAL')], 'transaction_fee')
            ->withSum(['earnings' => fn($q) => $q->whereIn('type', ['PACKAGE', 'TRADE_DIRECT', 'TRADE_INDIRECT', 'DIRECT', 'INDIRECT', 'TEAM_BONUS'])], 'amount')
            ->withSum(['activePackages', 'purchasedPackages'], 'invested_amount')
            ->when(($level === 'all' || $level < 1 || $level > 4), function (Builder $q) {
                $q->where('depth', "<=", 4);
            })->when($level !== 'all' && ($level >= 1 && $level <= 4), function (Builder $q) use ($level) {
                $q->where('depth', $level);
            })
            ->when($request->get('status') === 'suspend', function (Builder $q) {
                $q->whereNotNull('suspended_at');
            })
            ->when($request->get('status') === 'active', function (Builder $q) {
                $q->whereNull('suspended_at');
            })
            ->when($request->get('investment-status') === 'active', function (Builder $q) {
                $q->whereHas('purchasedPackages');
            })->when($request->get('investment-status') === 'inactive', function (Builder $q) {
                $q->whereDoesntHave('purchasedPackages');
            });

        $totalRecords = $query->count();

        $descendants = $query->skip($start)
            ->take($length)
            ->get();

        return DataTables::of($descendants)->skipPaging()
            ->with([
                'recordsTotal' => $totalRecords,      // Total records without filtering
                'recordsFiltered' => $totalRecords,  // Total records after filtering (if any)
            ])
            ->addColumn('profile_photo', function ($lvlUser) {
                return "<img class='rounded-circle' width='35' src='" . $lvlUser->profile_photo_url . "' alt='' />";
            })
            ->addColumn('user_details', function ($lvlUser) {

                $level = \App\Enums\ReferralLevelEnum::level()[$lvlUser->depth];
                $status = '';
                if ($lvlUser->is_suspended) {
                    $status = "ACCOUNT SUSPENDED";
                }
                $status .= "Joined: " . $lvlUser->created_at->format('Y-m-d h:i A');
                return "<i class='fa fa-user-circle'></i> <code>{$lvlUser->username}</code> <br>
                            <i class='fa fa-level-down'></i> {$level} <br>
                           {$status} ";
            })
            ->addColumn('contact_details', function ($lvlUser) {
                return "Referal User: <code>{$lvlUser->sponsor?->username}</code> <br>
                            <i class='fa fa-envelope'></i> $lvlUser->email<br>";
            })
            ->addColumn('sponsor', function ($lvlUser) {
                return "{$lvlUser->super_parent_id} - <code>{$lvlUser?->sponsor?->username} </code>";
            })
            //                ->addColumn('parent', function ($lvlUser) {
            //                    return "{$lvlUser->parent_id} - <code>{$lvlUser?->parent?->username} </code><br>Position: {$lvlUser->position}";
            //                })
            ->addColumn('joined', function ($lvlUser) {
                if ($lvlUser->is_suspended) {
                    return "ACCOUNT SUSPENDED";
                }
                return "Joined: " . $lvlUser->created_at->format('Y-m-d h:i A');
            })
            ->addColumn('suspended', function ($lvlUser) {
                if ($lvlUser->is_suspended) {
                    return Carbon::parse($lvlUser->suspended_at)->format('Y-m-d h:i A');
                }
                return '-';
            })
            ->addColumn('profit', function ($lvlUser) {
                $earnings_sum_amount = $lvlUser->earnings_sum_amount;
                $withdraws_sum_amount = $lvlUser->withdraws_sum_amount;
                $withdraws_sum_transaction_fee = $lvlUser->withdraws_sum_transaction_fee;
                $total_withdrawal = $withdraws_sum_amount + $withdraws_sum_transaction_fee;
                return
                    "Total Earned: <code>{$earnings_sum_amount}</code></br>" .
                    "Total Withdraw: <code>{$total_withdrawal}</code>";
            })
            ->addColumn('total_earned', function ($lvlUser) {
//                $earnings_sum_amount = $lvlUser->earnings_sum_amount;
                $withdraws_sum_amount = $lvlUser->withdraws_sum_amount;
                $withdraws_sum_transaction_fee = $lvlUser->withdraws_sum_transaction_fee;
                return number_format($withdraws_sum_amount + $withdraws_sum_transaction_fee, 2);
            })
            ->addColumn('total_withdraw', function ($lvlUser) {
                //                $withdraws_sum_amount = $lvlUser->withdraws_sum_amount;
//                $withdraws_sum_transaction_fee = $lvlUser->withdraws_sum_transaction_fee;
//                $total_withdrawal = $withdraws_sum_amount + $withdraws_sum_transaction_fee;
                return number_format($lvlUser->earnings_sum_amount ?? 0, 2);
            })
            ->addColumn('direct_sales_count', function ($lvlUser) {
                return $lvlUser->direct_sales_count;
            })
            ->addColumn('account_investments', function ($lvlUser) {
                $active_packages_sum_invested_amount = $lvlUser->active_packages_sum_invested_amount ?? 0;
                $purchased_packages_sum_invested_amount = $lvlUser->purchased_packages_sum_invested_amount ?? 0;
                $account_status = '<div class="badge py-0 badge-sm badge-outline-warning">INACTIVE</div>';
                if ($purchased_packages_sum_invested_amount > 0) {
                    $account_status = '<div class="badge py-0 badge-sm badge-dark">IDLE</div>';
                    if ($active_packages_sum_invested_amount > 0) {
                        $account_status = '<div class="badge py-0 badge-sm badge-success">ACTIVE</div>';
                    }
                }
                return "<div class='my-1'>
                                Account Status: {$account_status} </br>" .
                    "Active Packages: <code>{$active_packages_sum_invested_amount}</code> </br>" .
                    "Total Investment: <code>{$purchased_packages_sum_invested_amount}</code>
                        </div>";
            })
            ->rawColumns(['profile_photo', 'user_details', 'contact_details', 'profit', 'sponsor', 'account_investments'])
            ->make();
    }

}
