<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendPayoutConfirmationMail;
use App\Mail\SendPayoutRejectMail;
use App\Models\AdminWallet;
use App\Models\Withdraw;
use App\Services\TwoFactorAuthenticateService;
use App\Services\WithdrawService;
use Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Mail;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

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
                        " - <a href='" . route('admin.users.profile.show', $withdraw->user) . "' target='_blank'>
                                    <code class='text-uppercase'>{$withdraw->user->username}</code>
                                </a>";
                })->addColumn('receiver', static function ($withdraw) {
                    return str_pad($withdraw->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <a href='" . route('admin.users.profile.show', $withdraw->receiver) . "' target='_blank'>
                                    <code class='text-uppercase'>{$withdraw->receiver->username}</code>
                          </a>";
                })
                ->rawColumns(['type', 'sender', 'receiver'])
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
            $withdrawals = $withdrawService->filter(request()->input('user_id'))
                ->where('type', 'MANUAL')
                ->when($request->routeIs('admin.staking.transfers.withdrawals'), function (Builder $query) {
                    $query->where('wallet_type', 'STAKING');
                })
                ->when(!$request->routeIs('admin.staking.transfers.withdrawals'), function (Builder $query) {
                    $query->where('wallet_type', '<>', 'STAKING');
                });

            return $withdrawService->datatable($withdrawals)
                ->addColumn('user', static function ($withdraw) {
                    return str_pad($withdraw->user_id, '4', '0', STR_PAD_LEFT) .
                        "<br><code class='text-uppercase' style='font-size:0.7rem'>{$withdraw->user->username}</code>";
                })
                ->addColumn('type_n_wallet', function ($withdraw) {
                    return "Type: <code class='text-uppercase'>{$withdraw->type}</code> <br>
                            Wallet: <code class='text-uppercase'>{$withdraw->wallet_type}</code>";
                })
                ->addColumn('wallet_address', function ($withdraw) {
                    $skeleton = '{"email":"","id":"","address":"","phone":""}';
                    $payout_info = json_decode($withdraw?->payout_details ?? $skeleton, false, 512, JSON_THROW_ON_ERROR);
                    return $payout_info->address;
                })
                ->addColumn('actions', static function ($withdraw) {
                    // withdraw.approve | withdraw.reject
                    $actions = '';
                    if (Gate::allows('view', $withdraw)) {
                        $actions .= '<a href="' . route('admin.transfers.withdrawals.view', $withdraw) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-eye"></i>
                                </a>';
                    }
                    if (Gate::allows('processWithdraw', $withdraw)) {
                        $actions .= '<a href="javascript:void(0)" data-id="' . $withdraw->id . '" class="btn btn-xs btn-google sharp process-withdraw my-1 mr-1 shadow">
                                    <i class="fa fa-history"></i>
                                </a>';
                    }
                    if (Gate::allows('approveWithdraw', $withdraw)) {
                        $actions .= '<a href="' . route('admin.transfers.withdrawals.approve', $withdraw) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-check-double"></i>
                                </a>';
                    }
                    if (Gate::allows('rejectWithdraw', $withdraw)) {
                        $actions .= '<a href="' . route('admin.transfers.withdrawals.reject', $withdraw) . '" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
                                    <i class="fa fa-ban"></i>
                                </a>';
                    }
                    return $actions;
                })
                ->rawColumns(['user', 'actions', 'type_n_wallet'])
                ->make();
        }

        return view('backend.admin.users.transfers.binance-withdraw');
    }

    /**
     * @throws AuthorizationException
     * @throws JsonException
     */
    public function show(Request $request, Withdraw $withdraw)
    {
        $this->authorize('viewAny', $withdraw);
        $skel = '{"email":"","id":"","address":"","phone":""}';
        $payout_info = json_decode($withdraw?->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);
        return view('backend.admin.users.transfers.withdraw-summery', compact('withdraw', 'payout_info'));
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function process(Request $request, Withdraw $withdraw)
    {
        $this->authorize('processWithdraw', $withdraw);

        \DB::transaction(function () use ($withdraw) {
            $withdraw->update([
                'status' => 'PROCESSING',
                'processed_at' => \Carbon::now(),
            ]);
            // TODO: SEND MAIL
        });

        $json['status'] = true;
        $json['message'] = 'Payout Processed';
        $json['icon'] = 'success'; // warning | info | question | success | error

        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     * @throws JsonException
     * @throws Throwable
     */
    public function approve(Request $request, Withdraw $withdraw, TwoFactorAuthenticateService $authenticateService)
    {
        $this->authorize('approveWithdraw', $withdraw);

        $skel = '{"email":"","id":"","address":"","phone":""}';
        $payout_info = json_decode($withdraw->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'proof_document' => 'required|file:pdf,jpg,jpeg,png',
                'password' => 'required',
                'code' => 'nullable'
            ])->validate();

            $user = \Auth::user();

            if (!$authenticateService->checkPassword($user, $validated['password'] ?? null)) {
                $json['status'] = false;
                $json['message'] = 'Password is incorrect';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if ($authenticateService->isTwoFactorEnabled($user)) {

                if ($validated['code'] === null) {
                    $json['status'] = false;
                    $json['message'] = 'The two factor authentication code is required.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }

                if (!$authenticateService->checkTwoFactor($user, $validated['code'])) {
                    $json['status'] = false;
                    $json['message'] = 'The provided two factor authentication code is invalid.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }
            }

            \DB::transaction(function () use ($validated, $withdraw, $payout_info) {
                $file = $validated['proof_document'];
                $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                $file->storeAs('payouts/manual', $proof_documentation);

                $withdraw->update([
                    'status' => 'SUCCESS',
                    'proof_document' => $proof_documentation,
                    'approved_at' => \Carbon::now(),
                ]);

                if ($withdraw->processed_at === null) {
                    $withdraw->update([
                        'processed_at' => \Carbon::now(),
                    ]);
                }

                $admin_wallet_type = $withdraw->wallet_type === 'STAKING' ? 'STAKING_WITHDRAWAL_FEE' : 'WITHDRAWAL_FEE';

                $withdraw->adminEarnings()->create([
                    'user_id' => $withdraw->user_id,
                    'type' => $admin_wallet_type,
                    'amount' => $withdraw->transaction_fee,
                ]);

                $admin_wallet = AdminWallet::firstOrCreate(
                    ['wallet_type' => $admin_wallet_type],
                    ['balance' => 0]
                );

                $admin_wallet->increment('balance', $withdraw->transaction_fee);

                Mail::to($withdraw->user->email)
                    ->cc($payout_info?->email)
                    ->send(new SendPayoutConfirmationMail($withdraw));
            });

            $json['status'] = true;
            $json['message'] = 'Payout successful';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.transfers.withdrawals.view', $withdraw);
            $json['data'] = $validated;

            return response()->json($json);
        }

        return view('backend.admin.users.transfers.withdraw', compact('withdraw', 'payout_info'));

    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     * @throws JsonException
     */
    public function rejectWithdraw(Request $request, Withdraw $withdraw)
    {
        $this->authorize('rejectWithdraw', $withdraw);

        $user = $withdraw->user;
        $user_wallet = $user?->wallet;
        $profile = $user?->profile;

        $skel = '{"email":"","id":"","address":"","phone":""}';
        $payout_info = json_decode($withdraw->payout_details ?? $skel, false, 512, JSON_THROW_ON_ERROR);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required|string'
            ])->validate();

            \DB::transaction(function () use ($withdraw, $user_wallet, $user, $validated, $payout_info) {

                $total_amount = $withdraw->amount + $withdraw->transaction_fee;

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

                $withdraw->update([
                    'status' => 'REJECT',
                    'repudiate_note' => $validated['repudiate_note'] ?? null,
                    'rejected_at' => \Carbon::now(),
                ]);

                Mail::to($withdraw->user->email)
                    ->cc($payout_info?->email)
                    ->send(new SendPayoutRejectMail($withdraw));
            });

            $json['status'] = true;
            $json['message'] = 'Payout Rejected!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.transfers.withdrawals.view', $withdraw);
            $json['data'] = $validated;

            return response()->json($json);
        }

        return view('backend.admin.users.transfers.reject-payouts', compact('withdraw', 'payout_info', 'profile'));
    }
}
