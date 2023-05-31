<?php

namespace App\Http\Controllers\User\Staking;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\PurchasedStakingPlan;
use App\Models\StakingPlan;
use App\Models\User;
use Arr;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use URL;
use Validator;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'staking_plan' => [
                'required',
                Rule::exists('staking_plans', 'id')
            ],
            'method' => ['required', 'in:binance,main,topup,manual'],/**/
            'proof_document' => ['required_if:method,manual', 'nullable', 'file:pdf,jpg,jpeg,png'],
            'purchase_for' => [
                'nullable',
                Rule::exists('users', 'id'),
                function ($attribute, $value, $fail) {
                    $exists = User::where('id', $value)
                        ->where('id', '<>', Auth::user()->id)
                        ->whereRelation('roles', 'name', 'user')
                        ->exists();
                    if (!$exists) {
                        $fail('Selected user invalid or does not allowed to be purchased a package!.');
                    }
                }
            ],
        ])->validate();

        if (!empty($validated['purchase_for'])) {
            $user = User::findOrFail($validated['purchase_for']);
            $purchased_by = Auth::user();
        } else {
            $user = Auth::user();
            $purchased_by = $user;
        }

        $plan = StakingPlan::findOrFail($validated['staking_plan']);

        if (!$plan->package->is_active || !$plan->is_active) {
            $json['status'] = false;
            $json['message'] = "Cannot purchase this package";
            $json['code'] = 422;
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_FORBIDDEN);
        }

        try {
            return DB::transaction(function () use ($plan, $user, $purchased_by, $validated) {

                //$amount = $plan->amount;
                //$gas_fee = $user->purchasedPackages()->count() <= 0 ? $plan->gas_fee : 0;

                $transaction = $plan->transactions()->create([
                    'user_id' => $user->id,
                    'purchaser_id' => $purchased_by->id,
                    'currency' => "USDT",
                    'amount' => $plan->package->amount,
                    'gas_fee' => $plan->package->gas_fee,
                    'type' => in_array(strtolower($validated['method']), ['main', 'topup', 'manual']) ? 'wallet' : 'crypto',
                    'pay_method' => $validated['method'],
                    'package_type' => "STAKING",
                    'status' => "INITIAL",
                ]);

                $transaction_amount = $transaction->amount + $transaction->gas_fee;

                // Order Data
                $data['order_amount'] = $transaction_amount;
                $data['package_id'] = $plan->id;
                $data['goods_name'] = $plan->package->name . ' - ' . $plan->name;
                $data['goods_detail'] = null;
                $data['buyer'] = [
                    "referenceBuyerId" => $user->id,
                    "buyerEmail" => $user->email,
                    "buyerName" => [
                        "firstName" => Arr::first(explode(" ", $user->name)),
                        "lastName" => Arr::last(explode(" ", $user->name))
                    ]
                ];

                if ($transaction->type === 'wallet') { // 'main', 'topup', 'manual'

                    $req_data = [
                        "orderAmount" => $data['order_amount'],
                        "currency" => 'USDT',
                        "goods" => [
                            "referenceGoodsId" => $data['package_id'],
                            "goodsName" => $data['goods_name'],
                            "goodsDetail" => $data['goods_detail'] ?? null
                        ],
                        "buyer" => $data['buyer']
                    ];

                    $res_data = [
                        'bizType' => 'PAY',
                        'data' => '{"productName":"' . $plan->package->name . "-" . $plan->name . '","transactTime":' . (time() * 1000) . ',"totalFee":' . $transaction_amount . ',"currency":"' . $transaction->currency . '"}',
                    ];

                    $transaction->create_order_request = json_encode($req_data, JSON_THROW_ON_ERROR);

                    if (strtolower($transaction->pay_method) === 'main') {
                        $wallet_balance_check = $purchased_by->wallet->balance < $transaction_amount;
                        $withdraw_limit_check = $purchased_by->wallet->withdraw_limit < $transaction_amount;
                        if ($wallet_balance_check || $withdraw_limit_check) {
                            $res_data['bizStatus'] = 'PAY_CLOSED';

                            $transaction->status = 'CANCELED';
                            $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                            $transaction->save();

                            $json['status'] = false;
                            $json['message'] = $wallet_balance_check ? "Not enough funds in wallet to proceed!" : "Withdraw Limit exceeded!";
                            $json['icon'] = 'error'; // warning | info | question | success | error
                            return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                        }
                    }

                    if ($purchased_by->wallet->topup_balance < $transaction_amount && (strtolower($transaction->pay_method) === 'topup')) {
                        $res_data['bizStatus'] = 'PAY_CLOSED';

                        $transaction->status = 'CANCELED';
                        $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = false;
                        $json['message'] = "Not enough funds in topup wallet to proceed!";
                        $json['icon'] = 'error'; // warning | info | question | success | error
                        return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
                    }

                    if (strtolower($transaction->pay_method) === 'manual') {
                        $validated_file = Validator::make(['proof_document' => request()->file('proof_document')], [
                            'proof_document' => 'required|file:pdf,jpg,jpeg,png',
                        ])->validate();
                        $file = $validated_file['proof_document'];
                        $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                        $file->storeAs('user/manual-purchase', $proof_documentation);

                        $res_data['bizStatus'] = 'PAY_PENDING';

                        $transaction->status = 'PENDING';
                        $transaction->proof_document = $proof_documentation;
                        $transaction->status_response = json_encode($res_data, JSON_THROW_ON_ERROR);
                        $transaction->save();

                        $json['status'] = true;
                        $json['message'] = 'Request successful';
                        $json['icon'] = 'success'; // warning | info | question | success | error
                        $json['data'] = ['checkoutUrl' => URL::signedRoute('user.transactions.invoice', $transaction)];
                        return response()->json($json);
                    }

                    DB::transaction(function () use ($transaction, $purchased_by, $transaction_amount) {
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

                        $transaction->adminEarnings()->create([
                            'user_id' => $transaction->user_id,
                            'type' => 'STAKING_GAS_FEE',
                            'amount' => $transaction->gas_fee
                        ]);

                        $admin_wallet = AdminWallet::firstOrCreate(
                            ['wallet_type' => 'STAKING_GAS_FEE'],
                            ['balance' => 0]
                        );

                        $admin_wallet->increment('balance', $transaction->gas_fee);

                        $wallet = $purchased_by->wallet;

                        if (strtolower($transaction->pay_method) === 'main') {
                            $wallet->decrement('balance', $transaction_amount);
                            $wallet->decrement('withdraw_limit', $transaction_amount);
                        }

                        if (strtolower($transaction->pay_method) === 'topup') {
                            $wallet->decrement('topup_balance', $transaction_amount);
                        }

                        $res_data['bizStatus'] = 'PAY_SUCCESS';

                        $transaction->update([
                            'status' => 'PAID',
                            'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                        ]);
                    });

                    $json['status'] = true;
                    $json['message'] = 'Request successful';
                    $json['icon'] = 'success'; // warning | info | question | success | error
                    $json['data'] = ['checkoutUrl' => URL::signedRoute('user.transactions.invoice', $transaction)];
                    return response()->json($json);
                }

                if (strtolower($transaction->pay_method) === 'binance') { // crypto
                    // dd(env("BINANCE_SERVICE_WEBHOOK_URL"));
                    throw new \RuntimeException('Not supported');
                }

                throw new \RuntimeException("Something wrong with your payment method!");
            });
        } catch (Throwable $e) {
            $json['status'] = false;
            $json['message'] = $e->getMessage();
            $json['code'] = $e->getCode();
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_FORBIDDEN);
        }
    }
}
