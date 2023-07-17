<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\KycDocument;
use Auth;
use Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;
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

        $kyc = DB::transaction(function () use ($validated) {
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
        $json['redirectUrl'] = route('user.kyc.show', $kyc);
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);
    }

    public function show(Request $request, Kyc $kyc)
    {
        return view('backend.user.kyc.show', compact('kyc'));
    }

    public function update(Request $request, Kyc $kyc)
    {
        $kyc->load('profile');
        $pending_count = $kyc->documents()
            ->where(function (Builder $q) {
                $q->whereNull('document_name')
                    ->orWhere('status', 'rejected');
            })
            ->count();
        $validated = Validator::make($request->all(), [
            'nic' => [
                Rule::requiredIf($kyc->type === 'nic'),
                'nullable',
                //Rule::unique('profiles', 'nic')->ignoreModel($kyc->profile),
                'max:250'
            ],
            'driving_lc' => [
                Rule::requiredIf($kyc->type === 'driving_lc'),
                'nullable',
                //Rule::unique('profiles', 'driving_lc_number')->ignoreModel($kyc->profile),
                'max:250'
            ],
            'passport' => [
                Rule::requiredIf($kyc->type === 'passport'),
                'nullable',
                //Rule::unique('profiles', 'passport_number')->ignoreModel($kyc->profile),
                'max:250'
            ],
            'documents' => [Rule::requiredIf($pending_count > 0), 'nullable', 'array'],
            'documents.*.document_file' => 'nullable', 'base64image', 'base64max:1024',
            'documents.*.id' => 'required|exists:kyc_documents,id',
            // 'type' => 'required|in:front,back,other'
        ])->validate();

        if (Auth::user()->cannot('update', $kyc)) {
            $json['status'] = 'denied';
            $json['message'] = 'KYC is not allowed to update';
            $json['icon'] = 'error';
            return response()->json($json, 403);
        }

        $errors = [];
        foreach ($validated['documents'] as $document_data) {

            if ($document_data['document_file'] === null) {
                continue;
            }
            $document = KycDocument::find($document_data['id']);
            if (Auth::user()->cannot('update', $document)) {
                $errors[$document->id] = $kyc->type . ' ' . $document->type . " document Cannot update";
                continue;
            }

            $document_name = store($document_data['document_file'], "user/kyc/" . $kyc->type, Str::random(20) . "-" . Carbon::now()->timestamp);

            if ($document_name === null) {
                continue;
            }
            if (!empty($document->document_name)) {
                Storage::delete("user/kyc/" . $kyc->type . "/" . $document->document_name);
            }

            $document->document_name = $document_name;
            $document->status = "pending";
            $document->save();
        }
        $pending_doc_count = $kyc->documents()->where('status', 'pending')->count();
        if ($pending_doc_count >= 1) {
            $kyc->update([
                'status' => 'pending'
            ]);
        }

        $kyc->profile()->update([$kyc->profile_name => $validated[$kyc->type]]);

        $json['status'] = true;
        $json['errors'] = $errors;
        $json['message'] = count($errors) > 0 ? 'KYC Document submitted successfully!. NOTE: Some Documents are cannot be update.' : 'KYC Document submitted successfully!';
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['data'] = $validated;

        return response()->json($json);
    }

}
