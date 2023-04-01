<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
