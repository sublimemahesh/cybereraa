<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;

class PurchasedPackage extends Pivot
{
    use SoftDeletes;

    protected $fillable = ['last_earned_at', 'transaction_id', 'user_id', 'package_id', 'invested_amount', 'payable_percentage', 'status', 'expired_at', 'package_info'];

    protected $appends = [
        'package_info_json'
    ];

    /**
     * @throws JsonException
     */
    public function getPackageInfoJsonAttribute()
    {
        return $this->package_info_json = json_decode($this->package_info, false, 512, JSON_THROW_ON_ERROR);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function packageRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    /*public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Earning::class, 'purchased_package_id', 'id');
    }*/

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->where('expired_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function getNextPaymentDateAttribute(): string
    {
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));

        $nextPayDay = $today;
        if (Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextWeekday = $today->nextWeekday();
        }
        return $nextPayDay->format('Y-m-d H:i:s');
    }
}
