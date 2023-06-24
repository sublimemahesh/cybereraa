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
