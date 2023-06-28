<?php

namespace App\Models;

use Carbon;
use DB;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Throwable;

class Rank extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $fillable = [
        'user_id',
        'rank',
        'eligibility',
        'activated_at',
        'eligibility_positions',
        'total_rankers'
    ];

    protected $appends = [
        'is_active'
    ];

    protected static function booted()
    {
        //        static::created(function (self $rank) {
        //            if ($rank->activated_at !== null) {
        //                self::initiateGift($rank);
        //            }
        //        });
        //
        //        static::updated(function (self $rank) {
        //            if ($rank->activated_at !== null) {
        //                self::initiateGift($rank);
        //            }
        //        });
    }

    /**
     * @throws Throwable
     */
    public static function initiateGift(self $rank)
    {
        return DB::transaction(function () use ($rank) {
            $rank_gift = RankGift::firstOrCreate([
                'user_id' => $rank->user_id,
                'rank_id' => $rank->id,
            ], ['status' => 'pending']);
            $rank_gift->renewStatus();
            return $rank_gift;
        });
    }

    public function getEligibilityPercentageAttribute(): float|int
    {
        if ($this->eligibility < config('rank-system.rank_eligibility_activate_at', 3)) {
            return round(($this->eligibility * 100 / config('rank-system.rank_eligibility_activate_at', 3)));
        }
        return 100;
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->is_active = $this->activated_at !== null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User);
    }

    public function rankGift(): HasOne
    {
        return $this->hasOne(RankGift::class, 'rank_id')->withDefault(new RankGift);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(RankBenefit::class, 'rank_id', 'id');
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
            ->when(!empty(request()->input('status')) && request()->input('status') === 'active', function ($query) {
                $query->whereNotNull('activated_at');
            })->when(!empty(request()->input('status')) && request()->input('status') === 'inactive', function ($query) {
                $query->whereNull('activated_at');
            })
            ->when(!empty(request()->input('rank')), function ($query) {
                $query->where('rank', request()->input('rank'));
            });
    }
}
