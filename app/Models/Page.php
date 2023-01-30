<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Page extends Model
{
    use Sluggable;
    use HasRecursiveRelationships;

    protected $fillable = [
        'parent-id', 'title', 'image', 'content',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => false,
            ]
        ];
    }
}
