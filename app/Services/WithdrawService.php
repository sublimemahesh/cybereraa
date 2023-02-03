<?php

namespace App\Services;

use App\Models\Withdraw;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\QueryDataTable;

class WithdrawService
{
    public function filter(int|null $user_id = null, int|null $receiver_id = null)
    {
        return Withdraw::with('receiver', 'user')
            ->when($user_id !== null, static function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->when($receiver_id !== null, static function ($query) use ($receiver_id) {
                $query->where('receiver_id', $receiver_id);
            })->filter();
        //->where('created_at', '<=', date('Y-m-d H:i:s'))
        //->latest();
    }

    public function datatable(Builder $withdrawals): EloquentDataTable|QueryDataTable|DataTableAbstract
    {
        return DataTables::eloquent($withdrawals)
            ->addColumn('amount', fn($withdraw) => number_format($withdraw->amount, 2))
            ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
            ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
            ->addColumn('created_at', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'));
    }
}