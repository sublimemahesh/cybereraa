<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraderTransaction extends Model
{
    use Loggable;
    use softDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'trader_id',
        'admin_id',
        'out_usdt',
        'usdt_out_time',
        'in_usdt',
        'usdt_in_time',
        'reference',
    ];

    public function trader(): BelongsTo
    {
        return $this->belongsTo(Trader::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
