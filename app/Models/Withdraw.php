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
use stdClass;

class Withdraw extends Model
{
    use SoftDeletes;
    use Loggable;

    protected $fillable = ['user_id', 'receiver_id', 'amount', 'transaction_fee', 'status', 'type', 'remark', 'wallet_type',
        'remark', 'payout_details', 'proof_document', 'approved_at', 'rejected_at', 'failed_at', 'processed_at'
    ];

    protected $appends = [
        'package_info_json'
    ];

    public function getPackageInfoJsonAttribute(): stdClass
    {
        $obj = new StdClass();
        $obj->name = "{$this->type} Transfer";
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

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id')->withDefault(new User);
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

    public function scopeCurrentMonthForUser(Builder $query, User $user): Builder
    {
        return $query->when($user->id !== null, static function (Builder $query) use ($user) {
            $firstDayOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            $query->where('user_id', $user->id)
                ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth]);
        });
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
            ->when(!empty(request()->input('type')) && in_array(request()->input('type'), ['p2p', 'binance']),
                static function ($query) {
                    $query->where('type', request()->input('type'));
                })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['pending', 'processing', 'success', 'fail', 'reject']),
                function ($query) {
                    $query->where('status', request()->input('status'));
                });
    }

}
