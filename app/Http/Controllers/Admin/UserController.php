<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountReactivateMail;
use App\Mail\AccountSuspendMail;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\User;
use App\Models\Withdraw;
use App\Services\WalletTopupHistoryService;
use Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {

        abort_if(Gate::denies('users.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->routeIs('admin.users.pending.kycs')) {
            $request->merge(['kyc-status' => 'pending']);
        }

        if ($request->wantsJson()) {
            $users = User::with('sponsor', 'profile.kycs')
                ->withSum('purchasedPackages', 'invested_amount')
                ->withSum(['earnings' => fn($q) => $q->whereIn('type', ['PACKAGE', 'TRADE_DIRECT', 'TRADE_INDIRECT', 'DIRECT', 'INDIRECT'])], 'amount') // ,'TEAM_BONUS','SPECIAL_BONUS','RANK_BONUS','RANK_GIFT','P2P','STAKING'
                ->whereRelation('roles', 'name', 'user')
                ->when($request->get('status') === 'suspend', function (Builder $q) {
                    $q->whereNotNull('suspended_at');
                })
                ->when($request->filled('imported'), function (Builder $q) {
                    $q->where('is_onmax_user', request('imported'));
                })
                ->when($request->get('status') === 'active', function (Builder $q) {
                    $q->whereNull('suspended_at');
                })
                ->when($request->get('investment-status') === 'active', function (Builder $q) {
                    $q->whereHas('purchasedPackages');
                })
                ->when($request->get('investment-status') === 'inactive', function (Builder $q) {
                    $q->whereDoesntHave('purchasedPackages');
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
                })->when($request->get('kyc-status'), function (Builder $q) {
                    if (request()->input('kyc-status') !== 'required') {
                        $q->whereHas('profile.kycs.documents', function ($q) {
                            $q->where('status', request()->input('kyc-status'));
                        });
                    } else {
                        $q->where(function ($q) {
                            $q->whereDoesntHave('profile.kycs')
                                ->orwhereHas('profile.kycs.documents', function ($q) {
                                    $q->where('status', request()->input('kyc-status'));
                                });
                        });
                    }
                });
            return DataTables::eloquent($users)
                ->addColumn('profile_photo', function ($user) {
//                    return "<img class='rounded-circle py-1' width='35' src='" . $user->profile_photo_url . "' alt='' />";
                })
                ->addColumn('user_details', function ($user) {
                    return "<i class='fa fa-user-circle'></i> #{$user->id} |  <code>{$user->username}</code><br>
                            <i class='fa fa-user'></i> $user->name<br>
                            ";
                })
                ->addColumn('contact_details', function ($user) {
                    //  <i class='fa fa-phone'></i> $user->phone <br>
                    return "Sponsor: <code>{$user?->sponsor?->username} </code> <br>
                            <i class='fa fa-envelope'></i> $user->email<br>";
                })
                ->addColumn('investment', function ($user) {
                    return "Total Investment: <code>{$user?->purchased_packages_sum_invested_amount} </code> <br>
                            Total Earned: <code>{$user?->earnings_sum_amount} </code> ";
                })
                ->addColumn('joined', function ($user) {
                    return $user->created_at->format('Y-m-d h:i A');
                })
                ->addColumn('kyc_status', function (User $user) {
                    $html = "";
                    if ($user->purchased_packages_sum_invested_amount > 0) {
                        $html = "<i class='fa fa-certificate text-success' title='Funded Account'></i> ";
                    }
                    $status = "<span class='text-warning'>PENDING</span>";
                    if ($user->profile->is_kyc_verified) {
                        $status = "<span class='text-success'>VERIFIED</span>";
                    }
                    if ($user->profile->kycs->count() > 0 && $user->profile->kycs->where('status', 'rejected')->count() > 0) {
                        $status = "<span class='text-danger'>REJECTED</span>";
                    }
                    if ($user->profile->kycs->count() <= 0 || $user->profile->kycs->where('status', 'required')->count() > 0) {
                        $status = "<span class='text-white'>NOT SUBMITTED</span>";
                    }
                    $html .= $status;
                    return $html;
                })
                ->addColumn('actions', function ($user) {
                    return view('backend.admin.users.includes.users-actions', compact('user'))->render();
                })
                ->rawColumns(['actions', 'profile_photo', 'user_details', 'contact_details', 'investment', 'kyc_status'])
                ->make();
        }
        return view('backend.admin.users.index');
    }

    /**
     * @throws Exception
     */
    public function profileShow(Request $request, User $user, WalletTopupHistoryService $topupHistoryService)
    {
        abort_if(Gate::denies('users.view.profile'), Response::HTTP_FORBIDDEN);

        $latest_transactions = Withdraw::with('receiver')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(8)
            ->get();

        $types = [
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
            //'rank_bonus' => 'BONUS',
            //'rank_gift' => 'GIFT',
        ];

        //earnings
        //rank_benefits
        $income = Earning::currentMonthForUser($user)
            ->where('status', 'RECEIVED')
            ->where('type', '<>', 'P2P')
            ->sum('amount');
        $withdraw = Withdraw::currentMonthForUser($user)->where('status', 'SUCCESS')->sum(DB::raw('amount + transaction_fee'));
        $qualified_commissions = Commission::currentMonthForUser($user)->where('status', 'QUALIFIED')->sum('amount');
        $lost_commissions = Commission::currentMonthForUser($user)->whereStatus('DISQUALIFIED')->sum('amount');

        $income = number_format($income, 2);
        $withdraw = number_format($withdraw, 2);
        $qualified_commissions = number_format($qualified_commissions, 2);
        $lost_commissions = number_format($lost_commissions, 2);

        $Profile_details = $user->profile;
        $wallet = $user->wallet;

        $sameKycUsers = User::whereRelation('profile.kycs', 'status', 'accepted')
            ->whereHas('profile',
                function (Builder $q) use ($user) {
                    $q
                        ->when($user->profile->nic !== null, function (Builder $query) use ($user) {
                            $query->where('nic', $user->profile->nic);
                        })
                        ->when($user->profile->driving_lc_number !== null, function (Builder $query) use ($user) {
                            $query->orWhere('driving_lc_number', $user->profile->driving_lc_number);
                        })
                        ->when($user->profile->passport_number !== null, function (Builder $query) use ($user) {
                            $query->orWhere('passport_number', $user->profile->passport_number);
                        });
                })
            ->get();

        return view('backend.admin.users.profile.show', compact(
                'user',
                'types',
                'Profile_details',
                'wallet',
                'latest_transactions',
                'income',
                'withdraw',
                'qualified_commissions',
                'lost_commissions',
                'sameKycUsers'
            )
        );
    }

    public function suspendUser(Request $request, User $user)
    {
        abort_if(Gate::denies('suspend', $user), Response::HTTP_FORBIDDEN);

        $request->validate(['reason' => 'required|string|max:255']);

        $user->update(['suspend_reason' => $request->get('reason'), 'suspended_at' => Carbon::now()]);

        \Mail::to($user->email)->send(new AccountSuspendMail($user));

        $json['status'] = true;
        $json['message'] = "User is suspended!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = null;
        return response()->json($json, Response::HTTP_OK);
    }

    public function activateUser(User $user)
    {
        abort_if(Gate::denies('reActivate', $user), Response::HTTP_FORBIDDEN);

        $user->update(['suspend_reason' => null, 'suspended_at' => null]);

        \Mail::to($user->email)->send(new AccountReactivateMail($user));

        $json['status'] = true;
        $json['message'] = "User is now active!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = null;
        return response()->json($json, Response::HTTP_OK);
    }
}
