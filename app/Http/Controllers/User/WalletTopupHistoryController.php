<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WalletTopupHistory;
use App\Services\WalletTopupHistoryService;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class WalletTopupHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() && $request->isMethod('POST')) {
            $validated = Validator::make($request->all(), [
                'amount' => ['required', 'numeric'],
                'proof_documentation' => ['required', 'file'],
                'remark' => ['nullable', 'string', 'max:250'],
            ])->validate();

            $receiver = Auth::user();
            DB::transaction(static function () use ($validated, $receiver) {

                $file = $validated['proof_documentation'];
                $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName())) . "-" . $file->hashName();
                $file->storeAs('wallets/topup', $proof_documentation);

                return WalletTopupHistory::create([
                    'user_id' => null,
                    'receiver_id' => $receiver->id,
                    'amount' => $validated['amount'],
                    'proof_documentation' => $proof_documentation,
                    'remark' => $validated['remark'],
                    'status' => 'PENDING'
                ]);
            });

            $json['status'] = true;
            $json['message'] = "Topup request is successful!";
            $json['icon'] = 'success'; // warning | info | question | success | error
            $json['redirectUrl'] = null;
            return response()->json($json, Response::HTTP_OK);
        }
        return view('backend.user.wallet.request-topup');
    }

    /**
     * @throws Exception
     */
    public function history(Request $request, WalletTopupHistoryService $topupHistoryService)
    {

        if ($request->wantsJson()) {
            return $topupHistoryService->datatable($request->get('sender_id'), Auth::user()->id)
                ->rawColumns(['sender', 'receiver', 'proof', 'remark'])
                ->make();
        }
        return view('backend.user.wallet.topup-history');
    }

}
