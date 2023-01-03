<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

class RankBenefit extends Model
{
    use SoftDeletes;

    protected $fillable = ['last_earned_at', 'status', 'paid', 'amount'];

    protected $appends = [
        'package_info_json',
        'next_payment_date',
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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
            ->when(!empty(request()->input('type')) && in_array(request()->input('type'), ['rank_bonus', 'rank_gift']),
                static function ($query) {
                    $query->where('type', request()->input('type'));
                })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['qualified', 'disqualified', 'completed']),
                function ($query) {
                    $query->where('status', request()->input('status'));
                });
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


    public function getNextPaymentDateAttribute(): string
    {
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));

        $nextPayDay = $today;
        if (Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextWeekday = $today->nextWeekday();
        }
        return $this->next_payment_date = $nextPayDay->format('Y-m-d H:i:s');
    }
}
