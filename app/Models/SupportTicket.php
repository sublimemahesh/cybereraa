<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    use SoftDeletes;
    use Sluggable;
    use Loggable;

    protected static function boot()
    {
        parent::boot();

        static::deleted(static function ($ticket) {
            $ticket->replies()->delete();
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'subject'
            ]
        ];
    }


    public function scopeFilterTickets(Builder $query): Builder
    {
        return $query->when(request()->input('category'),
            static function ($query) {
                $query->whereHas('category', static function ($query) {
                    $query->whereId(request()->input('category'));
                });
            })
            ->when(request()->input('priority'), static function ($query) {
                $query->whereHas('priority', static function ($query) {
                    $query->whereId(request()->input('priority'));
                });
            })
            ->when(request()->input('status'), static function ($query) {
                $query->whereHas('status', static function ($query) {
                    $query->whereId(request()->input('status'));
                });
            });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SupportTicketCategory::class, 'support_ticket_category_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(SupportTicketPriority::class, 'support_ticket_priority_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(SupportTicketStatus::class, 'support_ticket_status_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class, 'support_ticket_id');
    }
}
