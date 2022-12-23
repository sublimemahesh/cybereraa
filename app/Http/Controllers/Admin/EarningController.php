<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EarningController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = Earning::with('purchasedPackage.package', 'user')
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->filter()
                ->whereDate('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($earn) => $earn->purchasedPackage->package->name)
                ->addColumn('amount', fn($earn) => "USDT " . $earn->amount)
                ->addColumn('username', fn($earn) => $earn->user->username)
                ->addColumn('created_at', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->make(true);
        }
        return view('backend.admin.users.earnings.index');
    }

    public function calculateProfit()
    {
        //$this->authorize('calculate_profit');
        $res = Artisan::call('profit:calculate');
        $json['status'] = (bool)$res;
        $json['message'] = Artisan::output();
        $json['icon'] = $res ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res ? 200 : 422; // warning | info | question | success | error
        return response()->json($json, $code);
    }
}
