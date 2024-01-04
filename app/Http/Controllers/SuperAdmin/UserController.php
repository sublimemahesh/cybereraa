<?php

namespace App\Http\Controllers\SuperAdmin;
//namespace App\Actions\Fortify;

use App\Actions\ActivityLogAction;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Team;
use App\Models\User;
use DB;
use Exception;
use Haruncpi\LaravelUserActivity\Traits\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use JsonException;
use Laravel\Fortify\Events\TwoFactorAuthenticationDisabled;
use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    use PasswordValidationRules;
    use Log;

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin.users.viewAny'), Response::HTTP_FORBIDDEN);
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
        abort_if(Gate::none(['users.add-new', 'admin.users.viewAny']), Response::HTTP_FORBIDDEN);
        $roles = Role::where('name', '<>', 'user')->pluck('name', 'id')->all();
        $countries = Country::orderBy('name')->get(['name', 'iso', 'id'])->keyBy('iso');
        return view('backend.super_admin.users.create', compact('roles', 'countries'));
    }

    public function changeSponsor(Request $request, User $user)
    {
        abort_if(Gate::denies('changeSponsor', $user), Response::HTTP_FORBIDDEN);
        if ($request->isMethod('post')) {
            $validated = Validator::make($request->all(), [
                'new_sponsor_user' => [
                    'required',
                    'not_in:' . $user->id,
                    Rule::exists('users', 'id'),
                    //->where(function ($query) {
                    //  $query->where('id', '<>', config('fortify.super_parent_id'))
                    // ->whereNotNull('position')->whereNotNull('parent_id');
                    // })->orWhere('id', config('fortify.super_parent_id'));,
                    function ($attribute, $value, $fail) {
                        if (User::where('id', request('new_sponsor_user'))->whereHas('purchasedPackages')->doesntExist()) {
                            $fail("The selected New Sponsor does not have access to this feature. Please ensure the user has purchased a package.");
                        }
                    },
                ],
            ], [], ['new_sponsor_user' => 'New Sponsor'])->validate();

            if ($user->super_parent_id !== null && $user->parent_id === null && $user->position === null) {
                $user->forceFill([
                    'super_parent_id' => $validated['new_sponsor_user'],
                ])->save();
                return redirect()->route('super_admin.users.change-sponsor', $user)
                    ->with('success', 'Sponsor is change successfully!');
            }

            return redirect()->route('super_admin.users.change-sponsor', $user)
                ->with('error', 'Permission denied: Cannot update sponsor this user is already in the genealogy!');
        }

        return view('backend.super_admin.users.change-sponsor', compact('user'));
    }

    public
    function findUsers($search_text): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            //->where('id', '<>', 3)
//            ->where(function (Builder $query) {
//                $query->where(function (Builder $query) {
//                    $query->where('id', '<>', config('fortify.super_parent_id'))
//                        ->whereNotNull('position')->whereNotNull('parent_id');
//                })->orWhere('id', config('fortify.super_parent_id'));
//            })
            ->where(function ($q) {
                $q->where(function ($q) {
                    $q->where('id', '<>', config('fortify.super_parent_id'))
                        ->whereNotNull('super_parent_id');
                })->orWhere('id', config('fortify.super_parent_id'));
            })
            ->whereRelation('roles', 'name', 'user')
            ->get();

        return Select2UserResource::collection($users);
    }

    /**
     * @throws Throwable
     */
    public
    function store(Request $request)
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

    public
    function edit(User $user)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);

        $countries = Country::orderBy('name')->get(['name', 'iso', 'id'])->keyBy('iso');

        return view('backend.super_admin.users.edit', compact('user', 'countries'));
    }

    public
    function update(Request $request, User $user)
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

    public
    function destroy(User $user)
    {
        abort_if(Gate::denies('users.delete'), Response::HTTP_FORBIDDEN);
        if ($user->purchasedPackages()->count() > 0) {
            return redirect()->back()->with('success', 'Cannot delete users that have already been purchased a package');
        }
        $user->delete();
        return redirect()->route('super_admin.users.index')->with('success', 'Role deleted successfully');
    }

    public
    function changePassword(User $user)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);
        return view('backend.super_admin.users.change-password', compact('user'));
    }

    public
    function savePassword(User $user, Request $request)
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

    public
    function removeTwoFactor(User $user, Request $request)
    {
        abort_if(Gate::denies('users.update'), Response::HTTP_FORBIDDEN);


        if ($user->two_factor_secret !== null ||
            $user->two_factor_recovery_codes !== null ||
            $user->two_factor_confirmed_at !== null) {
            $user->forceFill([
                    'two_factor_secret' => null,
                    'two_factor_recovery_codes' => null,
                ] + (Fortify::confirmsTwoFactorAuthentication() ? [
                    'two_factor_confirmed_at' => null,
                ] : []))->save();

            TwoFactorAuthenticationDisabled::dispatch($user);
        }


        $json['status'] = true;
        $json['message'] = "Two Factor Authentication disabled!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = route('super_admin.users.changePassword', $user);
        return response()->json($json, Response::HTTP_OK);
    }


    public
    function showPermissions(User $user)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);

        $directPermissionsNames = $user->getPermissionNames();
        $user->load('roles.permissions');

        return view('backend.super_admin.users.show', compact('directPermissionsNames', 'user'));
    }


    public
    function managePermissions(User $user)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);
        $user->load('permissions', 'roles');
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::where('name', '<>', 'user')->pluck('name', 'id');
        return view('backend.super_admin.users.manage', compact('roles', 'permissions', 'user'));
    }

    /**
     * @throws JsonException
     */
    public
    function savePermissions(Request $request, User $user, ActivityLogAction $activityLog)
    {
        abort_if(Gate::denies('users.manage-permission'), Response::HTTP_FORBIDDEN);
        $input = $this->validate($request, [
            'permissions.*' => 'integer',
            'permissions' => 'nullable|array',
            'role' => 'required|exists:roles,id'
        ]);

        $previousData = [
            'Roles' => $user->getRoleNames(),
            'permissions' => $user->getDirectPermissions(),
        ];
        if (!$user->hasRole('user')) {
            $user->syncRoles($request->input('role'));
        } else {
            session()->flash('warning', 'Users Role cannot be modified!');
        }
        $user->syncPermissions($input['permissions'] ?? []);

        $newData = [
            'Roles' => $user->getRoleNames(),
            'permissions' => $user->getDirectPermissions(),
        ];

        $activityLog->exce('users.manage-permission', $previousData, $newData);
        return redirect()->back()->with('success', 'Permissions saved.!');
    }


}
