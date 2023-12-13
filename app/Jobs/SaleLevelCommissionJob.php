<?php

namespace App\Jobs;

use App\Models\AdminWallet;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Log;
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
        $this->strategies = Strategy::whereIn('name', [
            'rank_gift',
            'rank_bonus',
            'commissions',
            'level_commission_requirement',
            'commission_level_count',
            'max_withdraw_limit'
        ])->get();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->package->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
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

            $level_commission_requirement = $strategies->where('name', 'level_commission_requirement')->first(null, fn() => new Strategy(['value' => 5]));

            $commissions = $strategies->where('name', 'commissions')->first(null, fn() => new Strategy(['value' => '{"1":"5","2":"2.5","3":"1.5","4":"1"}']));
            $commissions = json_decode($commissions->value, true, 512, JSON_THROW_ON_ERROR);


            $rank_gift_percentage = $strategies->where('name', 'rank_gift')->first(null, fn() => new Strategy(['value' => '5']));
            $rank_bonus_percentage = $strategies->where('name', 'rank_bonus')->first(null, fn() => new Strategy(['value' => '10']));

            $total_commission_and_bonus_percentage = $rank_gift_percentage->value + $rank_bonus_percentage->value + array_sum($commissions);
            $total_package_left_income_percentage = 100 - $total_commission_and_bonus_percentage;

            $total_package_left_income = ($package->invested_amount * $total_commission_and_bonus_percentage) / 100;
            $allocated_for_gift = ($package->invested_amount * $rank_gift_percentage->value) / 100;
            $rank_bonus_percentage = ($package->invested_amount * $rank_bonus_percentage->value) / 100;
            $total_allocated_level_commissions = ($package->invested_amount * array_sum($commissions)) / 100;
            $total_profit_for_company_from_package = ($package->invested_amount * $total_package_left_income_percentage) / 100;

            $less_level_commissions = $total_allocated_level_commissions;
            $commission_start_at = 1;
            if ($purchasedUser->super_parent_id !== null) {
                $commission_level_strategy = $strategies->where('name', 'commission_level_count')->first(null, fn() => new Strategy(['value' => 4]));
                $commission_level = (int)$commission_level_strategy->value;

                $commission_level_user = $purchasedUser->parent instanceof User ? $purchasedUser->parent : User::find($purchasedUser->super_parent_id);
                for ($i = $commission_start_at; $i <= $commission_level; $i++) {

                    $commission_amount = ($package->invested_amount * $commissions[$i]) / 100;
                    $commission_amount_left = $commission_level_user->is_active ? 0 : $commission_amount;

                    $direct_sale_count = $commission_level_user->children()->count();
                    $is_level_commission_requirement_satisfied = $direct_sale_count >= ($level_commission_requirement->value ?? 5);

                    $isQualified = $commission_level_user->is_active && $is_level_commission_requirement_satisfied;

                    Log::channel('daily')->{$isQualified ? 'info' : 'warning'}("COMMISSION ELIGIBILITY | PURCHASE PACKAGE: {$package->id} | COMMISSION AMOUNT: {$commission_amount} ", [
                        'commission_level_user' => $commission_level_user->id,
                        'direct_sale_count' => $direct_sale_count,
                        'level_commission_requirement' => $level_commission_requirement->value ?? 5,
                        'is_level_commission_requirement_satisfied' => $is_level_commission_requirement_satisfied,
                        'commission_level_user is_active' => $commission_level_user->is_active,
                        'isQualified' => $isQualified,
                    ]);

                    $commission = Commission::forceCreate([
                        'user_id' => $commission_level_user->id,
                        'purchased_package_id' => $package->id,
                        'amount' => $commission_amount,
                        'paid' => 0,
                        'type' => $i === 1 ? 'DIRECT' : 'INDIRECT',
                        'status' => $isQualified ? 'QUALIFIED' : 'DISQUALIFIED'
                    ]);

                    $less_level_commissions -= $commission->amount;


                    if ($isQualified) {
                        $commissionLevelUserActivePackages = $commission_level_user->activePackages;

                        foreach ($commissionLevelUserActivePackages as $activePackage) {
                            $already_earned_percentage = $activePackage->earned_profit;

                            $total_already_earned_income = ($activePackage->invested_amount / 100) * $already_earned_percentage;
                            $total_allowed_income = ($activePackage->invested_amount / 100) * $activePackage->total_profit_percentage;

                            $remaining_income = $total_allowed_income - $total_already_earned_income;
                            if ($commission_amount > $remaining_income) {
                                $can_paid_commission_amount = $total_allowed_income - $total_already_earned_income;
                                $commission_amount_left = $commission_amount - $can_paid_commission_amount;
                                if ($can_paid_commission_amount <= 0) {
                                    continue;
                                }
                                $commission_amount = $can_paid_commission_amount;
                            }


                            $commission->earnings()->save(Earning::forceCreate([
                                'user_id' => $commission->user_id,
                                'purchased_package_id' => $activePackage->id,
                                'amount' => $commission_amount,
                                'type' => $commission->type,
                                'status' => 'RECEIVED',
                            ]));
                            $commission->update(['last_earned_at' => \Carbon::now()]);
                            $commission->increment('paid', $commission_amount);

                            $total_already_earned_income = $activePackage->total_earned_profit + $commission_amount;
                            $total_already_earned_income_percentage = ($total_already_earned_income / $activePackage->total_profit) * 100;
                            $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $activePackage->total_profit_percentage;

                            $activePackage->update(['earned_profit' => $total_already_earned_income_percentage_from_profit_percentage]);

                            if ($activePackage->total_profit <= ($total_already_earned_income)) {
                                $activePackage->update(['status' => 'EXPIRED']);
                                Log::channel('daily')->info(
                                    "Package {$activePackage->id} | " .
                                    "COMPLETED {$total_already_earned_income}. | " .
                                    "Purchased Date: {$activePackage->created_at} | " .
                                    "User: {$activePackage->user->username} - {$activePackage->user_id}");
                            }

                            $wallet = Wallet::firstOrCreate(
                                ['user_id' => $commission->user_id],
                                ['balance' => 0]
                            );
                            $wallet->increment('balance', $commission_amount);

                            if ($commission_amount_left <= 0) {
                                break;
                            }
                            $commission_amount = $commission_amount_left;
                        }

                    }

                    if (!$isQualified || $commission_amount_left > 0) {
                        if ($commission_amount_left > 0) {
                            Commission::forceCreate([
                                'parent_id' => $commission->id,
                                'user_id' => $commission_level_user->id,
                                'purchased_package_id' => $package->id,
                                'amount' => $commission_amount_left,
                                'paid' => 0,
                                'type' => $i === 1 ? 'DIRECT' : 'INDIRECT',
                                'status' => 'DISQUALIFIED'
                            ]);
                        }
                        $commission->adminEarnings()->create([
                            'user_id' => $commission->user_id,
                            'type' => 'DISQUALIFIED_COMMISSION',
                            'amount' => $commission_amount_left,
                        ]);

                        $admin_wallet = AdminWallet::firstOrCreate(
                            ['wallet_type' => 'DISQUALIFIED_COMMISSION'],
                            ['balance' => 0]
                        );

                        $admin_wallet->increment('balance', $commission_amount_left);
                    }

                    if ($commission_level_user->super_parent_id === null) {
                        Log::channel('daily')->warning(
                            "NO INDIRECT PARENT USER FOUND | PURCHASE PACKAGE: {$package->id} | " .
                            "COMMISSION LEVEL: {$i} | " .
                            "USER : {$purchasedUser->username} - {$purchasedUser->id} | " .
                            "LEVEL USER : {$commission_level_user->username} - {$commission_level_user->id}");
                        break;
                    }
                    $commission_level_user = $commission_level_user->parent;
                }
            } else {
                Log::channel('daily')->warning("NO DIRECT PARENT USER FOUND | PURCHASE PACKAGE: {$package->id} | USER: {$purchasedUser->username} - {$purchasedUser->id}");
            }


            $log_context = compact(
                'total_commission_and_bonus_percentage',
                'total_package_left_income_percentage',
                'total_package_left_income',
                'allocated_for_gift',
                'rank_bonus_percentage',
                'total_allocated_level_commissions',
                'less_level_commissions',
                'total_profit_for_company_from_package',
            );

            Log::channel('daily')->info("PURCHASE PACKAGE: {$package->id} | INVESTED AMOUNT:{$package->invested_amount}", $log_context);

            if ($less_level_commissions > 0 || $total_profit_for_company_from_package > 0) {
                $package->adminEarnings()->create([
                    'user_id' => $purchasedUser->id, // sale purchase user
                    'type' => 'LESS_LEVEL_COMMISSION',
                    'amount' => $less_level_commissions,
                ]);
                $package->adminEarnings()->create([
                    'user_id' => $purchasedUser->id, // sale purchase user
                    'type' => 'LESS_LEVEL_COMMISSION',
                    'amount' => $total_profit_for_company_from_package,
                ]);

                $admin_wallet = AdminWallet::firstOrCreate(
                    ['wallet_type' => 'LESS_LEVEL_COMMISSION'],
                    ['balance' => 0]
                );

                $admin_wallet->increment('balance', $less_level_commissions);
                $admin_wallet->increment('balance', $total_profit_for_company_from_package);
            }


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

            $package->update(['commission_issued_at' => now()]);
        });
    }
}
