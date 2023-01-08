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
        return $user->hasAnyRole(["admin", 'super_admin']);
    }

    public function view(User $user, Testimonial $testimonial)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Testimonial $testimonial)
    {
        return $user->hasAnyRole(["admin", 'super_admin']) || $user->id === $testimonial->user_id;
    }

    public function publish(User $user, Testimonial $testimonial)
    {
        return $user->hasAnyRole(["admin", 'super_admin']);
    }

    public function delete(User $user, Testimonial $testimonial)
    {
        return $user->hasAnyRole(["admin", 'super_admin']) || $user->id === $testimonial->user_id;
    }

    public function restore(User $user, Testimonial $testimonial)
    {
        return $user->hasAnyRole(["admin", 'super_admin']) || $user->id === $testimonial->user_id;
    }

    public function forceDelete(User $user, Testimonial $testimonial)
    {
        return $user->hasAnyRole(["admin", 'super_admin']) || $user->id === $testimonial->user_id;
    }
}
