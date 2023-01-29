<?php

namespace App\Policies;

use App\Models\Kyc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KycPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole("user");
    }

    public function view(User $user, Kyc $kyc)
    {
        if ($user->hasPermissionTo('kyc.viewAny') || ($user->hasRole("user") && $kyc->profile_id === $user->profile->id && $kyc->status !== "accepted")) {
            return true;
        }
    }

    public function create(User $user, string $kycType): bool
    {
        $kyc = Kyc::where('type', $kycType)->whereRelation('profile.user', 'id', $user->id)->exists();
        return $user->hasRole("user") && !$kyc;
    }

    public function update(User $user, Kyc $kyc)
    {
        return $user->hasRole("user") && $kyc->profile_id === $user->profile->id && $kyc->status !== "accepted";
    }

    public function delete(User $user, Kyc $kyc)
    {
        return false;
    }

    public function restore(User $user, Kyc $kyc)
    {
        return false;
    }

    public function forceDelete(User $user, Kyc $kyc)
    {
        return false;
    }
}
