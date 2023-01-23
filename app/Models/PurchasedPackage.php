<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use function Illuminate\Events\queueable;

class PurchasedPackage extends Pivot
{
    use SoftDeletes;

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
                    foreach ($ancestors->rankGifts as $gift) {
                        $gift->renewStatus();
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

    public function getNextPaymentDateAttribute(): string
    {
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));

        $nextPayDay = $today;
        if (Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextWeekday = $today->nextWeekday();
        }
        return $nextPayDay->format('Y-m-d H:i:s');
        /*
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));
        $firstPayDate = $this->created_at->addDays(5);

        $nextPayDay = $firstPayDate;
        if ($firstPayDate->isPast()) {
            $nextPayDay = $today;
        }
        if ($firstPayDate->isPast() && Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextPayDay->nextWeekday();
        }
        return $nextPayDay->format('Y-m-d H:i:s');*/
    }
}
