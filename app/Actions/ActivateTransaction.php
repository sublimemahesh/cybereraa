<?php

namespace App\Actions;

use App\Jobs\NewUserGenealogyAutoPlacement;
use App\Jobs\SaleLevelCommissionJob;
use App\Models\AdminWallet;
use App\Models\AdminWalletTransaction;
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

            $transaction->adminEarnings()->create([
                'user_id' => $transaction->user_id,
                'type' => 'GAS_FEE',
                'amount' => $transaction->gas_fee
            ]);

            $admin_wallet = AdminWallet::firstOrCreate(
                ['wallet_type' => 'GAS_FEE'],
                ['balance' => 0]
            );

            $admin_wallet->increment('balance', $transaction->gas_fee);

            $package = $transaction->purchasedPackage;
            $purchasedUser = $package->user;

            $strategies = Strategy::whereIn('name', ['commissions', 'rank_gift', 'commission_level_count', 'max_withdraw_limit'])->get();

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
                if ($purchasedUser->id === config('fortify.super_parent_id')) {

                    $rank_gift_percentage = $strategies->where('name', 'rank_gift')->first(null, fn() => new Strategy(['value' => '5']));
                    $allocated_for_gift = ($package->invested_amount * $rank_gift_percentage->value) / 100;
                    AdminWalletTransaction::create([
                        'user_id' => $purchasedUser->id, // sale purchase user
                        'type' => 'GIFT',
                        'amount' => $allocated_for_gift,
                    ]);

                    $admin_wallet = AdminWallet::firstOrCreate(
                        ['wallet_type' => 'GIFT'],
                        ['balance' => 0]
                    );

                    $admin_wallet->increment('balance', $allocated_for_gift);

                    $commissions = $strategies->where('name', 'commissions')->first(null, fn() => new Strategy(['value' => '{"1":"20","2":"10","3":"10","4":"10","5":"10","6":"10","7":"10","8":"10"}']));
                    $commissions = json_decode($commissions->value, true, 512, JSON_THROW_ON_ERROR);
                    $less_level_commissions = ($package->invested_amount * array_sum($commissions)) / 100;

                    AdminWalletTransaction::create([
                        'user_id' => $purchasedUser->id, // sale purchase user
                        'type' => 'LESS_LEVEL_COMMISSION',
                        'amount' => $less_level_commissions,
                    ]);

                    $admin_wallet = AdminWallet::firstOrCreate(
                        ['wallet_type' => 'LESS_LEVEL_COMMISSION'],
                        ['balance' => 0]
                    );

                    $admin_wallet->increment('balance', $less_level_commissions);
                }
                return true;
            }

            SaleLevelCommissionJob::dispatch($purchasedUser, $package)->afterCommit()->onConnection('sync');

            return true;
        });

    }
}
