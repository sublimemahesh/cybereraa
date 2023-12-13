<?php

namespace App\Models;

use App\Traits\NextPaymentDate;
use Carbon\Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PurchasedPackage extends Pivot
{
    use SoftDeletes, NextPaymentDate;
    use Loggable;

    protected $fillable = [
        'last_earned_at',
        'commission_issued_at',
        'transaction_id',
        'user_id',
        'purchaser_id',
        'package_id',
        'invested_amount',
        'payable_percentage',
        'status',
        'expired_at',
        'package_info',
        'investment_profit',
        'level_commission_profit',
        'package_earned_profit',
        'earned_profit',
    ];

    protected $appends = [
        'package_info_json',
        'is_commission_issued',
    ];

    protected static function booted()
    {
        //        static::created(queueable(function (self $package) {
        //            // TODO: optimize with filtering only the rank does not issue the gifts
        //            $package->user->ancestorsAndSelf()
        //                ->withWhereHas('rankGifts', function ($q) {
        //                    return $q->where('status', 'PENDING');
        //                })
        //                ->chunk(100, function ($ancestors) {
        //                    foreach ($ancestors as $ancestor) {
        //                        foreach ($ancestor->rankGifts as $gift) {
        //                            $gift->renewStatus();
        //                        }
        //                    }
        //                });
        //        }));

        static::updated(function (self $package) {
            if ($package->status === 'EXPIRED') {
                $package->expiry_status_changed_at = Carbon::now();
                $package->saveQuietly();
            }
        });
    }

    /**
     * @throws JsonException
     */
    public function getPackageInfoJsonAttribute()
    {
        return json_decode($this->package_info ?? '[]', false, 512, JSON_THROW_ON_ERROR);
    }

    public function getExpiryStatusChangedAtAttribute($date)
    {
        return $this->expiry_status_changed_at = $date ?? $this->updated_at;
    }

    public function getIsCommissionIssuedAttribute(): bool
    {
        return $this->commission_issued_at !== null;
    }

    public function getTotalProfitPercentageAttribute(): float
    {
        return $this->investment_profit + $this->level_commission_profit;
    }

    public function getTotalPackageProfitAttribute(): float
    {
        return ($this->invested_amount / 100) * $this->investment_profit;
    }

    public function getTotalProfitAttribute(): float
    {
        return ($this->invested_amount / 100) * $this->total_profit_percentage;
    }

    public function getTotalEarnedProfitAttribute(): float
    {
        return ($this->invested_amount / 100) * $this->earned_profit;
    }

    public function getPackageActivateDateAttribute(): string
    {
        $created_at_week_day = $this->created_at->dayOfWeek;
        if (in_array($created_at_week_day, [1, 2, 3, 4])) {
            return $this->created_at->addDays(6)->format('Y-m-d') . " 12:00 AM";
        }
        if ($created_at_week_day === 5) {
            return $this->created_at->addDays(5)->format('Y-m-d') . " 12:00 AM";
        }
        if (in_array($created_at_week_day, [0, 6])) {
            return $this->created_at->addDays(4)->format('Y-m-d') . " 12:00 AM";
        }
        return $this->created_at->format('Y-m-d') . " 12:00 AM";
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(new User);
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id')->withDefault(new User);
    }

    public function packageRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function adminEarnings(): morphMany
    {
        return $this->morphMany(AdminWalletTransaction::class, 'earnable');
    }

    /*public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Earning::class, 'purchased_package_id', 'id');
    }*/

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable');
    }

    public function totalEarnings(): HasMany
    {
        return $this->hasMany(Earning::class, 'purchased_package_id', 'id');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->where('status', 'ACTIVE');
            //->where('expired_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeExpiredPackages(Builder $query): Builder
    {
        return $query->where('status', 'EXPIRED');
            //->where('expired_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeTotalInvestment(Builder $query, User|null $user): Builder
    {
        return $query->when($user && $user->id !== null, static function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereIn('status', ['ACTIVE', 'EXPIRED']);
    }

    public function scopeTotalTeamInvestment(Builder $query, User $user): Builder
    {
        return $query->whereIn('status', ['ACTIVE', 'EXPIRED'])
            ->whereIn('user_id', $user->descendants()->pluck('id')->toArray());
    }

    public function scopeTotalDirectTeamInvestment(Builder $query, User $user): Builder
    {
        return $query->whereIn('status', ['ACTIVE', 'EXPIRED'])
            ->whereIn('user_id', $user->directSales->pluck('id')->toArray());
    }

    public function scopeTotalMonthlyTeamInvestment(Builder $query, User $user, string|null $first_of_month, string|null $end_of_month): Builder
    {
        if ($first_of_month === null) {
            $first_of_month = Carbon::now()->firstOfMonth()->format('Y-m-d H:i:s');
        }
        if ($end_of_month === null) {
            $end_of_month = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        }
        $descendants = $user->descendants()->pluck('id')->toArray() ?? [];
        return $query->whereIn('user_id', $descendants)
            ->whereDate('created_at', '>=', $first_of_month)
            ->whereDate('created_at', '<=', $end_of_month);
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
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                } finally {
                    return;
                }
            })->when(!empty(request()->input('min-amount')), function ($query) {
                $query->where('invested_amount', '>=', request()->input('min-amount'));
            })->when(!empty(request()->input('max-amount')), function ($query) {
                $query->where('invested_amount', '<=', request()->input('max-amount'));
            })->when(!empty(request()->input('purchaser_id')), function ($query) {
                $query->where('purchaser_id', request()->input('purchaser_id'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'),
                    ['pending', 'active', 'expired', 'hold', 'ban']), function ($query) {
                $query->where('status', request()->input('status'));
            });
    }
}
