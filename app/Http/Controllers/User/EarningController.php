<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\YealyIncomeBarChartResource;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\RankBenefit;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EarningController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Earning::filter()
                ->with('earnable')
                ->where('user_id', Auth::user()->id);

            return DataTables::of($earnings)
                ->addColumn('earnable_type', function ($earn) {
                    return
                        "<code class='text-uppercase'>{$earn->type}</code> - #" .
                        str_pad($earn->earnable_id, '4', '0', STR_PAD_LEFT);
                })
                ->addColumn('amount', fn($commission) => number_format($commission->amount, 2))
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
                ->addColumn('date', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['earnable_type'])
                ->make();
        }
        return view('backend.user.earnings.index');
    }

    /**
     * @throws Exception
     */
    public function earningSummary(Request $request)
    {
        if ($request->wantsJson()) {
            $group_condition = 'DATE(created_at)';
            if (in_array($request->get('group-by'), ['DATE', 'YEARWEEK', 'MONTHNAME', 'YEAR'])) {
                $group_condition = ($request->get('group-by', 'DATE')) . '(created_at)';
            }
            $earnings = Earning::selectRaw($group_condition . ' AS group_period, type, status, SUM(amount) AS earnings')
                ->filter()
                ->with('earnable')
                ->where('user_id', Auth::user()->id)
                ->groupBy('group_period', 'type', 'status');

            return DataTables::of($earnings)
                ->addColumn('earnable_type', function ($earn) {
                    return $earn->type;
                })
                ->addColumn('amount', fn($commission) => number_format($commission->earnings, 2))
                ->addColumn('date', function ($earn) use ($request) {
                    if ($request->get('group-by') === 'YEARWEEK') {
                        return substr($earn->group_period, 0, 4) . ' - ' . substr($earn->group_period, 4) . ' Week';
                    }
                    return $earn->group_period;
                })
                ->addColumn('status', fn($earn) => $earn->status)
                ->rawColumns(['earnable_type'])
                ->make();
        }
        return view('backend.user.earnings.summery');
    }

    /**
     * @throws Exception
     */
    public function teamHighestEarnings(Request $request)
    {
        if ($request->wantsJson()) {
            $descendants = Auth::user()->descendants()->select('id')->pluck('id')->toArray();
            $earnings = Earning::selectRaw('user_id, SUM(amount) AS earnings')
                ->filter()
                ->with(['user.sponsor', 'earnable'])
                ->whereIn('user_id', $descendants)
                ->whereNotIn('type', ['RANK_BONUS', 'RANK_GIFT', 'P2P', 'STAKING'])
                ->where('status', 'RECEIVED')
                ->groupBy('user_id');
            //->orderBy('earnings', 'desc');

            return DataTables::of($earnings)
                //                ->addColumn('earnable_type', function ($earn) {
                //                    return $earn->type;
                //                })
                ->addColumn('user', static function ($trx) {
                    return "#" . str_pad($trx->user_id, '4', '0', STR_PAD_LEFT);
                })
                ->addColumn('username', static function ($trx) {
                    return $trx->user->username;
                })
                ->addColumn('name', static function ($trx) {
                    return $trx->user->name;
                })
                ->addColumn('sponsor', static function ($trx) {
                    return $trx->user->sponsor->username;
                })
                ->addColumn('amount', fn($commission) => number_format($commission->earnings, 2))
                /*->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)*/
                /*->addColumn('date', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))*/
                // ->rawColumns(['user', 'earnable_type'])
                ->make();
        }


        $types = [
            'package' => 'PACKAGE',
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
        ];
        return view('backend.user.teams.highest-earnings', compact('types'));
    }


    public function incomeChart(Request $request)
    {
        $user = Auth::user();
        $year = date('Y');

        $validator = \Validator::make($request->all(), ['year' => 'required|date_format:Y']);
        if ($validator->passes()) {
            $year = $request->get('year');
        }

        if ($request->isMethod('POST') && $request->wantsJson()) {
            $yearlyIncome = DB::table('earnings')
                ->select(DB::raw('MONTH(created_at) AS month, type, SUM(amount) AS monthly_income'))
                ->whereYear('created_at', $year)
                ->where('user_id', $user?->id)
                ->where('status', 'RECEIVED')
                ->groupBy('month', 'type')
                ->orderBy('month')
                ->orderBy('type')
                ->get();

            $descendants = $user?->descendants()->pluck('id')->toArray();

            $teamYearlyIncome = DB::table('earnings')
                ->select(DB::raw('MONTH(created_at) AS month, type, SUM(amount) AS monthly_income'))
                ->whereIn('user_id', $descendants)
                ->where('status', 'RECEIVED')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month', 'type')
                ->orderBy('month')
                ->orderBy('type')
                ->get();

            $json['my_total_income'] = number_format(Earning::where('user_id', $user?->id)
                ->where('status', 'RECEIVED')
                ->whereIn('type', ['PACKAGE', 'DIRECT', 'INDIRECT'])
                ->whereYear('created_at', date('Y'))->sum('amount'), 2);

            $json['my_income'] = new YealyIncomeBarChartResource($yearlyIncome);
            $json['team'] = new YealyIncomeBarChartResource($teamYearlyIncome);
            $json['status'] = true;
            $json['message'] = "success";
            $json['icon'] = 'success'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_OK);
        }

        $yearRangeForFilter = array_unique([
            \Carbon::parse(Earning::min('created_at'))->format('Y'),
            \Carbon::parse(Earning::max('created_at'))->format('Y')
        ]);

        return view('backend.user.earnings.charts.yearly-income-chart', compact('yearRangeForFilter', 'year'));
    }

    /**
     * @throws Exception
     */
    public function commission(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Commission::filter()
                ->with('purchasedPackage.user')
                ->where('user_id', Auth::user()->id);
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            //->latest();

            return DataTables::eloquent($earnings)
                ->addColumn('referer', function ($commission) {
                    return str_pad($commission->purchasedPackage->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$commission->purchasedPackage->user->username}</code>";
                })
                ->addColumn('package', fn($commission) => $commission->package_info_json->name)
                ->addColumn('amount', fn($commission) => number_format($commission->amount, 2))
                ->addColumn('paid', fn($commission) => number_format($commission->paid, 2))
                ->addColumn('created_date', fn($commission) => $commission->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['referer'])
                ->make();
        }

        $types = [
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
        ];

        return view('backend.user.incomes.commissions', compact('types'));
    }

    /**
     * @throws Exception
     */
    public function teamCommissionsIncome(Request $request)
    {
        if ($request->wantsJson()) {
            $descendants = Auth::user()->descendants()->pluck('id')->toArray();
            $incomes = Commission::selectRaw('user_id, SUM(amount) AS total_amount, SUM(paid) AS total_paid')
                ->filter()
                ->with(['user.sponsor', 'user.currentRank'])
                ->whereIn('user_id', $descendants)
                ->whereIn('status', ['QUALIFIED', 'COMPLETED'])
                ->groupBy('user_id');

            return DataTables::of($incomes)
                ->addColumn('user', static function ($commission) {
//                    dd($commission);
                    return "#" . str_pad($commission->user_id, '4', '0', STR_PAD_LEFT);
                })
                ->addColumn('username', static function ($commission) {
                    return $commission->user->username;
                })
                ->addColumn('name', static function ($commission) {
                    return $commission->user->name;
                })
                ->addColumn('sponsor', static function ($commission) {
                    return $commission->user->sponsor->username;
                })
                ->addColumn('rank', static function ($commission) {
                    if ($commission->user?->currentRank?->rank !== null) {
                        return "Rank 0" . $commission->user->currentRank->rank;
                    }
                    return "-";
                })
                ->addColumn('total_amount_format', fn($commission) => number_format($commission->total_amount, 2))
                ->addColumn('total_paid_format', fn($commission) => number_format($commission->total_paid, 2))
                ->make();

        }

        $types = [
            'direct' => 'DIRECT',
            'indirect' => 'INDIRECT',
        ];

        return view('backend.user.teams.income', compact('types'));
    }

    /**
     * @throws Exception
     */
    public function rewards(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = RankBenefit::filter()
                ->where('user_id', Auth::user()->id);
            //->where('created_at', '<=', date('Y-m-d H:i:s'))
            //->latest();

            return DataTables::eloquent($earnings)
                ->addColumn('package', fn($reward) => $reward->package_info_json->name)
                ->addColumn('referer', '-')
                ->addColumn('amount', fn($reward) => number_format($reward->amount, 2))
                ->addColumn('paid', fn($reward) => number_format($reward->paid, 2))
                ->addColumn('created_date', fn($reward) => $reward->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        $types = [
            'rank_bonus' => 'BONUS',
            'rank_gift' => 'GIFT',
        ];

        return view('backend.user.incomes.commissions', compact('types'));
    }
}
