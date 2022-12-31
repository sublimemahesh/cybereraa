<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use SoftDeletes;

    protected $fillable = ['last_earned_at', 'status'];

    protected $with = ['purchasedPackage'];

    protected $appends = [
        'package_info_json'
    ];

    public function getPackageInfoJsonAttribute()
    {
        return $this->package_info_json = $this->purchasedPackage->package_info_json;
    }

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }

    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class, 'purchased_package_id')->withDefault(new PurchasedPackage());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User());
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function scopeAuthUserCurrentMonth(Builder $query): Builder
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        return $query->when(Auth::check(), static function (Builder $query) use ($firstDayOfMonth, $lastDayOfMonth) {
            $query->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
    }
}
