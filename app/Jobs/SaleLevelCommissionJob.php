<?php

namespace App\Jobs;

use App\Models\AdminWallet;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use JsonException;
use Throwable;

class SaleLevelCommissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $package;

    private User $purchasedUser;

    private mixed $strategies;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $purchasedUser, PurchasedPackage $package)
    {
        $this->purchasedUser = $purchasedUser;
        $this->package = $package;
        $this->strategies = Strategy::whereIn('name', ['rank_gift', 'rank_bonus', 'commissions', 'commission_level_count', 'max_withdraw_limit'])->get();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->package->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws JsonException
     * @throws Throwable
     */
    public function handle()
    {
        \DB::transaction(function () {
            $purchasedUser = $this->purchasedUser;
            $package = $this->package;
            $strategies = $this->strategies;

            if ($package->invested_amount <= 0) {
                $package->update(['commission_issued_at' => now()]);
                return true;
            }

//            $commissions = $strategies->where('name', 'commissions')->first(null, fn() => new Strategy(['value' => '{}']));
//            $commissions = json_decode($commissions->value, true, 512, JSON_THROW_ON_ERROR);

//            $commission_start_at = 1;


//            if ($purchasedUser->super_parent_id !== null) {
//                $commission = Commission::forceCreate([
//                    'user_id' => $purchasedUser->super_parent_id,
//                    'purchased_package_id' => $package->id,
//                    'amount' => ($package->invested_amount * $commissions[$commission_start_at]) / 100,
//                    'paid' => 0,
//                    'type' => 'DIRECT',
//                    'status' => $purchasedUser->sponsor->is_active ? 'QUALIFIED' : 'DISQUALIFIED'
//                ]);
//                //TODO: Send EMAIL Notification
//
//                $less_level_commissions -= $commission->amount;
//
//                if (!$purchasedUser->sponsor->is_active) {
//                    $commission->adminEarnings()->create([
//                        'user_id' => $commission->user_id,
//                        'type' => 'DISQUALIFIED_COMMISSION',
//                        'amount' => $commission->amount,
//                    ]);
//
//                    $admin_wallet = AdminWallet::firstOrCreate(
//                        ['wallet_type' => 'DISQUALIFIED_COMMISSION'],
//                        ['balance' => 0]
//                    );
//
//                    $admin_wallet->increment('balance', $commission->amount);
//                }
//            }

//            if ($purchasedUser->parent_id !== null) {
//                $commission_level_strategy = $strategies->where('name', 'commission_level_count')->first(null, fn() => new Strategy(['value' => 0]));
//                $commission_level = (int)$commission_level_strategy->value;
//                $commission_start_at = 2;
//
//                $commission_level_user = $purchasedUser->parent;
//                for ($i = $commission_start_at; $i <= $commission_level; $i++) {
//                    $commission = Commission::forceCreate([
//                        'user_id' => $commission_level_user->id,
//                        'purchased_package_id' => $package->id,
//                        'amount' => ($package->invested_amount * $commissions[$i]) / 100,
//                        'paid' => 0,
//                        'type' => 'INDIRECT',
//                        'status' => $commission_level_user->is_active ? 'QUALIFIED' : 'DISQUALIFIED'
//                    ]);
//
//                    $less_level_commissions -= $commission->amount;
//
//                    if (!$commission_level_user->is_active) {
//                        $commission->adminEarnings()->create([
//                            'user_id' => $commission->user_id,
//                            'type' => 'DISQUALIFIED_COMMISSION',
//                            'amount' => $commission->amount,
//                        ]);
//
//                        $admin_wallet = AdminWallet::firstOrCreate(
//                            ['wallet_type' => 'DISQUALIFIED_COMMISSION'],
//                            ['balance' => 0]
//                        );
//
//                        $admin_wallet->increment('balance', $commission->amount);
//                    }
//
//                    if ($commission_level_user->parent_id === null) {
//                        break;
//                    }
//                    $commission_level_user = $commission_level_user->parent;
//                }
//            }


            $rank_gift_percentage = $strategies->where('name', 'rank_gift')->first(null, fn() => new Strategy(['value' => '5']));
            $rank_bonus_percentage = $strategies->where('name', 'rank_bonus')->first(null, fn() => new Strategy(['value' => '10']));
            $less_level_commissions = ($package->invested_amount * (100 - ($rank_gift_percentage->value + $rank_bonus_percentage->value))) / 100;

            $allocated_for_gift = ($package->invested_amount * $rank_gift_percentage->value) / 100;
            $package->adminEarnings()->create([
                'user_id' => $purchasedUser->id, // sale purchase user
                'type' => 'GIFT',
                'amount' => $allocated_for_gift,
            ]);
            $admin_wallet = AdminWallet::firstOrCreate(
                ['wallet_type' => 'GIFT'],
                ['balance' => 0]
            );
            $admin_wallet->increment('balance', $allocated_for_gift);


            $rank_bonus_percentage = ($package->invested_amount * $rank_bonus_percentage->value) / 100;
            $package->adminEarnings()->create([
                'user_id' => $purchasedUser->id, // sale purchase user
                'type' => 'BONUS_PENDING',
                'amount' => $rank_bonus_percentage,
            ]);
            $admin_wallet = AdminWallet::firstOrCreate(
                ['wallet_type' => 'BONUS_PENDING'],
                ['balance' => 0]
            );
            $admin_wallet->increment('balance', $rank_bonus_percentage);


            logger()->info("id: {$package->id} | invested_amount:{$package->invested_amount} | less_level_commissions  :{$less_level_commissions}");

            if ($less_level_commissions > 0) {
                $package->adminEarnings()->create([
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
            $package->update(['commission_issued_at' => now()]);
        });
    }
}
