<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Select2UserResource;
use App\Models\Earning;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTopupHistory;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FA\Google2FA;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class WalletTopupHistoryController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);
        return view('backend.admin.users.wallets.topup');
    }

    /**
     * @throws Exception
     */
    public function history(Request $request)
    {
        abort_if(Gate::denies('wallet.topup-history.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {

            $topup_history = WalletTopupHistory::with('receiver', 'user')
                ->when(!empty($request->get('user_id')), static function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                })->when(!empty($request->get('receiver_id')), static function ($query) use ($request) {
                    $query->where('receiver_id', $request->get('receiver_id'));
                })->filter()
                //->where('created_at', '<=', date('Y-m-d H:i:s'))
                ->latest();

            return DataTables::eloquent($topup_history)
                ->addColumn('sender', static function ($topup) {
                    return str_pad($topup->user_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$topup->user->username}</code>";
                })->addColumn('receiver', static function ($topup) {
                    return str_pad($topup->receiver_id, '4', '0', STR_PAD_LEFT) .
                        " - <code class='text-uppercase'>{$topup->receiver->username}</code>";
                })->addColumn('proof', static function ($topup) {
                    return "<a href='" . storage('wallets/topup/' . $topup->proof_documentation) . "' target='_blank' class='btn btn-info shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-check-to-slot'></i>
                            </a>";
                })->addColumn('remark', static function ($topup) {
                    return "<span title='{$topup->remark}'>" . Str::limit($topup->remark, 15) . "</span>";
                })
                ->addColumn('created_at', fn($topup) => $topup->created_at->format('Y-m-d H:i:s'))
                ->addColumn('amount', fn($topup) => number_format($topup->amount, 2))
                ->rawColumns(['sender', 'receiver', 'proof', 'remark'])
                ->make();
        }

        return view('backend.admin.users.wallets.history');

    }

    /**
     * @throws Throwable
     */
    public function topup(Request $request): \Illuminate\Http\JsonResponse
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);

        $sender = Auth::user();
        $validated = Validator::make($request->all(), [
            'receiver' => 'required|exists:users,id',
            'amount' => ['required', 'numeric'],
            'proof_documentation' => ['required', 'file'],
            'remark' => ['nullable', 'string', 'max:250'],
            'password' => 'required',
            'code' => 'nullable',
        ])->validate();

        if (!Hash::check($validated['password'], $sender->password)) {
            $json['status'] = false;
            $json['message'] = 'Password is incorrect';
            $json['icon'] = 'error'; // warning | info | question | success | error
            return response()->json($json, Response::HTTP_UNAUTHORIZED);
        }

        if (optional($sender)->two_factor_secret && in_array(TwoFactorAuthenticatable::class, class_uses_recursive($sender), true)) {
            if ($validated['code'] === null) {
                $json['status'] = false;
                $json['message'] = 'The two factor authentication code is required.';
                $json['icon'] = 'error'; // warning | info | question | success | error
                return response()->json($json, Response::HTTP_UNAUTHORIZED);
            }

            $recoveryCode = collect($sender->recoveryCodes())->first(static function ($known_code) use ($validated) {
                if (hash_equals($known_code, $validated['code'])) {
                    return $validated['code'];
                }
                return null;
            });

            if ($recoveryCode !== null) {
                $sender->replaceRecoveryCode($recoveryCode);
                event(new RecoveryCodeReplaced($sender, $recoveryCode));
            } else {
                $valid = (new TwoFactorAuthenticationProvider(new Google2FA))->verify(decrypt($sender->two_factor_secret), $validated['code']);
                if (!$valid) {
                    $json['status'] = false;
                    $json['message'] = 'The provided two factor authentication code was invalid.';
                    $json['icon'] = 'error'; // warning | info | question | success | error
                    return response()->json($json, Response::HTTP_UNAUTHORIZED);
                }
            }
        }


        $receiver = User::find($validated['receiver']);
        DB::transaction(static function () use ($validated, $sender, $receiver) {

            $file = $validated['proof_documentation'];
            $proof_documentation = Str::limit(Str::slug($file->getClientOriginalName())) . "-" . $file->hashName();
            $file->storeAs('wallets/topup', $proof_documentation);

            $topup = WalletTopupHistory::create([
                'user_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $validated['amount'],
                'proof_documentation' => $proof_documentation,
                'remark' => $validated['remark'],
            ]);

            $topup->earnings()->save(Earning::forceCreate([
                'user_id' => $receiver->id,
                'currency' => 'USDT',
                'amount' => $topup->amount,
                'type' => 'P2P',
                'status' => 'RECEIVED'
            ]));

            $receiver_wallet = Wallet::firstOrCreate(
                ['user_id' => $receiver->id],
                ['balance' => 0, 'withdraw_limit' => 0]
            );

            $receiver_wallet->increment('balance', $topup->amount);

            return $topup;
        });

        $json['status'] = true;
        $json['message'] = "Topup is successful!";
        $json['icon'] = 'success'; // warning | info | question | success | error
        $json['redirectUrl'] = null;
        return response()->json($json, Response::HTTP_OK);
    }

    public function findUsers($search_text): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        abort_if(Gate::denies('wallet.topup'), Response::HTTP_FORBIDDEN);
        $users = User::where('username', 'LIKE', "%{$search_text}%")
            ->whereRelation('roles', 'name', 'user')
            ->get();
        return Select2UserResource::collection($users);
    }
}
