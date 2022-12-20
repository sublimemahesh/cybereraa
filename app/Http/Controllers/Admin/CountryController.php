<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{

    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Country::class);
        $countries = Country::latest()->get();
        return view('backend.admin.countries.index', compact('countries'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', Country::class);

        $validated = $request->validate([
            'name' => 'required|max:250',
            'iso' => 'required|max:250|unique:countries,iso',
        ]);

        Country::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Country created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }


    public function edit(Country $country)
    {
        $this->authorize('update', $country);

        return view('backend.admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $this->authorize('update', $country);

        $validated = $request->validate([
            'name' => 'required|max:250',
            'iso' => ['required', 'max:250', Rule::unique('countries', 'iso')->ignore($country->id)],
        ]);

        $country->update($validated);

        $json['status'] = true;
        $json['message'] = 'Country updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        $country->delete();

        $json['status'] = true;
        $json['message'] = 'Country deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $country;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }
}
