<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('permission.manage'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::orderBy('name')->get();
        return view('backend.super_admin.permissions.index', compact('permissions'));
    }



}
