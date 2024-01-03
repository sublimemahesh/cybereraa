<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicketCategory extends Model
{
    use Sluggable;
    use Loggable;
    use SoftDeletes;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'support_ticket_category_id');
    }
}
