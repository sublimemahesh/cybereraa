<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;

class PurchasedStakingPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'purchaser_id',
        'staking_plan_id',
        'invested_amount',
        'interest_rate',
        'status',
        'maturity_date',
        'package_info',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(new User);
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id')->withDefault(new User);
    }

    public function stakingPlan(): BelongsTo
    {
        return $this->belongsTo(StakingPlan::class, 'staking_plan_id', 'id');
    }

    /**
     * @throws JsonException
     */
    public function getPackageInfoJsonAttribute()
    {
        return $this->package_info_json = json_decode($this->package_info, false, 512, JSON_THROW_ON_ERROR);
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
