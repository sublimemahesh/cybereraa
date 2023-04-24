<?php

namespace App\Models;

use App\Enums\AdminWalletEnum;
use Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AdminWalletWithdrawal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'proof_document',
        'remark',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('date-range')),
            static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, function ($q) use ($period) {
                        return $q->whereDate('created_at', '>=', $period[0])
                            ->whereDate('created_at', '<=', $period[1]);
                    });
                } catch (Exception $e) {
                    $query->whereDate('created_at', Carbon::parse($period[0])->format('Y-m-d'));
                }
            })
            ->when(
                !empty(request()->input('type')) &&
                in_array(request()->input('type'), AdminWalletEnum::walletTypes(), true), static function ($query) {
                $query->where('type', request()->input('type'));
            });
    }
}
