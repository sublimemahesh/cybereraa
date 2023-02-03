<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    use Loggable;
    protected $fillable = ['name', 'iso', 'image_name'];
}
