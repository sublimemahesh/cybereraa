<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'currency',
        'amount',
        'type',
        'status',
    ];

    protected $appends = [
        'create_order_request_info',
        'create_order_response_info',
        'response_info'
    ];

    /**
     * @throws JsonException
     */
    public function getCreateOrderRequestInfoAttribute()
    {
        if ($this->create_order_request !== null) {
            return $this->create_order_request_info = json_decode($this->create_order_request, false, 512, JSON_THROW_ON_ERROR);
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function getCreateOrderResponseInfoAttribute()
    {
        if ($this->create_order_response !== null) {
            return $this->create_order_response_info = json_decode($this->create_order_response, false, 512, JSON_THROW_ON_ERROR);
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function getResponseInfoAttribute()
    {
//        {"bizType":"PAY","data":"{\"merchantTradeNo\":\"167192264711991849\",\"productType\":\"02\",\"productName\":\"Package 03\",\"transactTime\":1671922674167,\"tradeType\":\"WEB\",\"totalFee\":500.00000000,\"currency\":\"USDT\",\"commission\":0}","bizIdStr":"202047821918576640","bizId":202047821918576640,"bizStatus":"PAY_CLOSED"}
        if ($this->status_response !== null) {
            $res = json_decode($this->status_response, false, 512, JSON_THROW_ON_ERROR);
            $res->data = json_decode($res->data, false, 512, JSON_THROW_ON_ERROR);

            return $this->response_info = $res;
        }
        return null;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function purchasedPackage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PurchasedPackage::class, 'transaction_id', 'id');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query
            ->when(!empty(request()->input('date-range')), function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::createFromFormat('Y-m-d', $period[0]);
                    $date2 = Carbon::createFromFormat('Y-m-d', $period[1]);
                    $query->when($date1 && $date2, fn($q) => $q->whereDate('created_at', '>=', $period[0])->whereDate('created_at', '<=', $period[1]));
                } finally {
                    return;
                }
            })->when(!empty(request()->input('min-amount')), function ($query) {
                $query->where('amount', '>=', request()->input('min-amount'));
            })->when(!empty(request()->input('max-amount')), function ($query) {
                $query->where('amount', '<=', request()->input('max-amount'));
            })
            ->when(!empty(request()->input('currency-type')) && in_array(request()->input('currency-type'), ['crypto', 'wallet']), function ($query) {
                $query->where('type', request()->input('currency-type'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'), ['initial', 'paid', 'canceled', 'expired']), function ($query) {
                $query->where('status', request()->input('status'));
            });
    }
}
