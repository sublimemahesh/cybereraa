<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakingPlan extends Model
{
    use SoftDeletes;

    public function package(): BelongsTo
    {
        return $this->belongsTo(StakingPackage::class, 'stacking_package_id', 'id')->withDefault();
    }
}
