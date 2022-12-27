<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Commission extends Model
{
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
}
