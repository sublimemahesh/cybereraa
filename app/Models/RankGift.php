<?php

namespace App\Models;

use Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;

class RankGift extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $fillable = ['user_id', 'rank_id', 'image_name', 'status'];

    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'rank_id')->withDefault(new Rank);
    }

    /**
     * @throws JsonException
     */
    public function getGiftRequirementAttribute()
    {
        $strategy = Strategy::where('name', 'rank_gift_requirements')->firstOr(static fn() => new Strategy(['value' => '{"1":{"total_investment":250,"total_team_investment":2000},"2":{"total_investment":500,"total_team_investment":12000},"3":{"total_investment":1000,"total_team_investment":75000},"4":{"total_investment":2500,"total_team_investment":400000},"5":{"total_investment":5000,"total_team_investment":2500000},"6":{"total_investment":10000,"total_team_investment":15000000},"7":{"total_investment":25000,"total_team_investment":100000000}}']));
        return json_decode($strategy->value, false, 512, JSON_THROW_ON_ERROR)->{$this->rank->rank};
    }

    public function getTotalTeamInvestmentAttribute()
    {
        return PurchasedPackage::totalTeamInvestment($this->user)->sum('invested_amount');
    }

    public function getTotalInvestmentAttribute()
    {
        return $this->user->totalInvestment()->sum('invested_amount');
    }

    public function renewStatus()
    {
        if (($this->status === 'PENDING') && $this->gift_requirement->total_investment <= $this->total_investment && $this->gift_requirement->total_team_investment <= $this->total_team_investment) {
            $this->update(['status' => 'QUALIFIED']);
        }
        return $this->status;
    }

    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('date-range')),
            static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['pending', 'qualified', 'issued']), function ($query) {
                $query->where('status', request()->input('status'));
            })
            ->when(!empty(request()->input('rank')), function ($query) {
                $query->whereRelation('rank', 'rank', request()->input('rank'));
            });
    }
}
