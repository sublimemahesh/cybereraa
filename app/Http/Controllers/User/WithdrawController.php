<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Withdraw;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use URL;

class WithdrawController extends Controller
{

    /**
     * @throws Exception
     */
    public function p2pHistory(Request $request)
    {
        if ($request->wantsJson()) {

            $withdrawals = Withdraw::with('receiver')
                ->where('user_id', Auth::user()->id)
                ->when(!empty($request->get('receiver_id')), static function ($query) use ($request) {
                    $query->where('receiver_id', $request->get('receiver_id'));
                })
                ->filter()
                ->where('type', 'P2P')
                //->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($withdrawals)
                ->addColumn('receiver', static function ($withdraw) {
                    return str_pad($withdraw->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->receiver->username}</code>";
                })
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('created_at', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->addColumn('actions', function ($withdraw) {
                    return '<div class="dropdown">
                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
                                        <div class="py-2">
                                            <a class="dropdown-item" href="' . URL::signedRoute('user.wallet.transfer.invoice', $withdraw) . '">Invoice</a>
                                        </div>
                                    </div>
                                </div>';
                })
                ->rawColumns(['receiver', 'actions'])
                ->make();
        }

        return view('backend.user.withdrawals.history.p2p');
    }

    /**
     * @throws Exception
     */
    public function withdrawalsHistory(Request $request)
    {
        if ($request->wantsJson()) {

            $withdrawals = Withdraw::filter()
                ->where('user_id', Auth::user()->id)
                ->where('type', 'BINANCE')
                //->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::of($withdrawals)
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('created_at', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->addColumn('actions', static function ($withdraw) {
                    return '-';
                })
                ->rawColumns(['actions'])
                ->make();
        }

        return view('backend.user.withdrawals.history.binance-withdraw');
    }


    public function p2pTransfer()
    {
        $strategies = Strategy::whereIn('name', ['p2p_transfer_fee', 'minimum_payout_limit'])->get();
        $wallet = Auth::user()->wallet;

        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, new Strategy(['value' => 2.5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.p2p-transfer', compact('p2p_transfer_fee', 'max_withdraw_limit', 'minimum_payout_limit', 'wallet'));
    }

    public function withdraw()
    {
        $strategies = Strategy::whereIn('name', ['payout_transfer_fee', 'minimum_payout_limit'])->get();
        $wallet = Auth::user()->wallet;

        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, new Strategy(['value' => 5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.binance-payouts', compact('payout_transfer_fee', 'max_withdraw_limit', 'minimum_payout_limit', 'wallet'));
    }

    public function findUser(User $user): \Illuminate\Http\JsonResponse
    {
        $json = [];
        $code = Response::HTTP_NOT_FOUND;
        if (Auth::user()->id !== $user->id) {
            $json['status'] = true;
            $json['message'] = 'Request successful';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['user'] = [
                'id' => $user->id,
                'text' => $user->name . " - " . $user->username
            ];
            $code = Response::HTTP_OK;
        }
        return response()->json($json, $code);
    }

    public function findUsers($search_text): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            ->where('id', '<>', Auth::user()->id)
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super_admin', 'admin']);
            })
            ->get();
        return Select2UserResource::collection($users);
    }


}
