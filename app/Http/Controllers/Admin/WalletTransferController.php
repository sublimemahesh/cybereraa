<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransfer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WalletTransferController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('wallet.transfers-history.viewAny'), Response::HTTP_FORBIDDEN);
        $transfer_histories = WalletTransfer::filter();
        if ($request->wantsJson()) {
            return DataTables::eloquent($transfer_histories)
                ->addColumn('user', function ($trx) {
                    return str_pad($trx->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$trx->user->username}</code>";
                })
                ->addColumn('date', fn($trx) => $trx->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user'])
                ->make();
        }
        return view('backend.admin.users.wallets.transfer-between-wallet');
    }
}
