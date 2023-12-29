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
            ->withCount(['withdrawals as successful_withdrawals_count' => function ($query) {
                $query->where('status', 'SUCCESS');
            }])
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
            ->addColumn('amount_formatted', function ($withdraw) {
                return number_format($withdraw->amount, 2);
            })
            ->addColumn('fee', fn($withdraw) => number_format($withdraw->transaction_fee, 2))
            ->addColumn('total', fn($withdraw) => number_format($withdraw->amount + $withdraw->transaction_fee, 2))
            ->addColumn('date', fn($withdraw) => $withdraw->created_at->format('Y-m-d H:i:s'))
            ->addColumn('processed_date', function ($withdraw) {
                return $withdraw->processed_at !== null ? \Carbon::parse($withdraw->processed_at)->format('Y-m-d H:i:s') : '-';
            })
            ->addColumn('approved_date', function ($withdraw) {
                return $withdraw->approved_at !== null ? \Carbon::parse($withdraw->approved_at)->format('Y-m-d H:i:s') : '-';
            })
            ->addColumn('rejected_date', function ($withdraw) {
                return $withdraw->rejected_at !== null ? \Carbon::parse($withdraw->rejected_at)->format('Y-m-d H:i:s') : '-';
            })
            ->addColumn('type', function ($withdraw) {
                return
                    "<code class='text-uppercase'>{$withdraw->type} - {$withdraw->wallet_type}</code> - #" .
                    str_pad($withdraw->id, '4', '0', STR_PAD_LEFT);
            });
    }
}
