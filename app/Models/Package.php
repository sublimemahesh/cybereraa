<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['name', 'amount', 'month_of_period', 'daily_leverage', 'is_active'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function purchasedPackages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchasedPackage::class, 'package_id', 'id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, PurchasedPackage::class, 'user_id', 'user_id', 'id', 'id');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->whereIsActive(true);
    }

}
