<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;
use Validator;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::latest()->get();
        return view('backend.admin.currencies.index', compact('currencies'));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|max:10|unique:currencies,name',
            'value' => 'required|max:11|regex:/^\d+(\.\d{1,2})?$/',
            'change' => 'required|max:11|regex:/^\d+(\.\d{1,2})?$/',
            'image_name' => 'required|base64image|base64max:1024',
        ])->validate();

        $image_name = store($validated['image_name'], "currencies", $validated['name'] . '-' . Str::random(20) . "-" . Carbon::now()->timestamp);

        $validated['image_name'] = $image_name;


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
            'image_name' => [Rule::requiredIf($currency->image_name === null), 'nullable', 'base64image', 'base64max:1024'],
        ]);

        if (!empty($validated['image_name'])) {
            $image_name = store($validated['image_name'], "currencies", $validated['name'] . '-' . Str::random(20) . "-" . Carbon::now()->timestamp);
            $validated['image_name'] = $image_name;
            if (!empty($currency->image_name)) {
                Storage::delete("currencies/" . $currency->image_name);
            }
        }

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
        Storage::delete("currencies/" . $currency->image_name);

        $json['status'] = true;
        $json['message'] = 'Currency deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $currency;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
