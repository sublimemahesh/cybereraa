<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class RankBonusSummery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'start_date',
        'end_date',
        'eligible_rank_level_count',
        'eligible_rank_levels',
        'rank_package_requirements',
        'eligible_rankers',
        'total_rank_bonus_percentage',
        'one_rank_bonus_percentage',
        'monthly_total_sale',
        'total_bonus_amount',
        'one_rank_bonus_amount',
        'remaining_bonus_amount',
    ];

    /**
     * @throws JsonException
     */
    public function getEligibleRankersArrayAttribute(): array
    {
        return json_decode($this->eligible_rankers, true, 512, JSON_THROW_ON_ERROR);
    }

    public function getEligibleRankersStrAttribute(): string
    {
        return implode('=>', $this->eligible_rankers_array);
    }

    public function adminEarnings(): morphMany
    {
        return $this->morphMany(AdminWalletTransaction::class, 'earnable');
    }

    /**
     * @throws JsonException
     */
    public function getRequirementAttribute()
    {
        $strategy = Strategy::where('name', 'rank_package_requirements')->firstOr(static fn() => new Strategy(['value' => '{"3":{"active_investment":1000,"total_team_investment":5000},"4":{"active_investment":2500,"total_team_investment":10000},"5":{"active_investment":5000,"total_team_investment":25000},"6":{"active_investment":10000,"total_team_investment":50000},"7":{"active_investment":25000,"total_team_investment":100000}}']));
        return json_decode($strategy->value, false, 512, JSON_THROW_ON_ERROR);
    }

    public function getMonthlyTotalTeamInvestmentAttribute()
    {
        $validator = \Validator::make(request()?->all(), [
            'month' => 'required|date_format:Y-m',
        ]);
        if ($validator->fails()) {
            $month = \Carbon::now();
        } else {
            $validated = $validator->validated();
            $month = \Carbon::parse($validated['month']);
        }
        $first_of_month = $month->firstOfMonth()->format('Y-m-d H:i:s');
        $last_of_month = $month->lastOfMonth()->format('Y-m-d H:i:s');

        if (!$month->isFuture() || $month::today()) {
            return PurchasedPackage::totalMonthlyTeamInvestment(\Auth::user(), $first_of_month, $last_of_month)
                ->sum('invested_amount');
        }
        return 0;
    }

    public function getTotalTeamInvestmentAttribute()
    {
        return PurchasedPackage::totalTeamInvestment(\Auth::user())->sum('invested_amount');
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('start-date')),
            static function ($query) {
                $query->whereDate('start_date', '>=', request()->input('start-date'));
            })->when(!empty(request()->input('end-date')),
            static function ($query) {
                $query->whereDate('end_date', '>=', request()->input('end-date'));
            });
    }
}
