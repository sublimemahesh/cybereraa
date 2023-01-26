<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {

        if ($request->wantsJson()) {
            $users = User::when($request->get('date-range'), function (Builder $q) {
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
                    return "<div class='d-flex'>
                                <a href='" . route('admin.users.kycs.index', $user) . "' class='btn btn-success shadow btn-xs sharp me-1'>
                                    <i class='fas fa-check-to-slot'></i>
                                </a>
                            </div>";
                })
                ->rawColumns(['actions', 'profile_photo'])
                ->make();
        }
        return view('backend.admin.users.index');
    }
}
