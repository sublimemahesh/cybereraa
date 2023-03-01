<?php

namespace App\Actions;

use App\Jobs\NewUserGenealogyAutoPlacement;
use App\Jobs\SaleLevelCommissionJob;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon;
use DB;
use Throwable;

class ActivateTransaction
{
    /**
     * @throws Throwable
     */
    public function execute(Transaction $transaction): bool
    {
        return DB::transaction(static function () use ($transaction) {
            PurchasedPackage::updateOrCreate(['transaction_id' => $transaction->id], [
                'user_id' => $transaction->user_id,
                'purchaser_id' => $transaction->purchaser_id,
                'package_id' => $transaction->package_id,
                'invested_amount' => $transaction->package->amount,
                'payable_percentage' => $transaction->package->daily_leverage,
                'status' => 'ACTIVE',
                'expired_at' => Carbon::now()->addMonths($transaction->package->month_of_period)->format('Y-m-d H:i:s'),
                'package_info' => $transaction->package->toJson(),
            ]);

            $package = $transaction->purchasedPackage;
            $purchasedUser = $package->user;

            $strategies = Strategy::whereIn('name', ['commissions', 'commission_level_count', 'max_withdraw_limit'])->get();

            $max_withdraw_limit = $strategies->where('name', 'max_withdraw_limit')->first(null, new Strategy(['value' => 400]));
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $purchasedUser->id],
                ['balance' => 0, 'withdraw_limit' => 0]
            );

            $withdraw_limit = ($package->invested_amount * $max_withdraw_limit->value) / 100;
            $wallet->increment('withdraw_limit', $withdraw_limit);

            if ($purchasedUser->position === null) {
                if ($purchasedUser->super_parent_id === config('fortify.super_parent_id')) {
                    logger()->notice("NewUserGenealogyAutoPlacement::class via BinancePayController");
                    NewUserGenealogyAutoPlacement::dispatch($purchasedUser)->onConnection('sync');
                }
                return true;
            }

            SaleLevelCommissionJob::dispatch($purchasedUser, $package)->afterCommit()->onConnection('sync');

            return true;
        });

    }
}
