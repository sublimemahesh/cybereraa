<?php

namespace App\Models;

use Carbon;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamBonus extends Model
{
    use Loggable;
    use softDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'paid',
        'bonus_date',
        'bonus',
        'type',
        'status',
        'package_ids',
        'summery',
    ];

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }


    public function teamBonusEarnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id')->where('status', 'TEAM_BONUS');
    }


    public function specialBonusEarnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id')->where('status', 'SPECIAL_BONUS');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('date-range')),
            static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('bonus_date', '>=', $period[0])->whereDate('bonus_date', '<=', $period[1]));
                } catch (\Exception $e) {
                    $query->whereDate('bonus_date', request()->input('date-range'));
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['qualified', 'disqualified']), function ($query) {
                $query->where('status', request()->input('status'));
            })->when(!empty(request()->input('bonus-type')) && in_array(request()->input('bonus-type'), ['10_direct_sale', '20_direct_sale', '30_direct_sale']), function ($query) {
                $query->where('bonus', request()->input('bonus-type'));
            });
    }
}
