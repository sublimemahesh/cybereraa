<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use Auth;
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
            $earnings = Earning::with('purchasedPackage.package')
                ->where('user_id', Auth::user()->id)
                ->whereDate('created_at', '<=', date('Y-m-d H:i:s'))
                ->filter()
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($earn) => $earn->purchasedPackage->package->name)
                ->addColumn('amount', fn($earn) => "USDT " . $earn->amount)
                ->addColumn('created_at', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->make(true);
        }
        return view('backend.user.earnings.index');
    }


}
