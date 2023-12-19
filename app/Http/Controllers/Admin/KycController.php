<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KYCApproveMail;
use App\Mail\KYCRejectMail;
use App\Models\Kyc;
use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class KycController extends Controller
{
    public function index(Request $request, User $user)
    {
        abort_if(Gate::denies('kyc.viewAny'), Response::HTTP_FORBIDDEN);
        $kycs = $user->profile->kycs()->withCount(['documents' => fn($q) => $q->whereNotNull('document_name')])->get();
        return view('backend.admin.users.kyc.index', compact('user', 'kycs'));
    }

    public function show(Kyc $kyc)
    {
        abort_if(Gate::denies('kyc.viewAny'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.users.kyc.show', compact('kyc'));
    }

    /**
     * @throws AuthorizationException
     */
    public function reject(Kyc $kyc, KycDocument $document)
    {
        $this->authorize('reject', $document);
        abort_if(Gate::denies('kyc.viewAny'), Response::HTTP_FORBIDDEN);
        $user = $kyc->profile->user;
        return view('backend.admin.users.kyc.reject-kyc', compact('user', 'kyc', 'document'));
    }

    /**
     * @throws AuthorizationException
     */
    public function status(Request $request, KycDocument $document): \Illuminate\Http\JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'status' => 'required|in:approve,reject',
            'repudiate_note' => 'required_if:status,reject|nullable'
        ])->validate();

        $status = ['approve' => 'accepted', 'reject' => 'rejected'];

        $this->authorize($validated['status'], $document);

        $user = $document->kyc->profile->user;

        $document->status = $status[$validated['status']];
        if ($validated['status'] === 'reject') {
            $document->repudiate_note = $validated['repudiate_note'];
            \Mail::to($document->kyc->profile->user->email)->send(new KYCRejectMail($user, $document));
        }

        $document->save();

        $approved_doc_count = KycDocument::where('kyc_id', $document->kyc_id)->where('status', 'accepted')->count();

        if ($document->kyc->required_documents === $approved_doc_count) {
            $document->kyc()->update(['status' => 'accepted']);
            \Mail::to($document->kyc->profile->user->email)->send(new KYCApproveMail($user));

            $profile_verified_columns = ['nic' => 'nic_verified_at', 'driving_lc' => 'driving_lc_verified_at', 'passport' => 'passport_verified_at'];
            $document->kyc->profile()->update([$profile_verified_columns[$document->kyc->type] => now()]);
        } else {
            $rejected_doc_count = KycDocument::where('kyc_id', $document->kyc_id)->where('status', 'rejected')->count();
            //if ($document->kyc->required_documents === $rejected_doc_count) {
            if ($rejected_doc_count >= 1) {
                $document->kyc()->update(['status' => 'rejected']);
            }
        }

        $json['status'] = true;
        $json['message'] = 'KYC Document status changed!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);

    }
}
