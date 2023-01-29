<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('testimonial.viewAny')) {
            return true;
        }
    }

    public function view(User $user, Testimonial $testimonial)
    {
        return true;
    }

    public function create(User $user)
    {
        if ($user->hasRole('user') || $user->hasPermissionTo('testimonial.create')) {
            return true;
        }
    }

    public function update(User $user, Testimonial $testimonial)
    {
        if ($user->id === $testimonial->user_id || $user->hasPermissionTo('testimonial.update')) {
            return true;
        }
    }

    public function publish(User $user, Testimonial $testimonial)
    {
        if ($user->hasPermissionTo('testimonial.publish')) {
            return true;
        }

    }

    public function delete(User $user, Testimonial $testimonial)
    {
        if ($user->id === $testimonial->user_id || $user->hasPermissionTo('testimonial.delete')) {
            return true;
        }
    }

    public function restore(User $user, Testimonial $testimonial)
    {
        if ($user->id === $testimonial->user_id || $user->hasPermissionTo('testimonial.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, Testimonial $testimonial)
    {
        if ($user->id === $testimonial->user_id || $user->hasPermissionTo('testimonial.delete')) {
            return true;
        }
    }
}
