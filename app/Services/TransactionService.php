<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\QueryDataTable;

class TransactionService
{
    public function filter(int|null $user_id = null)
    {
        return Transaction::filter()
            ->with('package', 'user')
            ->when($user_id !== null, static function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
        //->where('created_at', '<=', date('Y-m-d H:i:s'))
        //->latest();
    }

    public function datatable(int|null $user_id = null): EloquentDataTable|QueryDataTable|DataTableAbstract
    {
        return DataTables::eloquent($this->filter($user_id))
            ->addColumn('user_id', fn($trx) => str_pad($trx->user_id, '4', '0', STR_PAD_LEFT))
            ->addColumn('trx_id', fn($trx) => '#' . str_pad($trx->id, '4', '0', STR_PAD_LEFT))
            ->addColumn('username', fn($earn) => $earn->user->username)
            ->addColumn('package', fn($trx) => $trx->create_order_request_info->goods->goodsName ?? '-')
            ->addColumn('trx_amount', fn($trx) => number_format($trx->amount, 2))
            ->addColumn('paid_at', fn($trx) => $trx->response_info ? Carbon::createFromTimestamp($trx->response_info->data->transactTime / 1000)->format('Y-m-d h:i:s') : '-')
            //->addColumn('created_at', fn($trx) => $trx->created_at->format('Y-m-d h:i A'))
            //->addColumn('updated_at', fn($trx) => $trx->updated_at->format('Y-m-d h:i A'))
            ->addColumn('action', function (Transaction $trx) {
                return "";
            });
    }
}