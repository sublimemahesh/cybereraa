<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WithdrawService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class WithdrawController extends Controller
{
    /**
     * @throws Exception
     */
    public function p2p(Request $request, WithdrawService $withdrawService)
    {
        abort_if(Gate::denies('withdraw.p2p.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $withdrawals = $withdrawService->filter(request()->input('user_id'), request()->input('receiver_id'))
                ->where('type', 'P2P');

            return $withdrawService->datatable($withdrawals)
                ->addColumn('sender', static function ($withdraw) {
                    return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->user->username}</code>";
                })->addColumn('receiver', static function ($withdraw) {
                    return str_pad($withdraw->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->receiver->username}</code>";
                })
                ->rawColumns(['sender', 'receiver'])
                ->make();
        }

        return view('backend.admin.users.transfers.p2p');
    }

    /**
     * @throws Exception
     */
    public function withdrawals(Request $request, WithdrawService $withdrawService)
    {
        abort_if(Gate::denies('withdrawals.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $withdrawals = $withdrawService->filter(null, request()->input('receiver_id'))
                ->where('type', 'BINANCE');

            return $withdrawService->datatable($withdrawals)
                ->addColumn('user', static function ($withdraw) {
                    return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->user->username}</code>";
                })
                ->addColumn('actions', static function ($withdraw) {
                    // withdraw.approve | withdraw.reject
                    /*if ($withdraw->status === 'PROCESSING') {
                        return '<a href=" ' . route('admin.transfers.withdrawals.form') . ' " class="btn btn-xs btn-info">-</a>';
                    }*/
                    return '-';
                })
                ->rawColumns(['user', 'actions'])
                ->make();
        }

        return view('backend.admin.users.transfers.binance-withdraw');
    }

    public function withdrawalsForm()
    {
        return view('backend.admin.users.transfers.withdraw');

    }


}
