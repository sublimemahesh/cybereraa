<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use Loggable;
    protected $fillable = ['name', 'value', 'change', 'image_name'];
}
