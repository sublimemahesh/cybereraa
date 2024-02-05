<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ActivityLogAction;
use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class EarningController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('earnings.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->routeIs('admin.staking.earnings.index')) {
            $request->merge(['earning-type' => 'staking']);
        }

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
                        "<code class='text-uppercase'>{$earn->type}</code> - #" .
                        str_pad($earn->earnable_id, '4', '0', STR_PAD_LEFT);
                })
                ->addColumn('user_id', fn($earn) => str_pad($earn->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
                ->addColumn('username', fn($earn) => $earn->user->username)
                ->addColumn('amount_formatted', function ($earn) {
                    return number_format($earn->amount, 2);
                })
                ->addColumn('date', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user', 'earnable_type'])
                ->make();
        }

//        $earningPendingActivePackagesDate = '2024-02-02';
        $earningPendingActivePackagesDate = date('Y-m-d');
        $earningPendingActivePackages = getPendingEarningsCount($earningPendingActivePackagesDate);
        return view('backend.admin.users.earnings.index', compact('earningPendingActivePackages', 'earningPendingActivePackagesDate'));

    }

    /**
     * @throws JsonException
     */
    public function calculateProfit(Request $request, ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_daily_package_earnings'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('generate_daily_package_earnings');
        $validated = Validator::make($request->all(), [
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
        ])->validate();

        //$this->authorize('calculate_profit');
        $res = Artisan::call("calculate:profit {$validated['date']}");
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }

    public function getPendingEarnings(Request $request): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('generate_daily_package_earnings'), Response::HTTP_FORBIDDEN);

        $validated = Validator::make($request->all(), [
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
        ])->validate();

        $earningPendingActivePackagesDate = $validated['date'];
        $earningPendingActivePackages = getPendingEarningsCount($earningPendingActivePackagesDate);

        $json['status'] = true;
        $json['message'] = 'Success';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = compact('earningPendingActivePackages', 'earningPendingActivePackagesDate');
        return response()->json($json, 200);
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


    /**
     * @throws JsonException
     */
    public function releaseStakingInterest(ActivityLogAction $activityLog): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('release_staking_interest'), Response::HTTP_FORBIDDEN);
        $activityLog->exce('release_staking_interest');
        $res = Artisan::call('calculate:staking-interest');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }

//    /**
//     * @param mixed $earningPendingActivePackagesDate
//     * @return int
//     */
//    private function getPendingEarningsCount(mixed $earningPendingActivePackagesDate): int
//    {
//        $investment_start_at = Strategy::where('name', 'investment_start_at')->firstOr(fn() => new Strategy(['value' => 2]));
//        if (\Carbon::parse($earningPendingActivePackagesDate)->isWeekend()) {
//            $earningPendingActivePackages = 0;
//        } else {
//            $earningPendingActivePackages = PurchasedPackage::with('user')
//                ->where('status', 'ACTIVE')
//                ->where('is_free_package', 0)
//                ->whereRaw("DATE(`created_at`) + INTERVAL {$investment_start_at->value} DAY <= '{$earningPendingActivePackagesDate}'")
//                ->whereDoesntHave('earnings', fn($query) => $query->whereDate('created_at', $earningPendingActivePackagesDate))
//                //        ->toSql();
//                ->count();
//        }
//        return $earningPendingActivePackages;
//    }

}
