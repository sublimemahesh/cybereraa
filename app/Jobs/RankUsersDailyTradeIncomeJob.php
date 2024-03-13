<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\User;
use App\Models\Wallet;
use Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class RankUsersDailyTradeIncomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $rank_user;

    public PurchasedPackage $package;

    public float $trade_income_amount = 0;

    public int $income_level;
    private string $date;
    private Carbon|null $execution_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $rank_user, float $trade_income_amount, PurchasedPackage $package, int $income_level, string $date, $execution_time = null)
    {
        $this->rank_user = $rank_user;
        $this->trade_income_amount = $trade_income_amount;
        $this->package = $package;
        $this->income_level = $income_level;
        $this->date = $date;
        $this->execution_time = $execution_time ?? now();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $date = $this->date;
//                $earned = $purchase->earnings()->whereDate('created_at', $date)->doesntExist();
//                // $earned = Earning::where('purchased_package_id', $purchase->id)->whereDate('created_at', $date)->doesntExist();
//                if (!$earned) {
//                    return;
//                }
                $rank_trade_income_amount = $this->trade_income_amount;
                $rank_trade_income_amount_left = 0;
                $rank_user = $this->rank_user;

                if (!$rank_user->is_active_without_free_package) {
                    Log::channel('daily')->warning(
                        "TRADE_INDIRECT Income Earning Active Package not found (" . $date . "). | " .
                        "Purchase Package: {$this->package->id} | " .
                        "Trade Income User: {$rank_user->username}- {$rank_user->id}");
                    return;
                }

                $tradeIncomeLevelUserActivePackages = $rank_user->activePackagesWithoutFree;

                foreach ($tradeIncomeLevelUserActivePackages as $activePackage) {

                    if ($activePackage->total_profit_percentage <= $activePackage->earned_profit) {
                        Log::channel('daily')->warning(
                            "TRADE_INDIRECT INCOME EARNING ACTIVE PACKAGE FILLED |  " .
                            "Purchased Date: (" . $date . "). | " .
                            "total_profit_percentage <= earned_profit | " .
                            "Purchase Package: {$this->package->id} | " .
                            "Trade Income Active Package: {$activePackage->id} | " .
                            "Trade Income User: {$rank_user->username}- {$rank_user->id}");

                        continue;
                    }

//                    $activePackage->loadSum('earnings', 'amount');
//                    $total_already_earned_trade_income = $activePackage->earnings_sum_amount;
//                    $total_allowed_trade_income = ($activePackage->invested_amount / 100) * $activePackage->investment_profit;

                    $trade_income_already_earned_percentage = $activePackage->earned_profit;
                    $total_already_earned_trade_income = ($activePackage->invested_amount / 100) * $trade_income_already_earned_percentage;
                    $total_allowed_trade_income = ($activePackage->invested_amount / 100) * $activePackage->total_profit_percentage;

                    $remaining_income = $total_allowed_trade_income - $total_already_earned_trade_income;

                    if ($rank_trade_income_amount > $remaining_income) {
                        $can_paid_trade_income_amount = $total_allowed_trade_income - $total_already_earned_trade_income;

                        $activePackage->update(['status' => 'EXPIRED']);
                        Log::channel('daily')->info(
                            "Package {$activePackage->id} | " .
                            "COMPLETED {$total_allowed_trade_income}. | " .
                            "Purchased Date: {$activePackage->created_at} | " .
                            "User: {$rank_user->username} - {$rank_user->id}");
                        if ($can_paid_trade_income_amount <= 0) {
                            continue;
                        }
                        $rank_trade_income_amount_left = $rank_trade_income_amount - $can_paid_trade_income_amount;
                        $rank_trade_income_amount = $can_paid_trade_income_amount;
                    } else {
                        $rank_trade_income_amount_left = 0;
                    }

                    $activePackage->earnings()->save(Earning::forceCreate([
                        'user_id' => $activePackage->user_id,
                        'purchased_package_id' => $activePackage->id,
                        'trade_income_package_id' => $this->package->id,
                        'level_user_id' => $this->package->user_id,
                        'income_level' => $this->income_level,
                        'amount' => $rank_trade_income_amount,
                        'payed_percentage' => 0.1,
                        'type' => 'TRADE_INDIRECT',
                        'status' => 'RECEIVED',
                        'created_at' => $this->execution_time,
                        'updated_at' => $this->execution_time
                    ]));

//                    $package_earned_trade_income = $total_already_earned_trade_income + $rank_trade_income_amount;
//                    $package_earned_trade_income_percentage = ($package_earned_trade_income / $activePackage->total_package_profit) * 100;
//                    $package_earned_trade_income_percentage_from_profit_percentage = ($package_earned_trade_income_percentage / 100) * $activePackage->investment_profit;

                    $total_already_earned_trade_income = $activePackage->total_earned_profit + $rank_trade_income_amount;
                    $total_already_earned_trade_income_percentage = ($total_already_earned_trade_income / $activePackage->total_profit) * 100;
                    $total_already_earned_trade_income_percentage_from_profit_percentage = ($total_already_earned_trade_income_percentage / 100) * $activePackage->total_profit_percentage;

                    $activePackage->update([
//                        'package_earned_profit' => $package_earned_trade_income_percentage_from_profit_percentage,
                        'earned_profit' => $total_already_earned_trade_income_percentage_from_profit_percentage,
                        'last_earned_at' => $this->execution_time
                    ]);

                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $rank_user->id],
                        ['balance' => 0]
                    );
                    $wallet->increment('balance', $rank_trade_income_amount);

                    Log::channel('daily')->notice(
                        "TRADE_INDIRECT Income Earning saved (" . $date . "). | " .
                        "Purchase Package: {$this->package->id} | " .
                        "Trade Income Active Package: {$activePackage->id} | " .
                        "Trade Income User: {$rank_user->username}- {$rank_user->id}"
                    );

                    if ($rank_trade_income_amount_left <= 0) {
                        break;
                    }
                    $rank_trade_income_amount = $rank_trade_income_amount_left;
                }
            });
        } catch (\Throwable $e) {
            Log::channel('daily')->error(
                $e->getMessage() . " | " .
                "Package: " . $this->package->id . " Purchased Date: " . $this->package->created_at . " | " .
                "User: " . $this->package->user->username . "-" . $this->package->user_id
            );
        }
    }
}
