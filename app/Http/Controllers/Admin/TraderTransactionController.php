<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use App\Models\TraderTransaction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Validator;

class TraderTransactionController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Trader $trader)
    {
        $this->authorize('viewAny', TraderTransaction::class);
        $transactions = $trader->traderTransactions;
        return view('backend.admin.traders.transactions.index', compact('trader', 'transactions'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request, Trader $trader): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', TraderTransaction::class);

        $data = $request->all();

        $validated = Validator::make($data, [
            'out_usdt' => 'required|numeric',
            'usdt_out_time' => 'required|date',
            'in_usdt' => 'nullable|numeric',
            'usdt_in_time' => 'nullable|required_with:in_usdt|date',
            'reference' => 'nullable|max:250',
        ])->validate();

        $validated['admin_id'] = \Auth::user()->id;
        $trader->traderTransactions()->save(TraderTransaction::create($validated));

        $json['status'] = true;
        $json['message'] = 'New TraderTransaction created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }


    public function edit(TraderTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        return view('backend.admin.traders.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, TraderTransaction $transaction): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $transaction);

        $data = $request->all();

        $validated = Validator::make($data, [
            'out_usdt' => 'required|numeric',
            'usdt_out_time' => 'required|date',
            'in_usdt' => 'required|numeric',
            'usdt_in_time' => 'required|date',
            'reference' => 'nullable|max:250',
        ])->validate();

        $transaction->update($validated);

        $json['status'] = true;
        $json['message'] = 'Trader Transaction updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(TraderTransaction $transaction): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        $json['status'] = true;
        $json['message'] = 'Trader Transaction deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $transaction;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
