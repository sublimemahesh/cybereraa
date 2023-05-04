<?php

namespace App\Http\Controllers\Admin\Staking;

use App\Http\Controllers\Controller;
use App\Models\StakingPackage;
use App\Models\StakingPlan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class StakingPackageController extends Controller
{

    /**
     * @throws AuthorizationException
     */

    public function index()
    {
        $this->authorize('viewAny', StakingPackage::class);
        $packages = StakingPackage::latest()->get();
        return view('backend.admin.staking-package.index', compact('packages'));
    }

    /**
     * @throws AuthorizationException
     */

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', StakingPackage::class);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => 'required|max:250|unique:staking_packages,name',
            'amount' => 'required|numeric|min:0',
            'gas_fee' => 'nullable|numeric|min:0',
            'description' => 'required|string|max:250',
            'is_active' => 'boolean',
        ])->validate();

        StakingPackage::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Staking Package created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }

    public function edit(StakingPackage $StakingPackage)
    {
        $this->authorize('update', $StakingPackage);

        return view('backend.admin.staking-package.edit', compact('StakingPackage'));
    }


    public function update(Request $request, StakingPackage $StakingPackage)
    {
        $this->authorize('update', $StakingPackage);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => ['required', 'max:250', Rule::unique('staking_packages', 'name')->ignore($StakingPackage->id)],
            'amount' => 'required|numeric|min:0',
            'gas_fee' => 'nullable|numeric|min:0',
            'description' => 'required|string|max:250',
            'is_active' => 'boolean',
        ])->validate();

        $StakingPackage->update($validated);

        $json['status'] = true;
        $json['message'] = 'Package updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(StakingPackage $StakingPackage)
    {
        $this->authorize('delete', $StakingPackage);

        $StakingPackage->delete();

        $json['status'] = true;
        $json['message'] = 'Staking Package deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $StakingPackage;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function sort()
    {
        $this->authorize('update', StakingPackage::class);
        $packages = StakingPackage::orderBy('order')->get();
        return view('backend.admin.staking-package.arrange', compact('packages'));
    }

    public function storeSort(Request $request)
    {
        $this->authorize('update', StakingPackage::class);
        if ($request->has('ids')) {
            foreach ($request->get('ids') as $sortOrder => $id) {
                StakingPackage::find($id)->update([
                    "order" => $sortOrder
                ]);
            }
            return ['status' => true, 'message' => 'Arrange success', "icon" => 'success'];
        }
        return response()->json(['status' => false, 'message' => 'Something went wrong', "icon" => 'danger']);
    }


}
