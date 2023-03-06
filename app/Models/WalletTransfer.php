<?php

namespace App\Models;

use Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransfer extends Model
{
    use Loggable;
    use SoftDeletes;

    protected $fillable = ['user_id', 'from', 'to', 'amount', 'fee', 'remark'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User());
    }

    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('date-range')),
            static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('user_id')), static function ($query) {
                $query->where('user_id', request()->input('user_id'));
            })
            ->when(!empty(request()->input('to')) && request()->input('to') === 'topup',
                static function ($query) {
                    $query->where('to', request()->input('to'));
                });
    }
}
