<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Page;
use App\Models\Strategy;
use App\Models\Transaction;
use App\Services\TransactionService;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;
use Symfony\Component\HttpFoundation\Response;
use URL;
use Validator;

class TransactionController extends Controller
{

    /**
     * @throws Exception
     */
    public function index(Request $request, TransactionService $transaction)
    {
        if ($request->wantsJson()) {
            $request->user_id = null;
            return $transaction->datatable(user_id: Auth::user()->id)
                ->addColumn('action', static function ($trx) {
                    $url = URL::signedRoute('user.transactions.invoice', $trx);
                    $retryBtn = '';
                    if ($trx->type === 'crypto' && $trx->status === 'INITIAL' && !empty($trx->create_order_request_info->orderExpireTime)) {
                        if (!Carbon::createFromTimestamp($trx->create_order_request_info->orderExpireTime / 1000)->isPast()) {
                            $retryURL = route('user.transactions.retry-payment', $trx);
                            $retryBtn = "<div class='py-1'><a href='{$retryURL}' class='dropdown-item'>Pay Now</a></div>";
                        } else {
                            Transaction::find($trx->id)->update(['status' => 'EXPIRED']);
                        }
                    }

                    return '<div class="dropdown">
                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
                                        <div class="py-1">
                                            <a class="dropdown-item" href="' . $url . '">Invoice</a>
                                        </div>
                                        ' . $retryBtn . '
                                    </div>
                                </div>';
                })
                ->rawColumns(['action', 'user', 'purchaser', 'type', 'package'])
                ->make();

        }
        return view('backend.user.transactions.index');
    }

    /**
     * @throws Exception
     */
    public function purchaseHistory(Request $request, TransactionService $transaction)
    {
        if ($request->wantsJson()) {
            $request->purchaser_id = null;
            return $transaction->datatable(user_id: $request->get('user_id'), purchase_id: Auth::user()->id)
                ->addColumn('action', static function ($trx) {
                    $url = URL::signedRoute('user.transactions.invoice', $trx);
                    $actions = '';
                    if ($trx->type === 'crypto' && $trx->status === 'INITIAL' && !empty($trx->create_order_request_info->orderExpireTime)) {
                        if (!Carbon::createFromTimestamp($trx->create_order_request_info->orderExpireTime / 1000)->isPast()) {
//                            $retryURL = route('user.transactions.retry-payment', $trx);
//                            $retryBtn = "<div class='py-1'><a href='{$retryURL}' class='dropdown-item'>Pay Now</a></div>";
                            $actions .= '<a href="' . route('user.transactions.retry-payment', $trx) . '" class="btn btn-xs btn-success sharp my-1 mr-1 shadow">
                                    <i class="fa fa-dollar"></i>
                                </a>';
                        } else {
                            Transaction::find($trx->id)->update(['status' => 'EXPIRED']);
                        }
                    }

                    if (\Gate::allows('editTransaction', $trx)) {
                        $actions .= '<a href="' . route('user.transactions.edit-payment', $trx) . '" class="btn btn-xs btn-warning sharp my-1 mr-1 shadow">
                                    <i class="fa fa-pencil"></i>
                                </a>';
                    }

                    $actions .= '<a href="' . URL::signedRoute('user.transactions.invoice', $trx) . '" class="btn btn-xs btn-info sharp my-1 mr-1 shadow">
                                    <i class="fa fa-file-invoice"></i>
                                </a>';

                    return $actions;
//                    return '<div class="dropdown">
//                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown" aria-expanded="false">
//                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
//                                    </button>
//                                    <div class="dropdown-menu dropdown-menu-end border py-0" style="">
//                                        <div class="py-1">
//                                            <a class="dropdown-item" href="' . $url . '">Invoice</a>
//                                        </div>
//                                        ' . $retryBtn . '
//                                    </div>
//                                </div>';
                })
                ->rawColumns(['action', 'user', 'purchaser', 'type', 'package'])
                ->make();
        }
        return view('backend.user.transactions.purchase-history');
    }

    /**
     * @throws \JsonException
     */
    public function editPayment(Request $request, Transaction $transaction)
    {
        abort_if(\Gate::denies('editTransaction', $transaction), 403);

        $strategies = Strategy::whereIn('name', ['min_custom_investment', 'max_custom_investment', 'custom_investment_gas_fee'])->get();
        $min_custom_investment = $strategies->where('name', 'min_custom_investment')->first(null, fn() => new Strategy(['value' => 10]));
        $max_custom_investment = $strategies->where('name', 'max_custom_investment')->first(null, fn() => new Strategy(['value' => 5000]));
        $custom_investment_gas_fee = $strategies->where('name', 'custom_investment_gas_fee')->first(null, fn() => new Strategy(['value' => 1]));

        if ($request->wantsJson()) {
            $validated = Validator::make($request->all(), [
                'amount' => 'nullable|numeric',
                'proof_document' => 'nullable|file:pdf,jpg,jpeg,png',
                'transaction_id' => ['required', Rule::unique('transactions', 'transaction_id')->ignoreModel($transaction)],
            ])->validate();

            $validated['amount'] = $validated['amount'] ?? $transaction->amount;

            if ($validated['amount'] < $min_custom_investment?->value || $validated['amount'] > $max_custom_investment?->value) {
                $json['status'] = false;
                $json['message'] = "Please select a package amount between USDT: {$min_custom_investment?->value} - {$max_custom_investment?->value}";
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $proof_documentation = $transaction->proof_document;
            if ($request->hasFile('proof_document')) {
                $file = $validated['proof_document'];
                $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName()), 50) . "-" . $file->hashName();
                $file->storeAs('user/manual-purchase', $proof_documentation);
            }

            $res_data = json_decode($transaction->status_response ?? [], true, 512, JSON_THROW_ON_ERROR);
            $res_data['bizStatus'] = 'PAY_PENDING';

            $transaction->update([
                'status' => 'PENDING',
                'amount' => $validated['amount'],
                'gas_fee' => ($validated['amount'] * $custom_investment_gas_fee?->value) / 100,
                'transaction_id' => $validated['transaction_id'],
                'proof_document' => $proof_documentation,
                'repudiate_note' => null,
                'status_response' => json_encode($res_data, JSON_THROW_ON_ERROR),
            ]);

            $json['status'] = true;
            $json['message'] = 'Request updated successful';
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['data'] = ['checkoutUrl' => URL::signedRoute('user.transactions.invoice', $transaction)];
            return response()->json($json);
        }


        $user = Auth::user();
        $purchased_by = $user;

        $package = Package::make(json_decode($transaction->package_info ?? '[]', true, 512, JSON_THROW_ON_ERROR));
        $wallet_page = Page::where('slug', 'deposit-wallet-address')->firstOrNew();
        return view('backend.user.packages.edit-manual-purchase', compact(
            'transaction',
            'package',
            'purchased_by',
            'wallet_page',
            'min_custom_investment',
            'max_custom_investment',
            'custom_investment_gas_fee',
        ));

    }

}
