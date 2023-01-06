<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use URL;
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
                ->addColumn('trx_amount', fn($trx) => number_format($trx->amount, 2))
                ->addColumn('paid_at', fn($trx) => $trx->response_info ? Carbon::createFromTimestamp($trx->response_info->data->transactTime / 1000)->format('Y-m-d h:i A') : '-')
                ->addColumn('created_at', fn($trx) => $trx->created_at->format('Y-m-d h:i A'))
                ->addColumn('updated_at', fn($trx) => $trx->updated_at->format('Y-m-d h:i A'))
                ->addColumn('action', function (Transaction $trx) {
                    $url = URL::signedRoute('user.transactions.invoice', $trx);
                    $retryBtn = '';
                    if ($trx->type === 'crypto' && $trx->status === 'INITIAL' && !empty($trx->create_order_request_info->orderExpireTime)) {
                        if (!Carbon::createFromTimestamp($trx->create_order_request_info->orderExpireTime / 1000)->isPast()) {
                            $retryURL = route('user.transactions.retry-payment', $trx);
                            $retryBtn = "<a href='{$retryURL}' class='btn btn-success btn-xxs shadow'>Pay</a>";
                        } else {
                            Transaction::find($trx->id)->update(['status' => 'EXPIRED']);
                        }
                    }

                    return "<div class='d-flex justify-content-start py-1'>
                        <a href='{$url}' class='btn btn-primary shadow btn-xs sharp me-3'><i class='fa fa-eye'></i></a>
                        {$retryBtn}
                    </div>";

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.user.transactions.index');
    }


}
