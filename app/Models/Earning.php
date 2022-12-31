<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Earning extends Model
{
    use SoftDeletes;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
        return $query->when(!empty(request()->input('date-range')), function ($query) {
            $period = explode(' to ', request()->input('date-range'));
            try {
                $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
            } finally {
                return;
            }
        })
            ->when(!empty(request()->input('earning-type')) && in_array(request()->input('earning-type'), ['package', 'direct', 'indirect']), function ($query) {
                $query->where('type', request()->input('earning-type'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['received', 'hold', 'cancelled']), function ($query) {
                $query->where('status', request()->input('status'));
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
}
