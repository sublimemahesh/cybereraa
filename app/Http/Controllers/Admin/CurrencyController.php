<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::latest()->get();
        return view('backend.admin.currencies.index', compact('currencies'));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:10|unique:currencies,name',
            'value' => 'required|max:11|regex:/^\d+(\.\d{1,2})?$/',
            'change' => 'required|max:11|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        Currency::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Currency created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function edit(Currency $currency)
    {
        return view('backend.admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, currency $currency)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:10', Rule::unique('currencies', 'name')->ignore($currency->id)],
            'value' => ['required', 'max:11', 'regex:/^\d+(\.\d{1,2})?$/'],
            'change' => ['required', 'max:11', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $currency->update($validated);

        $json['status'] = true;
        $json['message'] = 'Currency updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        $json['status'] = true;
        $json['message'] = 'Currency deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $currency;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
