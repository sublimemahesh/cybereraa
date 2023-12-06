<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trader extends Model
{
    use Loggable;
    use softDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone',
    ];

    public function traderTransactions(): HasMany
    {
        return $this->hasMany(TraderTransaction::class, 'trader_id');
    }

}
