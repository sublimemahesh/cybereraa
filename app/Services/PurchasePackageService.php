<?php

namespace App\Services;

use App\Models\PurchasedPackage;
use Carbon;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\QueryDataTable;

class PurchasePackageService
{
    public function filter(int|null $user_id = null)
    {
        return PurchasedPackage::with('user', 'purchaser')
            ->filter()
            ->when($user_id !== null, static function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
        //->where('created_at', '<=', date('Y-m-d H:i:s'))
        //->latest();
    }

    public function datatable(int|null $user_id = null): EloquentDataTable|QueryDataTable|DataTableAbstract
    {
        return DataTables::eloquent($this->filter($user_id))
            ->addColumn('trx_id', function ($trx) {
                return 'PURCHASE: #' . str_pad($trx->id, '4', '0', STR_PAD_LEFT) . "<br>" .
                    'TRX: #' . str_pad($trx->transaction_id, '4', '0', STR_PAD_LEFT);
            })
            ->addColumn('user', static function ($trx) {
                return "User: " . str_pad($trx->user_id, '4', '0', STR_PAD_LEFT) .
                    " - <code class='text-uppercase'>{$trx->user->username}</code> <br>" .
                    "Purchased By: " . str_pad($trx->purchaser_id, '4', '0', STR_PAD_LEFT) .
                    " - <code class='text-uppercase'>{$trx->purchaser->username}</code> <br>" .
                    "Package: " . $trx->package_info_json?->name;
//                    "Package: " . $trx->package_info_json?->name . "(" . $trx->payable_percentage . ' %)';
            })
            ->addColumn('package', function ($trx) {
                return "NAME: " . $trx->package_info_json?->name;
//                return "NAME: " . $trx->package_info_json?->name . "(" . $trx->payable_percentage . ' %)';
            })
            ->addColumn('invested', function ($trx) {
                return number_format($trx->invested_amount, 2);
            })
            ->addColumn('last_earned', function ($trx) {
                if ($trx->last_earned_at) {
                    return Carbon::parse($trx->last_earned_at)->format('Y-m-d H:i:s');
                }
                return '-';
            })
            ->addColumn('commission_issued', function ($trx) {
                if ($trx->commission_issued_at) {
                    return Carbon::parse($trx->commission_issued_at)->format('Y-m-d H:i:s');
                }
                return '-';
            })
            ->addColumn('expired', function ($trx) {
                return Carbon::parse($trx->expired_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('created', function ($trx) {
                return Carbon::parse($trx->created_at)->format('Y-m-d H:i:s');
            });
    }
}
