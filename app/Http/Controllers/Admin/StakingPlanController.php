<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StakingPackage;
use App\Models\StakingPlan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class StakingPlanController extends Controller
{
    /**
     * @throws AuthorizationException
     */

    public function index(StakingPackage $package)
    {
        $this->authorize('viewAny', StakingPlan::class);
        $plans = $package->plans;
        return view('backend.admin.staking-package.plans.index', compact('plans', 'package'));
    }

    public function fetchPlans(StakingPackage $package): JsonResponse
    {
        $plans = $package->plans;
        $json['status'] = true;
        $json['message'] = 'Successfully fetched!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $plans;
        return response()->json($json);
    }

    /**
     * @throws AuthorizationException
     */

    public function store(Request $request, StakingPackage $package): JsonResponse
    {
        $this->authorize('create', StakingPlan::class);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => ['required', 'max:250', Rule::unique('staking_plans', 'name')->where('staking_package_id', $package->id)],
            'duration' => 'required|integer',
            'interest_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ])->validate();

        $validated['staking_package_id'] = $package->id;
        StakingPlan::create($validated);

        $json['status'] = true;
        $json['message'] = 'New Staking Package created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);

    }

    public function edit(StakingPlan $plan)
    {
        $this->authorize('update', $plan);
        $package = $plan->package;
        return view('backend.admin.staking-package.plans.edit', compact('plan', 'package'));
    }


    public function update(Request $request, StakingPlan $plan)
    {
        $this->authorize('update', $plan);

        $data = $request->all();
        $data['is_active'] = $request->get('is_active') === 'on';

        $validated = Validator::make($data, [
            'name' => ['required', 'max:250', Rule::unique('staking_plans', 'name')->where('staking_package_id', $plan->staking_package_id)->ignore($plan->id)],
            'duration' => 'required|integer',
            'interest_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ])->validate();

        $plan->update($validated);

        $json['status'] = true;
        $json['message'] = 'Package updated successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function destroy(StakingPlan $plan)
    {
        $this->authorize('delete', $plan);

        $plan->delete();

        $json['status'] = true;
        $json['message'] = 'Staking Package deleted successfully';
        $json['icon'] = 'success';
        $json['data'] = $plan;
        session()->flash('info', $json['message']);
        return response()->json($json);
    }

    public function sort(StakingPackage $package)
    {
        $this->authorize('update', StakingPlan::class);
        $plans = $package->plans;
        return view('backend.admin.staking-package.plans.arrange', compact('package', 'plans'));
    }

    public function storeSort(Request $request)
    {
        $this->authorize('update', StakingPlan::class);
        if ($request->has('ids')) {
            foreach ($request->get('ids') as $sortOrder => $id) {
                StakingPlan::find($id)->update([
                    "order" => $sortOrder
                ]);
            }
            return ['status' => true, 'message' => 'Arrange success', "icon" => 'success'];
        }
        return response()->json(['status' => false, 'message' => 'Something went wrong', "icon" => 'danger']);
    }

}
