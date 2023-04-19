<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use URL;

class TransactionController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request, TransactionService $transaction)
    {
        if ($request->wantsJson()) {
            $request->user_id = null;
            return $transaction->datatable(user_id: Auth::user()->id)
                ->addColumn('action', static function ($trx) {
                    $url = URL::signedRoute('user.transactions.invoice', $trx);
                    $retryBtn = '';
                    if ($trx->type === 'crypto' && $trx->status === 'INITIAL' && !empty($trx->create_order_request_info->orderExpireTime)) {
                        if (!Carbon::createFromTimestamp($trx->create_order_request_info->orderExpireTime / 1000)->isPast()) {
                            $retryURL = route('user.transactions.retry-payment', $trx);
                            $retryBtn = "<div class='py-1'><a href='{$retryURL}' class='dropdown-item'>Pay Now</a></div>";
                        } else {
                            Transaction::find($trx->id)->update(['status' => 'EXPIRED']);
                        }
                    }

                    return '<div class="dropdown">
                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
                                        <div class="py-1">
                                            <a class="dropdown-item" href="' . $url . '">Invoice</a>
                                        </div>
                                        ' . $retryBtn . '
                                    </div>
                                </div>';
                })
                ->rawColumns(['action', 'user', 'purchaser', 'type'])
                ->make();

        }
        return view('backend.user.transactions.index');
    }

    /**
     * @throws Exception
     */
    public
    function purchaseHistory(Request $request, TransactionService $transaction)
    {
        if ($request->wantsJson()) {
            $request->purchaser_id = null;
            return $transaction->datatable(user_id: $request->get('user_id'), purchase_id: Auth::user()->id)
                ->addColumn('action', static function ($trx) {
                    $url = URL::signedRoute('user.transactions.invoice', $trx);
                    $retryBtn = '';
                    if ($trx->type === 'crypto' && $trx->status === 'INITIAL' && !empty($trx->create_order_request_info->orderExpireTime)) {
                        if (!Carbon::createFromTimestamp($trx->create_order_request_info->orderExpireTime / 1000)->isPast()) {
                            $retryURL = route('user.transactions.retry-payment', $trx);
                            $retryBtn = "<div class='py-1'><a href='{$retryURL}' class='dropdown-item'>Pay Now</a></div>";
                        } else {
                            Transaction::find($trx->id)->update(['status' => 'EXPIRED']);
                        }
                    }

                    return '<div class="dropdown">
                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
                                        <div class="py-1">
                                            <a class="dropdown-item" href="' . $url . '">Invoice</a>
                                        </div>
                                        ' . $retryBtn . '
                                    </div>
                                </div>';
                })
                ->rawColumns(['action', 'user', 'purchaser', 'type'])
                ->make();
        }
        return view('backend.user.transactions.purchase-history');
    }

}
