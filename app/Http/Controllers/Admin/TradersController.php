<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class TradersController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Trader::class);
        $traders = Trader::latest()->get();
        return view('backend.admin.traders.index', compact('traders'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', Trader::class);

        $data = $request->all();

        $validated = Validator::make($data, [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250|unique:traders',
            'phone' => 'required|max:12',
        ])->validate();

        Trader::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Trader created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }


    public function edit(Trader $trader)
    {
        $this->authorize('update', $trader);

        return view('backend.admin.traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $trader);

        $data = $request->all();

        $validated = Validator::make($data, [
            'name' => ['required', 'max:250'],
            'email' => ['required', 'max:250', 'email', Rule::unique('traders', 'email')->ignore($trader->id)],
            'phone' => 'required|max:12',
        ])->validate();

        $trader->update($validated);

        $json['status'] = true;
        $json['message'] = 'Trader updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(Trader $trader): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $trader);

        $trader->delete();

        $json['status'] = true;
        $json['message'] = 'Trader deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $trader;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
