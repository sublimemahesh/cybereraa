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

class AdminWalletTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'currency',
        'amount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function earnable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(!empty(request()->input('date-range')), static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $period[0] . ":00");
                    $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $period[1] . ":00");
                    $query->when($date1 && $date2, function ($q) use ($date1, $date2) {
                        return $q->where('created_at', '>=', $date1)
                            ->where('created_at', '<=', $date2);
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
