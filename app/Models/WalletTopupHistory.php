<?php

namespace App\Models;

use Carbon;
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

    protected $fillable = ['user_id', 'receiver_id', 'amount', 'proof_documentation', 'remark'];

    protected $appends = [
        'package_info_json'
    ];

    public function getPackageInfoJsonAttribute(): stdClass
    {
        $obj = new StdClass();
        $obj->name = "Topup balance";
        $obj->amount = $this->amount;
        $obj->currency = "USDT";
        return $this->package_info_json = $obj;
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
            });
    }
}
