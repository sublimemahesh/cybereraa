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
            $earnings = Earning::filter()
                ->with('earnable')
                ->where('user_id', Auth::user()->id)
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($earnings)
                ->addColumn('package', fn($earn) => $earn->earnable->package_info_json->name)
                ->addColumn('created_at', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->make(true);
        }
        return view('backend.user.earnings.index');
    }


}
