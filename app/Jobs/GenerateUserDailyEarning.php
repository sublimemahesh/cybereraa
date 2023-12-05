<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Log;

class GenerateUserDailyEarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $purchase;
    private ?Carbon $execution_time;

    public function __construct(PurchasedPackage $purchase, $execution_time = null)
    {
        $this->purchase = $purchase;
        $this->execution_time = $execution_time ?? now();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->purchase->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->calculateProfit($this->purchase);
    }

    private function calculateProfit(PurchasedPackage $purchase): void
    {

        try {
            DB::transaction(function () use ($purchase) {
                $earned = $purchase->earnings()->whereDate('created_at', date('Y-m-d'))->doesntExist();
                // $earned = Earning::where('purchased_package_id', $purchase->id)->whereDate('created_at', date('Y-m-d'))->doesntExist();
                if ($earned) {

                    $purchase->loadSum('earnings', 'amount');

                    $payable_percentages = Strategy::where('name', 'payable_percentages')->firstOr(fn() => new Strategy(['value' => '{"direct":0.332,"indirect":0.332,"package":1}']));
                    $payable_percentages = json_decode($payable_percentages->value, false, 512, JSON_THROW_ON_ERROR);
                    $payable_percentage = $payable_percentages->package ?? $purchase->payable_percentage;

//                    $already_earned_percentage = $purchase->earned_profit;
//                    $total_already_earned_income = ($purchase->invested_amount / 100) * $already_earned_percentage;
                    $total_already_earned_income = $purchase->earnings_sum_amount;
                    $total_allowed_income = ($purchase->invested_amount / 100) * $purchase->investment_profit;

                    $remaining_income = $total_allowed_income - $total_already_earned_income;

                    $earned_amount = $purchase->invested_amount * ((float)$payable_percentage / 100);

                    if ($total_allowed_income < ($total_already_earned_income + $earned_amount)) {
                        $earned_amount = $total_allowed_income - $total_already_earned_income;
                        $purchase->update(['status' => 'EXPIRED']);
                        Log::channel('daily')->info(
                            "Package {$purchase->id} | " .
                            "COMPLETED {$total_already_earned_income}. | " .
                            "Purchased Date: {$purchase->created_at} | " .
                            "User: {$purchase->user->username} - {$purchase->user_id}");
                    }

                    if ($earned_amount > 0) {
                        $purchase->earnings()->save(Earning::forceCreate([
                            'user_id' => $purchase->user_id,
                            'purchased_package_id' => $purchase->id,
                            'amount' => $earned_amount,
                            'payed_percentage' => $payable_percentage,
                            'type' => 'PACKAGE',
                            'status' => 'RECEIVED',
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $package_earned_income = $total_already_earned_income + $earned_amount;
                        $package_earned_income_percentage = ($package_earned_income / $purchase->total_package_profit) * 100;
                        $package_earned_income_percentage_from_profit_percentage = ($package_earned_income_percentage / 100) * $purchase->investment_profit;

                        $total_already_earned_income = $purchase->total_earned_profit + $earned_amount;
                        $total_already_earned_income_percentage = ($total_already_earned_income / $purchase->total_profit) * 100;
                        $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $purchase->total_profit_percentage;

                        $purchase->update([
                            'package_earned_profit' => $package_earned_income_percentage_from_profit_percentage,
                            'earned_profit' => $total_already_earned_income_percentage_from_profit_percentage,
                            'last_earned_at' => $this->execution_time
                        ]);

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $purchase->user_id],
                            ['balance' => 0]
                        );

                        $wallet->increment('balance', $earned_amount);

                        $purchasedUser = $purchase->user;
                        $trade_income_starts_at = 1;
                        if ($purchasedUser->super_parent_id !== null) {
                            $trade_income_level_percentages = Strategy::where('name', 'trade_income')->firstOr(fn() => new Strategy(['value' => '{"1":"50","2":"25","3":"12.50","4":"6.25"}']));
                            $trade_income_level_percentages = json_decode($trade_income_level_percentages->value, true, 512, JSON_THROW_ON_ERROR);
                            $trade_income_level_percentages_count = count($trade_income_level_percentages);

                            $trade_income_level_user = $purchasedUser->parent instanceof User ? $purchasedUser->parent : User::find($purchasedUser->super_parent_id);
                            for ($i = $trade_income_starts_at; $i <= $trade_income_level_percentages_count; $i++) {
                                $trade_income_amount = ($earned_amount * $trade_income_level_percentages[$i]) / 100;
                                $trade_income_amount_left = 0;

                                if ($trade_income_level_user->is_active) {
                                    $tradeIncomeLevelUserActivePackages = $trade_income_level_user->activePackages;

                                    foreach ($tradeIncomeLevelUserActivePackages as $activePackage) {
                                        $activePackage->loadSum('earnings', 'amount');

//                                        $trade_income_already_earned_percentage = $activePackage->earned_profit;
//                                        $total_already_earned_trade_income = ($activePackage->invested_amount / 100) * $trade_income_already_earned_percentage;
                                        $total_already_earned_trade_income = $activePackage->earnings_sum_amount;
                                        $total_allowed_trade_income = ($activePackage->invested_amount / 100) * $activePackage->investment_profit;

                                        $remaining_income = $total_allowed_trade_income - $total_already_earned_trade_income;

                                        if ($trade_income_amount > $remaining_income) {
                                            $can_paid_trade_income_amount = $total_allowed_trade_income - $total_already_earned_trade_income;
                                            $trade_income_amount_left = $trade_income_amount - $can_paid_trade_income_amount;
                                            if ($can_paid_trade_income_amount <= 0) {
                                                $activePackage->update(['status' => 'EXPIRED']);
                                                Log::channel('daily')->info(
                                                    "Package {$activePackage->id} | " .
                                                    "COMPLETED {$total_already_earned_income}. | " .
                                                    "Purchased Date: {$activePackage->created_at} | " .
                                                    "User: {$trade_income_level_user->username} - {$trade_income_level_user->id}");
                                                continue;
                                            }
                                            $trade_income_amount = $can_paid_trade_income_amount;
                                        }

                                        $activePackage->earnings()->save(Earning::forceCreate([
                                            'user_id' => $activePackage->user_id,
                                            'purchased_package_id' => $activePackage->id,
                                            'trade_income_package_id' => $purchase->id,
                                            'amount' => $trade_income_amount,
                                            'payed_percentage' => $trade_income_level_percentages[$i],
                                            'type' => 'PACKAGE',
                                            'status' => 'RECEIVED',
                                            'created_at' => $this->execution_time,
                                            'updated_at' => $this->execution_time
                                        ]));

                                        $package_earned_trade_income = $total_already_earned_trade_income + $trade_income_amount;
                                        $package_earned_trade_income_percentage = ($package_earned_trade_income / $activePackage->total_package_profit) * 100;
                                        $package_earned_trade_income_percentage_from_profit_percentage = ($package_earned_trade_income_percentage / 100) * $activePackage->investment_profit;

                                        $total_already_earned_trade_income = $activePackage->total_earned_profit + $trade_income_amount;
                                        $total_already_earned_trade_income_percentage = ($total_already_earned_trade_income / $activePackage->total_profit) * 100;
                                        $total_already_earned_trade_income_percentage_from_profit_percentage = ($total_already_earned_trade_income_percentage / 100) * $activePackage->total_profit_percentage;

                                        $activePackage->update([
                                            'package_earned_profit' => $package_earned_trade_income_percentage_from_profit_percentage,
                                            'earned_profit' => $total_already_earned_trade_income_percentage_from_profit_percentage,
                                            'last_earned_at' => $this->execution_time
                                        ]);

                                        $wallet = Wallet::firstOrCreate(
                                            ['user_id' => $trade_income_level_user->id],
                                            ['balance' => 0]
                                        );
                                        $wallet->increment('balance', $trade_income_amount);

                                        Log::channel('daily')->notice(
                                            "Trade Income Earning saved (" . date('Y-m-d') . "). | " .
                                            "Purchase Package: {$purchase->id} | " .
                                            "Trade Income Active Package: {$activePackage->id} | " .
                                            "Trade Income User: {$trade_income_level_user->username}- {$trade_income_level_user->id}");

                                        if ($trade_income_amount_left <= 0) {
                                            break;
                                        }
                                        $trade_income_amount = $trade_income_amount_left;
                                    }
                                } else {
                                    Log::channel('daily')->warning(
                                        "Trade Income Earning Active Package not found (" . date('Y-m-d') . "). | " .
                                        "Purchase Package: {$purchase->id} | " .
                                        "Trade Income User: {$trade_income_level_user->username}- {$trade_income_level_user->id}");
                                }

                                if ($trade_income_level_user->super_parent_id === null) {
                                    break;
                                }
                                $trade_income_level_user = $trade_income_level_user->parent;
                            }
                        }
                    }
                    //Wallet::updateOrCreate(['user_id' => $purchase->user_id]);
                    Log::channel('daily')->notice("Purchased Package Earning saved (" . date('Y-m-d') . "). | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
                } else {
                    Log::channel('daily')->warning("Purchased Package Already earned! (" . date('Y-m-d') . "). | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
                }
            });
        } catch (\Throwable $e) {
            Log::channel('daily')->error($e->getMessage() . " | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
        }

    }
}
