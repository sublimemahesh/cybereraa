<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JsonException;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'currency',
        'amount',
        'type',
        'status',
    ];

    protected $appends = [
        'create_order_request_info'
    ];

    /**
     * @throws JsonException
     */
    public function getCreateOrderRequestInfoAttribute()
    {
        return $this->create_order_request_info = json_decode($this->create_order_request, false, 512, JSON_THROW_ON_ERROR);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function purchasedPackages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchasedPackage::class, 'transaction_id', 'id');
    }
}
