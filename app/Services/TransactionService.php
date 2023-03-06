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
            ->addColumn('trx_id', fn($trx) => '#' . str_pad($trx->id, '4', '0', STR_PAD_LEFT))
            ->addColumn('user', static function ($trx) {
                return "ID: " . str_pad($trx->user_id, '4', '0', STR_PAD_LEFT) .
                    "<br> <code class='text-uppercase'>{$trx->user->username}</code>";
            })->addColumn('purchaser', static function ($trx) {
                return "ID: " . str_pad($trx->purchaser_id, '4', '0', STR_PAD_LEFT) .
                    "<br> <code class='text-uppercase'>{$trx->purchaser->username}</code>";
            })
            ->addColumn('package', fn($trx) => $trx->create_order_request_info->goods->goodsName ?? '-')
            ->addColumn('trx_amount', fn($trx) => number_format($trx->amount, 2))
            ->addColumn('paid_at', fn($trx) => Carbon::parse($trx->created_at)->format('Y-m-d H:i:s'))
            ->addColumn('type', static function ($trx) {
                return "TYPE: <code class='text-uppercase'>" . $trx->type . '</code><br>' .
                    "METHOD: <code class='text-uppercase'>" . $trx->pay_method . '</code>';
            })
            //->addColumn('created_at', fn($trx) => $trx->created_at->format('Y-m-d h:i A'))
            //->addColumn('updated_at', fn($trx) => $trx->updated_at->format('Y-m-d h:i A'))
            ->addColumn('actions', function (Transaction $trx) {
                return "";
            });
    }
}
