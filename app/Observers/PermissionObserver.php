<?php

namespace App\Observers;

use Haruncpi\LaravelUserActivity\Traits\Log;
use Spatie\Permission\Models\Permission;

class PermissionObserver
{
    use Log;

    public function created(Permission $permission)
    {
        self::logToDb($permission, 'create');
    }

    public function updated(Permission $permission)
    {
        self::logToDb($permission, 'update');
    }

    public function deleted(Permission $permission)
    {
        self::logToDb($permission, 'delete');
    }

    public function restored(Permission $permission)
    {
        self::logToDb($permission, 'update');
    }


    public function forceDeleted(Permission $permission)
    {
        self::logToDb($permission, 'delete');
    }
}
