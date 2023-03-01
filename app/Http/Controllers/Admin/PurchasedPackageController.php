<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PurchasePackageService;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchasedPackageController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, PurchasePackageService $purchasePackageService)
    {
        abort_if(Gate::denies('purchase_packages.viewAny'), Response::HTTP_FORBIDDEN);

        if ($request->wantsJson()) {
            return $purchasePackageService->datatable($request->input('user_id'))
                ->rawColumns(['user', 'package', 'trx_id'])
                ->make(true);
        }
        return view('backend.admin.users.packages.index');
    }
}
