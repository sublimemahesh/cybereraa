<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ActivityLogAction;
use App\Http\Controllers\Controller;
use App\Models\Earning;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EarningController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('earnings.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $earnings = Earning::filter()
                ->with('earnable', 'user.ranks')
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                });
            //->where('created_at', '<=', date('Y-m-d H:i:s'));

            return DataTables::of($earnings)
                ->addColumn('user_id', fn($earn) => str_pad($earn->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('user', function ($earn) {
                    return " <a href='" . route('admin.users.profile.show', $earn->user) . "' target='_blank'>
                                    {$earn->user->username}
                                </a>";
                })
                ->addColumn('earnable_type', function ($earn) {
                    return
                        "<code class='text-uppercase'>{$earn->type}</code> - #".
                        str_pad($earn->earnable_id, '4', '0', STR_PAD_LEFT) ;
                })
                ->addColumn('user_id', fn($earn) => str_pad($earn->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
                ->addColumn('username', fn($earn) => $earn->user->username)
                ->addColumn('amount', fn($earn) => number_format($earn->amount, 2))
                ->addColumn('date', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user', 'earnable_type'])
                ->make();
        }
        return view('backend.admin.users.earnings.index');
    }

    /**
     * @throws JsonException
     */
    public function calculateProfit(ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_daily_package_earnings'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('generate_daily_package_earnings');
        //$this->authorize('calculate_profit');
        $res = Artisan::call('calculate:profit');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }

    /**
     * @throws JsonException
     */
    public function calculateCommission(ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_daily_commission'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('generate_daily_commission');
        $res = Artisan::call('calculate:commission');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }

    /**
     * @throws JsonException
     */
    public function calculateRankBonusEarning(ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_daily_rank_bonus'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('generate_daily_rank_bonus');
        $res = Artisan::call('calculate:rank-benefit-earning');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }


    /**
     * @throws JsonException
     */
    public function issueMonthlyRankBonuses(ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_monthly_rank_bonus'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('generate_monthly_rank_bonus');
        $res = Artisan::call('calculate:rank-bonus');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }


}
