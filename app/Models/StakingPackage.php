<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakingPackage extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'amount',
        'gas_fee',
        'description',
        'is_active',
        'order',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $withCount = ['plans'];

    public function getCurrencyAttribute(): string
    {
        return $this->currency = 'USDT';
    }

    public function getTotalAmountAttribute(): string
    {
        return $this->total_amount = $this->amount + $this->gas_fee;
    }

    public function plans(): HasMany
    {
        return $this->hasMany(StakingPlan::class, 'staking_package_id', 'id');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->whereIsActive(true);
    }
}
