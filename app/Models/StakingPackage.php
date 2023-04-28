<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakingPackage extends Model
{
    use SoftDeletes;
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function plans(): HasMany
    {
        return $this->hasMany(StakingPlan::class, 'stacking_package_id', 'id');
    }
}
