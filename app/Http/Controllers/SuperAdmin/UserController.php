<?php

namespace App\Http\Controllers\SuperAdmin;
//namespace App\Actions\Fortify;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Team;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('users.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {
            $users = User::with('roles')
                ->whereRelation('roles', 'name', '<>', 'user')
                ->orWhereDoesntHave('roles');
            return DataTables::eloquent($users)
                ->addColumn('roles', function ($user) {
                    $roles = '';
                    foreach ($user->roles as $key => $item) {
                        $roles .= '<span class="label label-success my-2"> ' . $item->name . ' </span>';
                    }
                    return $roles;
                })
                ->addColumn('actions', function ($user) {
                    return view('backend.super_admin.users.includes.actions', compact('user'))->render();
                })
                ->rawColumns(['actions', 'roles'])
                ->make();
        }
        return view('backend.super_admin.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('users.add-new'), Response::HTTP_FORBIDDEN);
        $roles = Role::where('name', '<>', 'user')->pluck('name', 'id')->all();
        $countries = Country::orderBy('name')->get(['name', 'iso', 'id'])->keyBy('iso');
        return view('backend.super_admin.users.create', compact('roles', 'countries'));
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('users.add-new'), Response::HTTP_FORBIDDEN);
        $input = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username' => ['required', 'unique:users,username', 'string', 'max:255', 'regex:/^[a-z0-9A-Z-_]+$/'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'exists:roles,id'],
            // Profile
            'country_id' => ['nullable', 'exists:countries,id', 'max:255'],
        ]);

        $user = DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {
                $user->profile()->save(Profile::forceCreate([
                    "country_id" => $input['country_id'] ?? null,
                ]));
                $user->assignRole($input['role']);

                $user->ownedTeams()->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $user->name, 2)[0] . "'s Team",
                    'personal_team' => true,
                ]));
            });
        });

        // TODO: Send Email with username and password
        event(new Registered($user));

        return redirect()->route('super_admin.users.index')->with('success', 'User created successfully');

    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);

        $countries = Country::orderBy('name')->get(['name', 'iso', 'id'])->keyBy('iso');

        return view('backend.super_admin.users.edit', compact('user', 'countries'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);
        $input = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'string', 'max:255'],
            // Profile
            'country_id' => ['nullable', 'exists:countries,id', 'max:255'],
        ]);

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'email_verified_at' => null,
            ])->save();

            $user->sendEmailVerificationNotification();
        }

        if ($input['phone'] !== $user->phone) {
            $user->forceFill([
                'name' => $input['name'],
                'phone' => $input['phone'],
                'phone_verified_at' => null,
            ])->save();
        }

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
        ])->save();

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ["country_id" => $input['country_id'] ?? null,]
        );

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('users.delete'), Response::HTTP_FORBIDDEN);
        if ($user->purchasedPackages()->count() > 0) {
            return redirect()->back()->with('success', 'Cannot delete users that have already been purchased a package');
        }
        $user->delete();
        return redirect()->route('super_admin.users.index')->with('success', 'Role deleted successfully');
    }

    public function changePassword(User $user)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);
        return view('backend.super_admin.users.change-password', compact('user'));
    }

    public function savePassword(User $user, Request $request)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);

        $validated = Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return redirect()->route('super_admin.users.index')->with('success', 'Password changed successfully');
    }


    public function showPermissions(User $user)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);

        $directPermissionsNames = $user->getPermissionNames();
        $user->load('roles.permissions');

        return view('backend.super_admin.users.show', compact('directPermissionsNames', 'user'));
    }


    public function managePermissions(User $user)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);
        $user->load('permissions', 'roles');
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::where('name', '<>', 'user')->pluck('name', 'id');
        return view('backend.super_admin.users.manage', compact('roles', 'permissions', 'user'));
    }

    public function savePermissions(Request $request, User $user)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);
        $input = $this->validate($request, [
            'permissions.*' => 'integer',
            'permissions' => 'nullable|array',
            'role' => 'required|exists:roles,id'
        ]);

        if (!$user->hasRole('user')) {
            $user->syncRoles($request->input('role'));
        } else {
            session()->flash('warning', 'Users Role cannot be modified!');
        }
        $user->syncPermissions($input['permissions'] ?? []);
        return redirect()->back()->with('success', 'Permissions saved.!');
    }


}
