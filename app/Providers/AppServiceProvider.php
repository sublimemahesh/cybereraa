<?php

namespace App\Providers;

use App\Observers\PermissionObserver;
use App\Observers\RoleObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        Paginator::useBootstrapFive();
    }
}
