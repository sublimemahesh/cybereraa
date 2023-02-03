<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    use Loggable;
    protected $fillable = ['value'];
}
