<?php

namespace App\Services;

use App\Models\WalletTopupHistory;
use Str;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\QueryDataTable;

class WalletTopupHistoryService
{
    public function filter(int|null $admin_user_id = null, int|null $receiver_id = null)
    {
        return WalletTopupHistory::with('receiver', 'user')
            ->filter()
            ->when($admin_user_id !== null, static function ($query) use ($admin_user_id) {
                $query->where('user_id', $admin_user_id);
            })->when($receiver_id !== null, static function ($query) use ($receiver_id) {
                $query->where('receiver_id', $receiver_id);
            });
        //->where('created_at', '<=', date('Y-m-d H:i:s'))
        //->latest();
    }

    public function datatable(int|null $admin_user_id = null, int|null $receiver_id = null): EloquentDataTable|QueryDataTable|DataTableAbstract
    {
        return DataTables::eloquent($this->filter($admin_user_id, $receiver_id))
            ->addColumn('sender', static function ($topup) {
                return str_pad($topup->user_id, '4', '0', STR_PAD_LEFT) .
                    " - <code class='text-uppercase'>{$topup->user->username}</code>";
            })->addColumn('receiver', static function ($topup) {
                return str_pad($topup->receiver_id, '4', '0', STR_PAD_LEFT) .
                    " - <code class='text-uppercase'>{$topup->receiver->username}</code>";
            })->addColumn('proof', static function ($topup) {
                return "<a href='" . storage('wallets/topup/' . $topup->proof_documentation) . "' target='_blank' class='btn btn-info shadow btn-xs my-1 sharp me-1'>
                                <i class='fas fa-check-to-slot'></i>
                            </a>";
            })->addColumn('remark', static function ($topup) {
                return "<span title='{$topup->remark}'>" . Str::limit($topup->remark, 15) . "</span>";
            })
            ->addColumn('created_at', fn($topup) => $topup->created_at->format('Y-m-d H:i:s'))
            ->addColumn('amount', fn($topup) => number_format($topup->amount, 2));
    }
}