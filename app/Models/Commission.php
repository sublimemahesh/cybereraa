<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Commission extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $fillable = ['last_earned_at', 'status'];

    protected $with = ['purchasedPackage'];

    protected $appends = [
        'package_info_json',
        'next_payment_date',
    ];

    public function getPackageInfoJsonAttribute()
    {
        return $this->package_info_json = $this->purchasedPackage->package_info_json;
    }

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }

    public function adminEarnings(): morphMany
    {
        return $this->morphMany(AdminWalletTransaction::class, 'earnable');
    }

    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class, 'purchased_package_id')->withDefault(new PurchasedPackage());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(new User());
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
            ->when(!empty(request()->input('type')) && in_array(request()->input('type'), ['direct', 'indirect']), function ($query) {
                $query->where('type', request()->input('type'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['qualified', 'disqualified', 'completed']), function ($query) {
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

    public function scopeCurrentMonthForUser(Builder $query, User $user): Builder
    {
        return $query->when($user->id !== null, static function (Builder $query) use ($user) {
            $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $query->where('user_id', $user->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
    }

    public function getNextPaymentDateAttribute(): string
    {
        if ($this->created_at === null){
            return '-';
        }
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
