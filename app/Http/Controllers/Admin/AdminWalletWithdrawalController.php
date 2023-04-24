<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\AdminWalletWithdrawal;
use App\Services\TwoFactorAuthenticateService;
use Auth;
use DB;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminWalletWithdrawalController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_wallet_withdrawal.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {

            $withdrawal = AdminWalletWithdrawal::with('user')
                ->filter()
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                });

            return DataTables::eloquent($withdrawal)
                ->addColumn('user', static function ($withdrawal) {
                    return str_pad($withdrawal->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$withdrawal->user->username}</code>";
                })
                ->addColumn('proof', static function ($withdrawal) {
                    return "<a href='" . storage('admin-wallets/' . $withdrawal->proof_document) . "' target='_blank' class='btn btn-info shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-check-to-slot'></i>
                            </a>";
                })
                ->addColumn('remark', static function ($withdrawal) {
                    if ($withdrawal->remark) {
                        return "<span title='{$withdrawal->remark}'>" . Str::limit($withdrawal->remark, 15) . "</span>";
                    }
                    return null;
                })
                ->addColumn('date', fn($withdrawal) => $withdrawal->created_at->format('Y-m-d H:i:s'))
                ->addColumn('amount', fn($withdrawal) => number_format($withdrawal->amount, 2))
                ->rawColumns(['user', 'proof', 'remark'])
                ->make();

        }
        return view('backend.admin.admin-wallets.withdrawal');
    }

    /**
     * @throws Throwable
     */
    public function withdraw(Request $request, AdminWallet $wallet, TwoFactorAuthenticateService $authenticateService)
    {
        abort_if(Gate::denies('admin_wallet_withdrawal.create'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson() && $request->isMethod('post')) {
            return $this->confirmWithdraw($request, $wallet, $authenticateService);
        }
        return view('backend.admin.admin-wallets.withdraw', compact('wallet'));
    }


    /**
     * @throws Throwable
     */
    private function confirmWithdraw(Request $request, AdminWallet $wallet, TwoFactorAuthenticateService $authenticateService): \Illuminate\Http\JsonResponse
    {
        $admin = Auth::user();

        $validated = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'proof_document' => ['required', 'file'],
            'remark' => ['nullable', 'string', 'max:250'],
            'password' => 'required',
            'code' => 'nullable',
        ])->validate();

        if (!$authenticateService->checkPassword($admin, $validated['password'] ?? null)) {
            $json['status'] = false;
            $json['message'] = 'Password is incorrect';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if ($authenticateService->isTwoFactorEnabled($admin)) {

            if ($validated['code'] === null) {
                $json['status'] = false;
                $json['message'] = 'The two factor authentication code is required.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            if (!$authenticateService->checkTwoFactor($admin, $validated['code'])) {
                $json['status'] = false;
                $json['message'] = 'The provided two factor authentication code was invalid.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }
        }

        if ($wallet->balance < $validated['amount']) {
            $json['status'] = false;
            $json['message'] = "Not enough funds in wallet to proceed!";
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        DB::transaction(static function () use ($validated, $admin, $wallet) {

            $file = $validated['proof_document'];
            $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName())) . "-" . $file->hashName();
            $file->storeAs('admin-wallets', $proof_documentation);

            $profit_withdraw = AdminWalletWithdrawal::create([
                'user_id' => $admin->id,
                'amount' => $validated['amount'],
                'type' => $wallet->wallet_type,
                'proof_document' => $proof_documentation,
                'remark' => $validated['remark'],
            ]);

            $wallet->decrement('balance', $profit_withdraw->amount);

            return $profit_withdraw;
        });

        $json['status'] = true;
        $json['message'] = "Withdrawal successful!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = null;
        return response()->json($json, Response::HTTP_OK);
    }
}
