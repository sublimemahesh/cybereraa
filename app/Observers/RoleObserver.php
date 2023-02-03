<?php

namespace App\Observers;


use Haruncpi\LaravelUserActivity\Traits\Log;
use Spatie\Permission\Models\Role;

class RoleObserver
{
    use Log;

    public function created(Role $role)
    {
        self::logToDb($role, 'create');
    }

    public function updated(Role $role)
    {
        self::logToDb($role, 'update');
    }

    public function deleted(Role $role)
    {
        self::logToDb($role, 'delete');
    }

    public function restored(Role $role)
    {
        self::logToDb($role, 'update');
    }


    public function forceDeleted(Role $role)
    {
        self::logToDb($role, 'delete');
    }
}
