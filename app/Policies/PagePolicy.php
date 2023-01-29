<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('page.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Page $page)
    {
        if ($user->hasPermissionTo('page.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('page.create')) {
            return true;
        }
    }

    public function update(User $user, Page $page)
    {
        if ($user->hasPermissionTo('page.update')) {
            return true;
        }
    }

    public function delete(User $user, Page $page)
    {
        if ($user->hasPermissionTo('page.delete')) {
            return true;
        }
    }

    public function restore(User $user, Page $page)
    {
        if ($user->hasPermissionTo('page.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Page $page)
    {
        if ($user->hasPermissionTo('page.delete')) {
            return true;
        }
    }
}
