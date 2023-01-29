<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('blogs.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Blog $blog)
    {
        if ($user->hasPermissionTo('blogs.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('blogs.create')) {
            return true;
        }
    }

    public function update(User $user, Blog $blog)
    {
        if ($user->hasPermissionTo('blogs.update')) {
            return true;
        }
    }

    public function delete(User $user, Blog $blog)
    {
        if ($user->hasPermissionTo('blogs.delete')) {
            return true;
        }
    }

    public function restore(User $user, Blog $blog)
    {
        if ($user->hasPermissionTo('blogs.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Blog $blog)
    {
        if ($user->hasPermissionTo('blogs.delete')) {
            return true;
        }
    }
}
