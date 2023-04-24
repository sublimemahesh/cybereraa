<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminWalletController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_wallet.viewAny'), Response::HTTP_FORBIDDEN);

        $admin_wallets = AdminWallet::all();

        return view('backend.admin.admin-wallets.wallets', compact('admin_wallets'));
    }
}
