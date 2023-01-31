<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('default.roles.manage', function ($user, Role $role) {
            return !in_array($role->name, ['user', 'admin', 'super_admin']);
        });

        Gate::define('default.roles.permissions', function ($user, Role $role) {
            return $role->name !== 'user';
        });

        Gate::after(function (User $user, $ability, $result, $arguments) {
            if ($ability === 'users.suspend' && $user->hasRole('super_admin', 'web')) {
                return !$arguments[0]->is_suspended;
            }
            if ($ability === 'users.activate-suspended' && $user->hasRole('super_admin', 'web')) {
                return $arguments[0]->is_suspended;
            }
            return $user->hasRole('super_admin', 'web');
        });
    }
}
