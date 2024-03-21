<?php

namespace App\Models;

use App\Mail\TransactionMail;
use App\Mail\TransactionRejectMail;
use Carbon\Carbon;
use Exception;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
use Mail;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Transaction extends Model
{
    use SoftDeletes;
    use Loggable;

    protected static function booted()
    {
        static::updated(function (self $transaction) {
            if ($transaction->status === 'PAID' && $transaction->isDirty('status')) {
                $user = $transaction->user;
                Mail::to($user->email)->send(new TransactionMail($transaction, $user));
            }
            if ($transaction->status === 'REJECTED' && $transaction->isDirty('status')) {
                $user = $transaction->user;
                Mail::to($user->email)->send(new TransactionRejectMail($transaction, $user));
            }
        });
    }

    protected $fillable = [
        'user_id',
        'purchaser_id',
        'package_id',
        'package_type',
        'package_info',
        'currency',
        'amount',
        'gas_fee',
        'type',
        'pay_method',
        'proof_document',
        'repudiate_note',
        'transaction_id',
        'status_response',
        'status',
        'create_order_request'
    ];

    protected $appends = [
        'package_info_json',
        'create_order_request_info',
        'create_order_response_info',
        'response_info'
    ];


    public function getPackageInfoJsonAttribute()
    {
        return json_decode($this->package_info ?? '[]', false, 512, JSON_THROW_ON_ERROR);
    }

    public function getPackageAttribute()
    {
        return $this->package_info_json;
    }

    /**
     * @throws JsonException
     */
    public function getCreateOrderRequestInfoAttribute()
    {
        if ($this->create_order_request !== null) {
            return json_decode($this->create_order_request, false, 512, JSON_THROW_ON_ERROR);
        }
        return null;
    }

    /**
     * @throws JsonException
     */
    public function getCreateOrderResponseInfoAttribute()
    {
        if ($this->create_order_response !== null) {
            return json_decode($this->create_order_response, false, 512, JSON_THROW_ON_ERROR);
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id')->withDefault(new User);
    }

//    public function package(): BelongsTo
//    {
//        return $this->belongsTo(Package::class, 'package_id', 'id');
//    }

    public function product(): MorphTo
    {
        return $this->morphTo('product', 'product_type', 'product_id');
    }

    public function purchasedPackage(): HasOne
    {
        return $this->hasOne(PurchasedPackage::class, 'transaction_id', 'id');
    }

    public function purchasedStakingPlan(): HasOne
    {
        return $this->hasOne(PurchasedStakingPlan::class, 'transaction_id');
    }

    public function adminEarnings(): morphMany
    {
        return $this->morphMany(AdminWalletTransaction::class, 'earnable');
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
                    $date1 = Carbon::parse($period[0])->format('Y-m-d H:i:s');
                    $date2 = Carbon::parse($period[1])->format('Y-m-d H:i:s');
                    $query->when($date1 && $date2, fn($q) => $q->where('created_at', '>=', $date1)->where('created_at', '<=', $date2));
                } catch (Exception $e) {
                    $query->whereDate('created_at', $period[0]);
                } finally {
                    return;
                }
            })->when(!empty(request()->input('purchaser_id')), function ($query) {
                $query->where('purchaser_id', request()->input('purchaser_id'));
            })->when(!empty(request()->input('min-amount')), function ($query) {
                $query->where('amount', '>=', request()->input('min-amount'));
            })->when(!empty(request()->input('max-amount')), function ($query) {
                $query->where('amount', '<=', request()->input('max-amount'));
            })
            ->when(!empty(request()->input('product-type')) && in_array(request()->input('product-type'), ['package', 'staking']), function ($query) {
                $query->where('package_type', request()->input('product-type'));
            })
            ->when(!empty(request()->input('currency-type')) && in_array(request()->input('currency-type'), ['crypto', 'wallet']), function ($query) {
                $query->where('type', request()->input('currency-type'));
            })
            ->when(!empty(request()->input('pay-method')) && in_array(request()->input('pay-method'), ['main', 'topup', 'manual', 'binance']), function ($query) {
                $query->where('pay_method', request()->input('pay-method'));
            })
            ->when(!empty(request()->input('status')) && in_array(request()->input('status'),
                    ['initial', 'pending', 'paid', 'canceled', 'expired', 'rejected']), function ($query) {
                $query->where('status', request()->input('status'))
                    ->when(request()->input('status') === 'pending', fn($q) => $q->where('pay_method', 'manual'));
            })
            ->when(request()->filled('amount-start') && !request()->filled('amount-end'), function ($query) {
                $amountStart = (float)request('amount-start');
                return $query->where('amount', '>=', $amountStart);
            })
            ->when(request()->filled('amount-end') && !request()->filled('amount-start'), function ($query) {
                $amountEnd = (float)request('amount-end');
                return $query->where('amount', '<=', $amountEnd);
            })
            ->when(request()->filled('amount-start') && request()->filled('amount-end'), function ($query) {
                $amountStart = (float)request('amount-start');
                $amountEnd = (float)request('amount-end');
                return $query->whereBetween('amount', [$amountStart, $amountEnd]);
            });
    }
}
