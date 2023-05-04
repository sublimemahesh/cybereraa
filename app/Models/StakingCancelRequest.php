<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakingCancelRequest extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::updated(function (self $package) {
            if ($package->status === 'PROCESSING') {
                $package->processed_at = Carbon::now();
                $package->saveQuietly();
            }
            if ($package->status === 'APPROVED') {
                $package->approved_at = Carbon::now();
                $package->saveQuietly();
            }
            if ($package->status === 'CANCELLED') {
                $package->reject_at = Carbon::now();
                $package->saveQuietly();
            }
            if ($package->status === 'REJECTED') {
                $package->cancelled_at = Carbon::now();
                $package->saveQuietly();
            }
        });
    }

    protected $fillable = [
        'user_id',
        'purchased_staking_plan_id',
        'status',
        'remark',
        'repudiate_note',
        'processed_at',
        'approved_at',
        'reject_at',
        'cancelled_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function purchasedStakingPlan(): BelongsTo
    {
        return $this->belongsTo(PurchasedStakingPlan::class, 'purchased_staking_plan_id')->withDefault();
    }
}
