<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PurchasedStakingPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'purchaser_id',
        'staking_plan_id',
        'invested_amount',
        'interest_rate',
        'status',
        'maturity_date',
        'package_info',
    ];

    protected static function booted()
    {
        static::updated(function (self $package) {
            if ($package->status === 'EXPIRED') {
                $package->expiry_at = Carbon::now();
                $package->saveQuietly();
            }
            if ($package->status === 'CANCELLED') {
                $package->cancelled_at = Carbon::now();
                $package->saveQuietly();
            }
            if ($package->status === 'HOLD') {
                $package->hold_at = Carbon::now();
                $package->saveQuietly();
            }
        });
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->where('status', 'ACTIVE')
            ->where('maturity_date', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeExpiredPackages(Builder $query): Builder
    {
        return $query->where('status', 'EXPIRED');
    }

    public function scopeCancelledPackages(Builder $query): Builder
    {
        return $query->where('status', 'CANCELLED');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(new User);
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id')->withDefault(new User);
    }

    public function stakingPlan(): BelongsTo
    {
        return $this->belongsTo(StakingPlan::class, 'staking_plan_id', 'id');
    }

    public function cancelRequests(): HasMany
    {
        return $this->hasMany(StakingCancelRequest::class, 'purchased_staking_plan_id');
    }

    /**
     * @throws JsonException
     */
    public function getPackageInfoJsonAttribute()
    {
        $pkg_data = json_decode($this->package_info, false, 512, JSON_THROW_ON_ERROR);
        if (!empty($pkg_data?->package)) {
            $pkg_data->name = $pkg_data?->package?->name . '-' . $pkg_data->name;
        }
        return $this->package_info_json = $pkg_data;
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function earnings(): MorphMany
    {
        return $this->morphMany(Earning::class, 'earnable');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(!empty(request()->input('date-range')), function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, function ($q) use ($period) {
                        return $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]);
                    });
                } catch (\Exception $e) {
                    $query->when(!empty($period), fn($query) => $query->whereDate('created_at', $period[0]));
                }
            })
            ->when(!empty(request()->input('min-amount')), function ($query) {
                $query->where('invested_amount', '>=', request()->input('min-amount'));
            })
            ->when(!empty(request()->input('max-amount')), function ($query) {
                $query->where('invested_amount', '<=', request()->input('max-amount'));
            })
            ->when(!empty(request()->input('purchaser_id')), function ($query) {
                $query->where('purchaser_id', request()->input('purchaser_id'));
            })
            ->when(!empty(request()->input('package_id')), function (Builder $query) {
                $query->whereRelation('stakingPlan.package', 'staking_package_id', request()->input('package_id'));
            })
            ->when(!empty(request()->input('plan_id')), function ($query) {
                $query->where('staking_plan_id', request()->input('plan_id'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'),
                    ['pending', 'active', 'cancelled', 'expired', 'hold', 'ban']), function ($query) {
                $query->where('status', request()->input('status'));
            });
    }
}
