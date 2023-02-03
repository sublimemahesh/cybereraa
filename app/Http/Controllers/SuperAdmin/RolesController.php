<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Actions\ActivityLogAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Gate;
use JsonException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('role.manage'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::with(['permissions'])->get();
        return view('backend.super_admin.roles.index', compact('roles'));
    }


    public function create()
    {
        abort_if(Gate::denies('role.manage'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::get();
        return view('backend.super_admin.roles.save', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['guard_name' => 'web', 'name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('super_admin.roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role.manage') || Gate::denies('default.roles.permissions', $role), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::pluck('name', 'id');
        $role->load('permissions');
        return view('backend.super_admin.roles.edit', compact('permissions', 'role'));
    }

    /**
     * @throws JsonException
     */
    public function update(UpdateRoleRequest $request, Role $role, ActivityLogAction $activityLog)
    {
        if (Gate::allows('default.roles.manage', $role)) {
            $role->update(['name' => $request->input('name')]);
        }
        $previousData = [
            'permissions' => $role->permissions,
        ];
        $role->syncPermissions($request->input('permissions', []));
        $newData = [
            'permissions' => $role->permissions,
        ];
        $activityLog->exce('role.manage', $previousData, $newData);
        return redirect()->route('super_admin.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role.manage') || Gate::denies('default.roles.manage', $role), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();
        return redirect()->route('super_admin.roles.index')->with('success', 'Role deleted successfully');
    }

}
