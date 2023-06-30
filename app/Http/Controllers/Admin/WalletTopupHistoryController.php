<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Earning;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTopupHistory;
use App\Services\TwoFactorAuthenticateService;
use App\Services\WalletTopupHistoryService;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

class WalletTopupHistoryController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.users.wallets.topup');
    }

    /**
     * @throws Exception
     */
    public function history(Request $request, WalletTopupHistoryService $topupHistoryService)
    {
        abort_if(Gate::denies('wallet.topup-history.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {
            return $topupHistoryService->datatable($request->get('sender_id'), $request->get('user_id'))
                ->addColumn('actions', function ($topup) {
                    $actions = "<a href='" . storage('wallets/topup/' . $topup->proof_documentation) . "' target='_blank' title='View proof' class='btn btn-info shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-check-to-slot'></i>
                            </a>";
                    if (Gate::allows('confirmRequest', $topup)) {
                        $actions .= "<a href='" . route('admin.wallet.topup.confirm-requests', $topup) . "'  title='Confirm the request' class='btn btn-success shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-check-double'></i>
                            </a>";
                    }

                    return $actions;
                })
                ->rawColumns(['actions', 'sender', 'receiver', 'proof', 'remark'])
                ->make();
        }
        return view('backend.admin.users.wallets.history');
    }

    /**
     * @throws Throwable
     */
    public function topup(Request $request, TwoFactorAuthenticateService $authenticateService): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);

        $sender = Auth::user();
        $validated = Validator::make($request->all(), [
            'receiver' => 'required|exists:users,id',
            'amount' => ['required', 'numeric'],
            'proof_documentation' => ['required', 'file'],
            'remark' => ['nullable', 'string', 'max:250'],
            'password' => 'required',
            'code' => 'nullable',
        ])->validate();

        if (!$authenticateService->checkPassword($sender, $validated['password'] ?? null)) {
            $json['status'] = false;
            $json['message'] = 'Password is incorrect';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if ($authenticateService->isTwoFactorEnabled($sender)) {

            if ($validated['code'] === null) {
                $json['status'] = false;
                $json['message'] = 'The two factor authentication code is required.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if (!$authenticateService->checkTwoFactor($sender, $validated['code'])) {
                $json['status'] = false;
                $json['message'] = 'The provided two factor authentication code was invalid.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
        }

        $receiver = User::find($validated['receiver']);
        DB::transaction(static function () use ($validated, $sender, $receiver) {

            $file = $validated['proof_documentation'];
            $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName())) . "-" . $file->hashName();
            $file->storeAs('wallets/topup', $proof_documentation);

            $topup = WalletTopupHistory::create([
                'user_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $validated['amount'],
                'proof_documentation' => $proof_documentation,
                'remark' => $validated['remark'],
            ]);

            $topup->earnings()->save(Earning::forceCreate([
                'user_id' => $receiver->id,
                'currency' => 'USDT',
                'amount' => $topup->amount,
                'type' => 'P2P',
                'status' => 'RECEIVED'
            ]));

            $receiver_wallet = Wallet::firstOrCreate(
                ['user_id' => $receiver->id],
                ['topup_balance' => 0, 'withdraw_limit' => 0]
            );

            $receiver_wallet->increment('topup_balance', $topup->amount);

            return $topup;
        });

        $json['status'] = true;
        $json['message'] = "Topup is successful!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = null;
        return response()->json($json, Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function confirmTopupRequest(Request $request, WalletTopupHistory $topupHistory, TwoFactorAuthenticateService $authenticateService)
    {
        abort_if(Gate::denies('confirmRequest', $topupHistory), Response::HTTP_FORBIDDEN);

        if ($request->isMethod('post')) {

            $sender = Auth::user();
            $validated = Validator::make($request->all(), [
                //            'status' => ['required', 'in:success,rejected'],
                'password' => 'required',
                'code' => 'nullable',
            ])->validate();

            if (!$authenticateService->checkPassword($sender, $validated['password'] ?? null)) {
                $json['status'] = false;
                $json['message'] = 'Password is incorrect';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if ($authenticateService->isTwoFactorEnabled($sender)) {

                if ($validated['code'] === null) {
                    $json['status'] = false;
                    $json['message'] = 'The two factor authentication code is required.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }

                if (!$authenticateService->checkTwoFactor($sender, $validated['code'])) {
                    $json['status'] = false;
                    $json['message'] = 'The provided two factor authentication code was invalid.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }
            }

            DB::transaction(static function () use ($topupHistory, $sender) {

                $topupHistory->update([
                    'user_id' => $sender->id,
                    'status' => 'SUCCESS',
                ]);

                $topupHistory->earnings()->save(Earning::forceCreate([
                    'user_id' => $topupHistory->receiver_id,
                    'currency' => 'USDT',
                    'amount' => $topupHistory->amount,
                    'type' => 'P2P',
                    'status' => 'RECEIVED'
                ]));

                $receiver_wallet = Wallet::firstOrCreate(
                    ['user_id' => $topupHistory->receiver->id],
                    ['topup_balance' => 0, 'withdraw_limit' => 0]
                );

                $receiver_wallet->increment('topup_balance', $topupHistory->amount);

                return $topupHistory;
            });

            $json['status'] = true;
            $json['message'] = "Topup request confirm is successful!";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.wallet.topup.history');
            return response()->json($json, Response::HTTP_OK);
        }

        return view('backend.admin.users.wallets.confirm-topup-request', compact('topupHistory'));
    }

    public function findUsers($search_text): AnonymousResourceCollection
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            ->whereRelation('roles', 'name', 'user')
            ->get();
        return Select2UserResource::collection($users);
    }
}
