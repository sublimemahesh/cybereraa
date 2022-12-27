<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Auth;
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
                ->with('package')
                ->where('user_id', Auth::user()->id)
                ->latest();

            return DataTables::of($transactions)
                ->addColumn('trx_id', fn($trx) => '#' . str_pad($trx->id, '4', '0', STR_PAD_LEFT))
                ->addColumn('package', fn($trx) => $trx->create_order_request_info->goods->goodsName ?? '-')
                ->addColumn('trx_amount', fn($trx) => "USDT " . $trx->amount)
                ->addColumn('paid_at', fn($trx) => $trx->response_info ? Carbon::createFromTimestamp($trx->response_info->data->transactTime/1000)->format('Y-m-d h:i A') : '-')
                ->addColumn('created_at', fn($trx) => $trx->created_at->format('Y-m-d h:i A'))
                ->addColumn('updated_at', fn($trx) => $trx->updated_at->format('Y-m-d h:i A'))
                ->addColumn('action', function (Transaction $trx) {
                    return  "<a href='#' class='d-block text-center'><i class='fa fa-eye'></i></a>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.user.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        //
    }

}
