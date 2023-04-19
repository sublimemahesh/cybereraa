<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Withdraw;
use App\Services\WithdrawService;
use Carbon;
use DataTables;
use Exception;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use URL;
use Validator;

class WithdrawController extends Controller
{

    /**
     * @throws Exception
     */
    public function p2pHistory(Request $request, WithdrawService $withdrawService)
    {
        if ($request->wantsJson()) {

            if ($request->get('filter') === 'received') {
                $withdrawals = $withdrawService
                    ->filter($request->get('receiver_id'), Auth::user()->id)
                    ->where('type', 'P2P');
            } else {
                $withdrawals = $withdrawService
                    ->filter(Auth::user()->id, $request->get('receiver_id'))
                    ->where('type', 'P2P');
            }

            return $withdrawService->datatable($withdrawals)
                ->addColumn('receiver', static function ($withdraw) use ($request) {
                    if ($request->get('filter') === 'received') {
                        return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                            " - <code class='text-uppercase'>{$withdraw->user->username}</code>";
                    }

                    return str_pad($withdraw->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdraw->receiver->username}</code>";

                })
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
                ->rawColumns(['type', 'receiver', 'actions'])
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
                ->where('type', 'MANUAL');

            return DataTables::of($withdrawals)
                ->addColumn('withdraw_id', fn($withdraw) => str_pad($withdraw->id, 4, 0, STR_PAD_LEFT))
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('date', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->addColumn('type_n_wallet', function ($withdraw) {
                    return "Type: <code class='text-uppercase'>{$withdraw->type}</code> <br>
                            Wallet: <code class='text-uppercase'>{$withdraw->wallet_type}</code>";
                })
                ->addColumn('actions', function ($withdraw) {
                    $actions = '<div class="d-flex">';
                    $actions .= '<a href="' . URL::signedRoute('user.wallet.transfer.invoice', $withdraw) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-receipt"></i>
                                </a>';
                    if (Gate::allows('view', $withdraw)) {
                        $actions .= '<a href="' . route('user.wallet.withdraw.view', $withdraw) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-eye"></i>
                                </a>';
                    }
                    if (Gate::allows('cancelWithdraw', $withdraw)) {
                        $actions .= '<a href="' . route('user.wallet.withdraw.cancel', $withdraw) . '" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
                                    <i class="fa fa-ban"></i>
                                </a>';
                    }
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['actions', 'type_n_wallet'])
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
        $profile = Auth::user()->profile;

        if ($profile->binance_email === null || $profile->binance_id === null || $profile->wallet_address === null || $profile->binance_phone === null) {
            return redirect()->route('profile.show')->with('warning', 'Please Fill your Binance Account details, before continuing.!');
        }

        $strategies = Strategy::whereIn('name', ['payout_transfer_fee', 'minimum_payout_limit'])->get();
        $wallet = Auth::user()->wallet;

        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, new Strategy(['value' => 5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.binance-payouts', compact('profile', 'payout_transfer_fee', 'max_withdraw_limit', 'minimum_payout_limit', 'wallet'));
    }

    /**
     * @throws AuthorizationException
     * @throws JsonException
     */
    public function show(Request $request, Withdraw $withdraw)
    {
        $this->authorize('view', $withdraw);
        $skel = '{"email":"","id":"","address":"","phone":""}';
        $payout_info = json_decode($withdraw?->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);
        return view('backend.admin.users.transfers.withdraw-summery', compact('withdraw', 'payout_info'));
    }

    /**
     * @throws Throwable
     * @throws AuthorizationException
     * @throws JsonException
     */
    public function cancelWithdraw(Request $request, Withdraw $withdraw)
    {
        $this->authorize('cancelWithdraw', $withdraw);

        $user = Auth::user();
        $user_wallet = $user?->wallet;
        $profile = $user?->profile;

        $skel = '{"email":"","id":"","address":"","phone":""}';
        $payout_info = json_decode($withdraw->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required|string'
            ])->validate();

            \DB::transaction(function () use ($withdraw, $user_wallet, $user, $validated) {

                $total_amount = $withdraw->amount + $withdraw->transaction_fee;

                $withdraw->update([
                    'status' => 'CANCELLED',
                    'repudiate_note' => $validated['repudiate_note'] ?? null,
                    'cancelled_at' => \Carbon::now(),
                ]);

                if ($withdraw->wallet_type === 'MAIN') {
                    $user_wallet->increment('balance', $total_amount);
                    $user_wallet->increment('withdraw_limit', $total_amount);

                    $expired_packages = explode(',', $withdraw->expired_packages);

                    if (count($expired_packages) > 0) {
                        $user->purchasedPackages()
                            ->where('expired_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
                            ->whereIn('id', $expired_packages)
                            ->update(['status' => 'ACTIVE']);
                    }
                }

                if ($withdraw->wallet_type === 'TOPUP') {
                    $user_wallet->increment('topup_balance', $total_amount);
                }


                // TODO: SEND MAIL
            });

            $json['status'] = true;
            $json['message'] = 'Payout Cancelled!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = URL::signedRoute('user.wallet.transfer.invoice', $withdraw);
            $json['data'] = $validated;

            return response()->json($json);
        }

        return view('backend.user.withdrawals.cancel-payouts', compact('withdraw', 'payout_info', 'profile'));
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
            ->whereRelation('roles', 'name', 'user')
            ->get();
        return Select2UserResource::collection($users);
    }


}
