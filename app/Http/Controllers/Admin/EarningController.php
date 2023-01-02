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
            $earnings = Earning::with('earnable', 'user.ranks')
                ->filter()
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                //->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
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
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }

    public function calculateCommission()
    {
        //$this->authorize('calculate_profit');
        $res = Artisan::call('commission:calculate');
        $json['status'] = $res === 0;
        $json['message'] = Artisan::output();
        $json['icon'] = $res === 0 ? 'success' : 'error'; // warning | info | question | success | error
        $code = $res === 0 ? 200 : 422;
        return response()->json($json, $code);
    }
}
