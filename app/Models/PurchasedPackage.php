<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PurchasedPackage extends Pivot
{

    protected $fillable = ['last_earned_at'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Earning::class, 'purchased_package_id', 'id');
    }

    public function scopeActivePackages(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->whereDate('expired_at', '>=', Carbon::now()->format('Y-m-d H:i:s'));
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
