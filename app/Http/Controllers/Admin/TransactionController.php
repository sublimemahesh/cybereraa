<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ActivateTransaction;
use App\Http\Controllers\Controller;
use App\Models\PurchasedStakingPlan;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Services\TwoFactorAuthenticateService;
use Auth;
use Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;

class TransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, TransactionService $transaction)
    {
        abort_if(Gate::denies('transactions.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->routeIs('admin.staking.transactions.index')) {
            $request->merge(['product-type' => 'staking']);
        }
        if ($request->wantsJson()) {
            return $transaction->datatable($request->input('user_id'))
                ->addColumn('actions', static function ($trx) {
                    $actions = '';
                    if (Gate::allows('viewSummary', $trx)) {
                        $actions .= '<a href="' . route('admin.transactions.summery', $trx) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-eye"></i>
                                </a>';
                    }
                    if (Gate::allows('approve', $trx)) {
                        $actions .= '<a href="' . route('admin.transactions.approve', $trx) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-check-double"></i>
                                </a>';
                    }
                    if (Gate::allows('reject', $trx)) {
                        $actions .= '<a href="' . route('admin.transactions.reject', $trx) . '" class="btn btn-xs btn-danger sharp my-1 mr-1 shadow">
                                    <i class="fa fa-ban"></i>
                                </a>';
                    }
                    return $actions;
                })
                ->rawColumns(['actions', 'user', 'purchaser', 'type'])
                ->make(true);
        }
        return view('backend.admin.users.transactions.index');
    }

    public function summery(Request $request, Transaction $transaction)
    {
        abort_if(Gate::denies('transactions.viewAny'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.users.transactions.summery', compact('transaction'));
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function approve(Request $request, Transaction $transaction, TwoFactorAuthenticateService $authenticateService, ActivateTransaction $activateTransaction)
    {
        $this->authorize('approve', $transaction);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'password' => 'required',
                'code' => 'nullable'
            ])->validate();

            $user = Auth::user();

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

            \DB::transaction(function () use ($transaction, $activateTransaction) {
                if ($transaction->package_type === 'PACKAGE') {
                    $res = $activateTransaction->execute($transaction);
                }
                if ($transaction->package_type === 'STAKING') {
                    $transaction->product->load('package');
                    PurchasedStakingPlan::updateOrCreate(
                        ['transaction_id' => $transaction->id],
                        [
                            'user_id' => $transaction->user_id,
                            'purchaser_id' => $transaction->purchaser_id,
                            'staking_plan_id' => $transaction->product->id,
                            'invested_amount' => $transaction->amount,
                            'interest_rate' => $transaction->product->interest_rate,
                            'status' => 'ACTIVE',
                            'maturity_date' => Carbon::now()->addDays($transaction->product->duration)->format('Y-m-d H:i:s'),
                            'package_info' => $transaction->product->toJson(),
                        ]
                    );
                }

                $res_data = json_decode($transaction->status_response ?? [], true, 512, JSON_THROW_ON_ERROR);
                $res_data['bizStatus'] = 'PAY_SUCCESS';

                $transaction->update([
                    'status' => 'PAID',
                    'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                ]);
            });

            $json['status'] = true;
            $json['message'] = 'Transaction approved!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.transactions.summery', $transaction);
            return response()->json($json);
        }

        return view('backend.admin.users.transactions.approve-manual', compact('transaction'));
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function reject(Request $request, Transaction $transaction, TwoFactorAuthenticateService $authenticateService)
    {
        $this->authorize('approve', $transaction);

        if ($request->wantsJson() && $request->isMethod('post')) {

            $validated = Validator::make($request->all(), [
                'repudiate_note' => 'required',
                'password' => 'required',
                'code' => 'nullable'
            ])->validate();

            $user = Auth::user();

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

            $res_data = json_decode($transaction->status_response ?? [], true, 512, JSON_THROW_ON_ERROR);
            $res_data['bizStatus'] = 'PAY_CLOSED';

            $transaction->status = 'REJECTED';
            $transaction->repudiate_note = $validated['repudiate_note'];
            $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
            $transaction->save();

            $json['status'] = true;
            $json['message'] = 'Transaction declined!';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = route('admin.transactions.summery', $transaction);
            return response()->json($json);
        }

        return view('backend.admin.users.transactions.reject-manual-transaction', compact('transaction',));
    }

}
