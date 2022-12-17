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
        return $user->getRoleNames()->first() === "user";
    }

    public function view(User $user, Kyc $kyc)
    {
        return $user->getRoleNames()->first() === "admin" ||
            ($user->getRoleNames()->first() === "user" && $kyc->profile_id === $user->profile->id && $kyc->status !== "accepted");
    }

    public function create(User $user, string $kycType): bool
    {
        $kyc = Kyc::where('type', $kycType)->whereRelation('profile.user', 'id', $user->id);
        return $user->getRoleNames()->first() === "user" && !$kyc->exists();
    }

    public function update(User $user, Kyc $kyc)
    {
        return $user->getRoleNames()->first() === "user" && $kyc->profile_id === $user->profile->id && $kyc->status !== "accepted";
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
