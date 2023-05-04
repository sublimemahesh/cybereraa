<?php

namespace App\Services;

use App\Models\PurchasedStakingPlan;
use Carbon;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\QueryDataTable;

class PurchaseStakingPlanService
{
    public function filter(int|null $user_id = null)
    {
        return PurchasedStakingPlan::with('user', 'purchaser')
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
                    "Package: {$trx->package_info_json?->name} ({$trx->interest_rate}%)";
            })
            ->addColumn('package', function ($trx) {
                return "NAME: {$trx->package_info_json?->name} ({$trx->interest_rate}%)";
            })
            ->addColumn('invested', function ($trx) {
                return number_format($trx->invested_amount, 2);
            })
            ->addColumn('interest', function ($trx) {
                return $trx->interest_rate . "%";
            })
            ->addColumn('maturity_date', function ($trx) {
                if ($trx->maturity_date) {
                    return Carbon::parse($trx->maturity_date)->format('Y-m-d H:i:s');
                }
                return '-';
            })
            ->addColumn('created', function ($trx) {
                return Carbon::parse($trx->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('actions', function () {
                return;
            });
    }
}
