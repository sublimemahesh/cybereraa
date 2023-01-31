<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        if ($request->wantsJson()) {
            $users = User::whereRelation('roles', 'name', 'user')
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
                    return "<img class='rounded-circle' width='35' src='" . $user->profile_photo_url . "' alt='' />";
                })
                ->addColumn('joined', fn($user) => $user->created_at->format('Y-m-d h:i A'))
                ->addColumn('actions', function ($user) {
                    $manage_kyc = Gate::allows('kyc.viewAny');
                    $view_profile = Gate::allows('users.view.profile');
                    $update = Gate::allows('users.update');
                    $btn = '';
                    if ($manage_kyc) {
                        $btn .= "<a class='btn btn-xs btn-google sharp my-1 mr-1 shadow' href='" . route('admin.users.kycs.index', $user) . "'>
                                        <i class='fas fa-check-to-slot'></i>
                                    </a>";
                    }

                    if ($update) {
                        $btn .= '<a class="btn btn-xs btn-info sharp my-1 mr-1 shadow" href="' . route('super_admin.users.changePassword', $user) . '" title="Reset Password">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                </a>';
                        $btn .= ' <a class="btn btn-xs btn-primary sharp my-1 mr-1 shadow" href="' . route('super_admin.users.edit', $user) . '" title="Edit">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>';
                    }

                    if ($view_profile) {
                        $btn .= "<a class='btn btn-xs btn-success sharp my-1 mr-1 shadow' href='" . route('admin.users.profile.show', $user) . "' >
                                            <i class='fa fa-user' aria-hidden='true'></i>
                                        </a>";
                    }
                    return "<div class='d-flex'>{$btn}</div>";
                })
                ->rawColumns(['actions', 'profile_photo'])
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

        return view('backend.admin.users.profile.show', compact('user', 'types', 'Profile_details', 'wallet', 'latest_transactions', 'income', 'withdraw', 'qualified_commissions', 'lost_commissions'));
    }
}
