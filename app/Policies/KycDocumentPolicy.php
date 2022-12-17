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
        return $user->getRoleNames()->first() === "user" && $kyc->status !== "accepted";
    }

    public function approve(User $user, KycDocument $document)
    {
        return ($user->getRoleNames()->first() === "admin" || $user->getRoleNames()->first() === "super_admin") &&
            ($document->status === "pending" || $document->status === "rejected");
    }

    public function reject(User $user, KycDocument $document)
    {
        return ($user->getRoleNames()->first() === "admin" || $user->getRoleNames()->first() === "super_admin") &&
            ($document->status === "pending" || $document->status === "accepted");
    }

    /**
     *
     * Check if the user can view uploaded document
     *
     */
    public function view(User $user, KycDocument $document)
    {
        return (
                $user->getRoleNames()->first() === "admin" ||
                ($user->getRoleNames()->first() === "user" && $document->kyc->profile_id === $user->profile->id && $document->status !== "accepted")
            ) && $document->status !== "required";
    }

    public function create(User $user, Kyc $kyc, $docType)
    {
        $document = KycDocument::where('type', $docType)->where('kyc_id', $kyc->id);
        return $user->getRoleNames()->first() === "user" &&
            KYC::REQUIRED_DOCUMENTS > $kyc->documents_count &&
            !$document->exists();
    }

    public function update(User $user, KycDocument $document)
    {
        return $user->getRoleNames()->first() === "user" &&
            $document->kyc->profile_id === $user->profile->id &&
            $document->status !== "accepted";
    }

    public function delete(User $user, KycDocument $document)
    {
        return false;
    }

    public function restore(User $user, KycDocument $document)
    {
        return $user->getRoleNames()->first() === "super_admin";
    }

    public function forceDelete(User $user, KycDocument $document)
    {
        return $user->getRoleNames()->first() === "super_admin";
    }
}
