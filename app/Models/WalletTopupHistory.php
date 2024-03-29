<?php

namespace App\Models;

use Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

class WalletTopupHistory extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'amount',
        'proof_documentation',
        'remark',
        'status',
    ];

    protected $appends = [
        'package_info_json'
    ];

    protected static function booted()
    {
        static::created(function (self $topupHistory) {
            if ($topupHistory->status === 'SUCCESS') {
                $topupHistory->accepted_at = Carbon::now();
                $topupHistory->saveQuietly();
            }
            if ($topupHistory->status === 'REJECTED') {
                $topupHistory->rejected_at = Carbon::now();
                $topupHistory->saveQuietly();
            }
        });

        static::updated(function (self $topupHistory) {

            if ($topupHistory->status === 'SUCCESS') {
                $topupHistory->accepted_at = Carbon::now()->format('Y-m-d H:i:s');
                $topupHistory->saveQuietly();
            }
            if ($topupHistory->status === 'REJECTED') {
                $topupHistory->rejected_at = Carbon::now()->format('Y-m-d H:i:s');
                $topupHistory->saveQuietly();
            }
        });
    }

    public function getPackageInfoJsonAttribute(): stdClass
    {
        $obj = new StdClass();
        $obj->name = "Topup balance";
        $obj->amount = $this->amount;
        $obj->currency = "USDT";
        return $obj;
    }

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User());
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id')->withDefault(new User);
    }

    public function package(): stdClass
    {
        return $this->package_info_json;
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
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'),
                    ['pending', 'success', 'rejected']), function ($query) {
                $query->where('status', request()->input('status'));
            });
    }
}
