<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Exception;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Earning extends Model
{
    use SoftDeletes;
    use Loggable;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function earnable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class)->withDefault();
    }

    public function tradeIncomePackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class);
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
                    $date1 = Carbon::parse($period[0])->format('Y-m-d H:i:s');
                    $date2 = Carbon::parse($period[1])->format('Y-m-d H:i:s');
                    $query->when($date1 && $date2, fn($q) => $q->where('created_at', '>=', $date1)->where('created_at', '<=', $date2));
                } catch (Exception $e) {
                    $query->whereDate('created_at', Carbon::parse($period[0])->format('Y-m-d'));
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('earning-type')) && in_array(request()->input('earning-type'), ['package', 'trade_direct', 'trade_indirect', 'direct', 'indirect', 'rank_bonus', 'rank_gift', 'p2p', 'staking', 'special_bonus']),
                static function ($query) {
                    $query->where('type', request()->input('earning-type'));
                })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['received', 'hold', 'canceled']),
                static function ($query) {
                    $query->where('status', request()->input('status'));
                })
            ->when(request()->filled('amount-start') && !request()->filled('amount-end'), function ($query) {
                $amountStart = (float)request('amount-start');
                return $query->where('amount', '>=', $amountStart);
            })
            ->when(request()->filled('amount-end') && !request()->filled('amount-start'), function ($query) {
                $amountEnd = (float)request('amount-end');
                return $query->where('amount', '<=', $amountEnd);
            })
            ->when(request()->filled('amount-start') && request()->filled('amount-end'), function ($query) {
                $amountStart = (float)request('amount-start');
                $amountEnd = (float)request('amount-end');
                return $query->whereBetween('amount', [$amountStart, $amountEnd]);
            });
    }

    public function scopeAuthUserCurrentMonth(Builder $query): Builder
    {
        return $query->when(Auth::check(), static function (Builder $query) {
            $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $query->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
    }

    public function scopeCurrentMonthForUser(Builder $query, User $user): Builder
    {
        return $query->when($user->id !== null, static function (Builder $query) use ($user) {
            $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $query->where('user_id', $user->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
    }
}
