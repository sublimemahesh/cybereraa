<?php

namespace App\Models;

use App\Traits\NextPaymentDate;
use Carbon\Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function Illuminate\Events\queueable;

class PurchasedPackage extends Pivot
{
    use SoftDeletes, NextPaymentDate;
    use Loggable;

    protected $fillable = ['last_earned_at', 'commission_issued_at', 'transaction_id', 'user_id', 'purchaser_id', 'package_id', 'invested_amount', 'payable_percentage', 'status', 'expired_at', 'package_info'];

    protected $appends = [
        'package_info_json',
        'is_commission_issued',
    ];

    protected static function booted()
    {
        static::created(queueable(function (self $package) {
            // TODO: optimize with filtering only the rank does not issue the gifts
            $package->user->ancestorsAndSelf()
                ->withWhereHas('rankGifts', function ($q) {
                    return $q->where('status', 'PENDING');
                })
                ->chunk(100, function ($ancestors) {
                    foreach ($ancestors as $ancestor) {
                        foreach ($ancestor->rankGifts as $gift) {
                            $gift->renewStatus();
                        }
                    }
                });
        }));
    }

    /**
     * @throws JsonException
     */
    public function getPackageInfoJsonAttribute()
    {
        return $this->package_info_json = json_decode($this->package_info, false, 512, JSON_THROW_ON_ERROR);
    }

    public function getIsCommissionIssuedAttribute(): bool
    {
        return $this->is_commission_issued = $this->commission_issued_at !== null;
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

    /*public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Earning::class, 'purchased_package_id', 'id');
    }*/

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('expired_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeExpiredPackages(Builder $query): Builder
    {
        return $query->where('status', 'EXPIRED')
            ->where('expired_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
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
