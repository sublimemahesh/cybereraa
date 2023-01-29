<?php

namespace App\Policies;

use App\Models\Kyc;
use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KycDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Kyc $kyc)
    {
        if ($kyc->status !== "accepted" && $user->hasRole("user")) {
            return true;
        }
    }

    public function approve(User $user, KycDocument $document)
    {
        return ($document->status === "pending" || $document->status === "rejected") && ($user->hasPermissionTo('kyc.approve'));
    }

    public function reject(User $user, KycDocument $document)
    {
        return ($document->status === "pending" || $document->status === "accepted") && $user->hasPermissionTo('kyc.reject');
    }

    /**
     *
     * Check if the user can view uploaded document
     *
     */
    public function view(User $user, KycDocument $document)
    {
        if ($document->status !== "required" && ($user->hasPermissionTo('kyc.viewAny') ||
                ($user->hasRole("user") && $document->kyc->profile_id === $user->profile->id && $document->status !== "accepted")
            )) {
            return true;
        }
        return $document->status !== "required" && $user->hasRole('super_admin');
    }

    public function create(User $user, Kyc $kyc, $docType)
    {
        $document = KycDocument::where('type', $docType)->where('kyc_id', $kyc->id)->exists();
        return KYC::REQUIRED_DOCUMENTS > $kyc->documents_count && !$document && $user->hasRole("user");
    }

    public function update(User $user, KycDocument $document)
    {
        return $document->kyc->profile_id === $user->profile->id && $document->status !== "accepted" && $user->hasRole("user");
    }

    public function delete(User $user, KycDocument $document)
    {
        return false;
    }

    public function restore(User $user, KycDocument $document)
    {
        return $user->hasRole("super_admin");
    }

    public function forceDelete(User $user, KycDocument $document)
    {
        return $user->hasRole("super_admin");
    }
}
