<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWalletTransaction;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AdminWalletTransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_wallet_transactions.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            $earnings = AdminWalletTransaction::filter()
                ->with('earnable', 'user')
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                });

            return DataTables::eloquent($earnings)
                ->addColumn('earnable_type', function ($earn) {
                    return
                        "<code class='text-uppercase'>{$earn->type}</code> " .
                        ($earn->earnable_id ? " - #" . str_pad($earn->earnable_id, '4', '0', STR_PAD_LEFT) : '');
                })
                ->addColumn('user', function ($earn) {
                    return "<a href='" . route('admin.users.profile.show', $earn->user) . "' target='_blank'>
                            {$earn->user->username}
                        </a>";
                })
                ->addColumn('amount', fn($earn) => number_format($earn->amount, 2))
                ->addColumn('date', fn($earn) => $earn->created_at->format('Y-m-d H:i:s'))
                ->rawColumns(['user', 'earnable_type'])
                ->make();
        }
        return view('backend.admin.admin-wallets.index');
    }
}
