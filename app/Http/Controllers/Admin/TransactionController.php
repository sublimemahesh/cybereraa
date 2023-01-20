<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $transactions = Transaction::filter()
                ->with('package', 'user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })
                ->latest();

            return DataTables::of($transactions)
                ->addColumn('user_id', fn($trx) => str_pad($trx->user_id, '4', '0', STR_PAD_LEFT))
                ->addColumn('trx_id', fn($trx) => '#' . str_pad($trx->id, '4', '0', STR_PAD_LEFT))
                ->addColumn('username', fn($earn) => $earn->user->username)
                ->addColumn('package', fn($trx) => $trx->create_order_request_info->goods->goodsName ?? '-')
                ->addColumn('trx_amount', fn($trx) => number_format($trx->amount, 2))
                ->addColumn('paid_at', fn($trx) => $trx->response_info ? Carbon::createFromTimestamp($trx->response_info->data->transactTime / 1000)->format('Y-m-d h:i:s') : '-')
                ->addColumn('created_at', fn($trx) => $trx->created_at->format('Y-m-d h:i A'))
                ->addColumn('updated_at', fn($trx) => $trx->updated_at->format('Y-m-d h:i A'))
                ->addColumn('action', function (Transaction $trx) {
                    return "";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.admin.users.transactions.index');
    }


}
