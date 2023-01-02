<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

class RankBenefit extends Model
{
    use SoftDeletes;

    protected $fillable = ['last_earned_at', 'status', 'paid', 'amount'];

    protected $appends = [
        'package_info_json'
    ];

    public function getPackageInfoJsonAttribute(): stdClass
    {
        $obj = new StdClass();
        $obj->name = "Rank {$this->rank->rank} Bonus";
        $obj->amount = $this->amount;
        $obj->currency = "USDT";
        return $this->package_info_json = $obj;
    }

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User());
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'rank_id')->withDefault(new Rank);
    }

    public function package()
    {
        return $this->package_info_json;
    }

    public function scopeAuthUserCurrentMonth(Builder $query): Builder
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        return $query->when(Auth::check(), static function (Builder $query) use ($firstDayOfMonth, $lastDayOfMonth) {
            $query->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
    }
}
