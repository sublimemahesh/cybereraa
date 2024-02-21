<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarNote extends Model
{
    use SoftDeletes, Sluggable;


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'rrule',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
