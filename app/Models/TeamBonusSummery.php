<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamBonusSummery extends Model
{
    use Loggable;
    use softDeletes, CascadeSoftDeletes;

    protected $table = 'team_bonus_summaries';

    protected $fillable = [
        'start_date',
        'end_date',
        'requirement',
        'allocated_bonus',
        'eligible_users_count',
        'monthly_total_sale',
        'remaining_bonus',
    ];

}
