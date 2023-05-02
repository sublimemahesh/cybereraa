<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakingPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'staking_package_id',
        'name',
        'duration',
        'interest_rate',
        'is_active',
        'order',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(StakingPackage::class, 'staking_package_id', 'id')->withDefault();
    }

    public function purchasedPackage(): HasMany
    {
        return $this->hasMany(PurchasedStakingPlan::class, 'staking_plan_id', 'id');
    }

    public function transactions(): morphMany
    {
        return $this->morphMany(Transaction::class, 'product', 'product_type', 'product_id');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->whereIsActive(true);
    }
}
