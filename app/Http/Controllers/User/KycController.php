<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Auth;
use Illuminate\Http\Request;
use Validator;

class KycController extends Controller
{
    public function index(Request $request)
    {
        $kycs = Auth::user()->profile->kycs;
        return view('backend.user.kyc.index', compact('kycs'));
    }

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

        Kyc::create([
            'profile_id' => Auth::user()->profile->id,
            'type' => $validated['kyc_type'],
            'status' => 'pending'
        ]);

        $json['status'] = 'success';
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
