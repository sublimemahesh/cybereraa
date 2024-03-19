<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ActivateTransaction;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class InvestmentPurchaseController extends Controller
{

    public function customInvestments(Request $request, ActivateTransaction $activateTransaction)
    {
        abort_if(\Gate::denies('users.custom-package.purchase'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')],
                'amount' => 'required|numeric'
            ], [
                'user_id.required' => 'The User field is required.',
                'user_id.exists' => 'The selected User is invalid.',
            ]);

            $transaction = \DB::transaction(function () use ($activateTransaction, $request) {

                $user = User::find($request->get('user_id'));
                $purchased_by = \Auth::user();

                $package = new Package([
                    'name' => 'Custom',
                    'slug' => 'custom',
                    'currency' => 'USDT',
                    'amount' => $request->get('amount'),
                    'gas_fee' => 0,
                    'month_of_period' => 30,
                    'daily_leverage' => 1,
                    'is_free_package' => 0,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $req_data = [
                    "orderAmount" => $package->amount,
                    "currency" => 'USDT',
                    "goods" => [
                        "referenceGoodsId" => $package->id,
                        "goodsName" => $package->name,
                        "goodsDetail" => null
                    ],
                    "buyer" => [
                        "referenceBuyerId" => $user->id,
                        "buyerEmail" => $user->email,
                        "buyerName" => [
                            "firstName" => Arr::first(explode(" ", $user->name)),
                            "lastName" => Arr::last(explode(" ", $user->name))
                        ]
                    ]
                ];

                $res_data = [
                    'bizStatus' => 'PAY_PENDING',
                    'bizType' => 'PAY',
                    'data' => '{"productName":"' . $package->name . '","transactTime":' . (time() * 1000) . ',"totalFee":' . $package->amount . ',"currency": "USDT"}',
                ];

                $transaction = Transaction::updateOrCreate([
                    'transaction_id' => "custom-amount-Transaction-{$user->username}-" . \Carbon::now()->timestamp,
                    'user_id' => $user->id,
                    'purchaser_id' => $purchased_by?->id,
                    'package_id' => $package->id,
                    'package_info' => $package->toJson(),
                    'currency' => "USDT",
                    'amount' => $package->amount,
                    'gas_fee' => $package->gas_fee,
                    'type' => 'wallet',
                    'pay_method' => 'MANUAL',
                    'status' => "PENDING",
                    'package_type' => 'PACKAGE',
                    'proof_document' => 'admin-purchase-package.jpg',
                    'create_order_request' => json_encode($req_data, JSON_THROW_ON_ERROR),
                    'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                ]);


                if ($transaction->package_type === 'PACKAGE') {
                    $res = $activateTransaction->execute($transaction);
                    $res_data = json_decode($transaction->status_response ?? [], true, 512, JSON_THROW_ON_ERROR);
                    $res_data['bizStatus'] = 'PAY_SUCCESS';

                    $transaction->update([
                        'status' => 'PAID',
                        'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
                    ]);
                }
            });

            $json['status'] = true;
            $json['message'] = 'Package is activated successfully';
            $json['icon'] = 'success';
            return response()->json($json);

        }
        return view('backend.admin.users.custom-package');
    }

}
