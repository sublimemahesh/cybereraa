<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\KycDocument;
use Auth;
use DB;
use Illuminate\Http\Request;
use Throwable;
use Validator;

class KycController extends Controller
{
    public function index(Request $request)
    {
        $kycs = Auth::user()->profile->kycs;
        return view('backend.user.kyc.index', compact('kycs'));
    }

    /**
     * @throws Throwable
     */
    public function storeNewEntry(Request $request)
    {
        $validator = Validator::make($request->all(), ['kyc_type' => 'in:nic,driving_lc,passport']);
        $validated = $validator->validated();
        if ($validator->fails() || Auth::user()->cannot('create', [Kyc::class, $validated['kyc_type']])) {
            $json['status'] = 'denied';
            $json['message'] = 'You cannot create a new entry';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        DB::transaction(function () use ($validated) {
            return tap(Kyc::create([
                'profile_id' => Auth::user()->profile->id,
                'type' => $validated['kyc_type'],
                'status' => 'pending'
            ]), function (Kyc $kyc) {
                $required_documents = [];
                foreach (KycDocument::DOCUMENT_TYPE_NAMES[$kyc->type] as $type => $typeName) {
                    if (Auth::user()->can('create', [KycDocument::class, $kyc, $type])) {
                        $required_documents[] = [
                            'kyc_id' => $kyc->id,
                            'type' => $type,
                            'status' => 'required',
                        ];
                    }
                }
                $kyc->documents()->createMany($required_documents);
            });
        });

        $json['status'] = true;
        $json['message'] = 'KYC entry was successfully created!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);
    }

    public function show(Request $request, Kyc $kyc)
    {
        return view('backend.user.kyc.show', compact('kyc'));
    }

}
