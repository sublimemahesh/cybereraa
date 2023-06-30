<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class PopupNotice extends Model
{
    use Loggable;

    protected $fillable = [
        'title',
        'content',
        'image_name',
        'is_active',
        'start_date',
        'end_date',
    ];

}
