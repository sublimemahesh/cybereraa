<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, TransactionService $transaction)
    {
        abort_if(Gate::denies('transactions.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            return $transaction->datatable($request->input('user_id'))
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.admin.users.transactions.index');
    }


}
