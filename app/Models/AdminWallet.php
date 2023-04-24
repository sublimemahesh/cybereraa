<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminWallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['wallet_type', 'balance'];
}
