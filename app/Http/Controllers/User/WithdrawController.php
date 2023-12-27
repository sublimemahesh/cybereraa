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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;
use Str;
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
                    $actions = '<div class="d-flex">';
                    $actions .= '<a href="' . URL::signedRoute('user.wallet.transfer.invoice', $withdraw) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-receipt"></i>
                                </a>';
                    if (Gate::allows('p2pConfirm', $withdraw)) {
                        $actions .= '<a href="' . route('user.withdraw.confirm-p2p', $withdraw) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-check-double"></i>
                                </a>';
                    }

                    if ($withdraw->proof_document !== null) {
                        $actions .= '<a href="' . asset('storage/payouts/p2p/' . $withdraw->proof_document) . '" target="_blank" class="btn btn-xs btn-outline-warning sharp my-1 mr-1 shadow">
                                    <i class="fa fa-images"></i>
                                </a>';
                    }
                    $actions .= '</div>';
                    return $actions;
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
                ->when($request->routeIs('user.staking.transfers.withdrawals'), function (Builder $query) {
                    $query->where('wallet_type', 'STAKING');
                })
                ->when(!$request->routeIs('user.staking.transfers.withdrawals'), function (Builder $query) {
                    $query->where('wallet_type', '<>', 'STAKING');
                })
                ->where('user_id', Auth::user()->id)
                ->where('type', 'MANUAL');

            return DataTables::of($withdrawals)
                ->addColumn('withdraw_id', function ($withdraw) {
                    return "#" . str_pad($withdraw->id, 4, 0, STR_PAD_LEFT);
                })
                ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
                ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
                ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
                ->addColumn('date', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
                ->addColumn('type_n_wallet', function ($withdraw) {
                    return "Type: <code class='text-uppercase'>{$withdraw->type}</code> <br>
                            Wallet: <code class='text-uppercase'>{$withdraw->wallet_type}</code>";
                })
                ->addColumn('wallet_address', function ($withdraw) {
                    $skeleton = '{"email":"","id":"","address":"","phone":"", "wallet_address_nickname":""}';
                    $payout_info = json_decode($withdraw?->payout_details ?? $skeleton, false, 512, JSON_THROW_ON_ERROR);
                    return $payout_info->address;
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
        $strategies = Strategy::whereIn('name', ['p2p_transfer_fee', 'minimum_p2p_transfer_limit'])->get();
        $wallet = Auth::user()->wallet;

        $p2p_transfer_fee = $strategies->where('name', 'p2p_transfer_fee')->first(null, fn() => new Strategy(['value' => 2.5]));
        $minimum_p2p_transfer_limit = $strategies->where('name', 'minimum_p2p_transfer_limit')->first(null, fn() => new Strategy(['value' => 5]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        return view('backend.user.withdrawals.p2p-transfer', compact('p2p_transfer_fee', 'max_withdraw_limit', 'minimum_p2p_transfer_limit', 'wallet'));
    }

    public function withdraw()
    {
        $profile = Auth::user()->profile;

        if ($profile->wallet_address === null) {
            return redirect()->route('profile.show')->with('warning', 'Please Fill your Account Payment details, before continuing.!');
        }

        $strategies = Strategy::whereIn('name', ['payout_transfer_fee', 'minimum_payout_limit', 'staking_withdrawal_fee', 'daily_max_withdrawal_limits', 'withdrawal_days_of_week'])->get();
        $wallet = Auth::user()->wallet;

        $payout_transfer_fee = $strategies->where('name', 'payout_transfer_fee')->first(null, fn() => new Strategy(['value' => 5]));
        $staking_withdrawal_fee = $strategies->where('name', 'staking_withdrawal_fee')->first(null, fn() => new Strategy(['value' => 5]));
        $minimum_payout_limit = $strategies->where('name', 'minimum_payout_limit')->first(null, fn() => new Strategy(['value' => 10]));
        $max_withdraw_limit = $wallet->withdraw_limit;

        $daily_max_withdrawal_limits = $strategies->where('name', 'daily_max_withdrawal_limits')->first(null, fn() => new Strategy(['value' => 100]));
        $withdrawal_days_of_week = $strategies->where('name', 'withdrawal_days_of_week')->first(null, fn() => new Strategy(['value' => '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]']));
        $withdrawal_days_of_week = json_decode($withdrawal_days_of_week->value, true, 512, JSON_THROW_ON_ERROR);

        $used_withdraw_amount_for_day = Withdraw::where('type', 'MANUAL')
            ->where('user_id', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $remaining_withdraw_amount_for_day = $daily_max_withdrawal_limits->value - $used_withdraw_amount_for_day;

        return view('backend.user.withdrawals.binance-payouts',
            compact(
                'profile',
                'payout_transfer_fee',
                'staking_withdrawal_fee',
                'max_withdraw_limit',
                'minimum_payout_limit',
                'wallet',
                'daily_max_withdrawal_limits',
                'withdrawal_days_of_week',
                'remaining_withdraw_amount_for_day',
            )
        );
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

    public function p2pConfirm(Request $request, Withdraw $p2p)
    {
        $this->authorize('p2pConfirm', $p2p);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'proof_document' => 'required|file:pdf,jpg,jpeg,png',
            ])->validate();

            \DB::transaction(function () use ($validated, $p2p) {
                $file = $validated['proof_document'];
                $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                $file->storeAs('payouts/p2p', $proof_documentation);

                $p2p->update([
                    'proof_document' => $proof_documentation,
                    'approved_at' => \Carbon::now(),
                ]);
            });

            $json['status'] = true;
            $json['message'] = 'P2P Confirmation successful';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('user.transfers.p2p', ['status' => 'success', 'filter' => 'received']);
            $json['data'] = $validated;

            return response()->json($json);
        }
        return view('backend.user.withdrawals.p2p-confirm', compact('p2p'));
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

        $skel = '{"email":"","id":"","address":"","phone":"", "wallet_address_nickname":""}';
        $payout_info = json_decode($withdraw->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required|string'
            ])->validate();

            \DB::transaction(function () use ($withdraw, $validated, $user_wallet, $user) {

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

                if ($withdraw->wallet_type === 'STAKING') {
                    $user_wallet->increment('staking_balance', $total_amount);
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
