<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\KycDocument;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Str;
use Validator;

class KycDocumentController extends Controller
{

    public function show(KycDocument $document)
    {
        //
    }

    public function update(Request $request, Kyc $kyc, KycDocument $document)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|base64image|base64max:1024',
            'type' => 'required|in:front,back,other'
        ]);

        $validated = $validator->validated();

        if ($validator->fails() || Auth::user()->cannot('update', $document)) {
            $json['status'] = 'denied';
            $json['message'] = 'You cannot create a new entry';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $document_name = store($validated['document'], "user/kyc/" . $kyc->type, Str::random(20) . "-" . Carbon::now()->timestamp);

        if (!empty($document->document_name)) {
            Storage::delete("user/kyc/" . $kyc->type . "/" . $document->document_name);
        }

        $document->document_name = $document_name;
        $document->status = "pending";
        $document->save();

        $pending_doc_count = $kyc->documents()->where('status', 'pending')->count();
        if ($pending_doc_count >= 1) {
            $kyc->update(['status' => 'pending']);
        }

        $json['status'] = true;
        $json['message'] = 'KYC Document submitted successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);
    }

}
