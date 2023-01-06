<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    /**
     * @throws Exception
     */
    public function p2p(Request $request)
    {
        if ($request->wantsJson()) {

            $withdrawals = Withdraw::with('receiver', 'user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })->when(!empty($request->get('receiver_id')), static function ($query) use ($request) {
                    $query->where('receiver_id', $request->get('receiver_id'));
                })->filter()
                ->where('type', 'P2P')
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($withdrawals)
                ->addColumn('sender', static function ($withdraw) {

                    return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->user->username}</code>";
                })->addColumn('receiver', static function ($withdraw) {
                    return str_pad($withdraw->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->receiver->username}</code>";
                })
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('created_at', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['sender', 'receiver'])
                ->make();
        }

        return view('backend.admin.users.transfers.p2p');
    }

    /**
     * @throws Exception
     */
    public function withdrawals(Request $request)
    {
        if ($request->wantsJson()) {

            $withdrawals = Withdraw::with('receiver', 'user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })->filter()
                ->where('type', 'BINANCE')
                ->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($withdrawals)
                ->addColumn('user', static function ($withdraw) {
                    return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->user->username}</code>";
                })
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('created_at', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->addColumn('actions', static function ($withdraw) {
                    return '-';
                })
                ->rawColumns(['user', 'actions'])
                ->make();
        }

        return view('backend.admin.users.transfers.binance-withdraw');
    }

}
