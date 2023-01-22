<?php

namespace App\Models;

use Arr;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;

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
        static::created(function (self $rank) {
            $rank_gift = DB::transaction(function () use ($rank) {
                $rank_gift = RankGift::firstOrCreate([
                    'user_id' => $rank->user_id,
                    'rank_id' => $rank->id,
                ], ['status' => 'pending']);
                $rank_gift->renewStatus();
                return $rank_gift;
            });
        });

        static::updated(function (self $rank) {
            $rank->rankGift->renewStatus();
        });
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
        return $query->when(Arr::hasAny(request()->all(), ['user_id', 'rank', 'date-range', 'status']), function ($query) {
            return $query->whereHas('rankGift', function (Builder $query) {
                $query->filter();
            });
        });
    }
}
