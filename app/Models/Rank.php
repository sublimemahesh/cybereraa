<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'rank',
        'eligibility',
        'activated_at',
    ];

    protected $appends = [
        'is_active'
    ];

    public function getIsActiveAttribute(): bool
    {
        return $this->is_active = $this->activated_at !== null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(RankBenefit::class, 'rank_id', 'id');
    }
}
