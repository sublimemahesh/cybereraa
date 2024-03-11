<?php

namespace App\Console\Commands;

use App\Jobs\RankUsersDailyTradeIncomeJob;
use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\Strategy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchRankUsersDailyTradeIncome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:rank-daily-trade-income';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates daily trade income Level 5 to 7 for Rand 3 & Rank 4 users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $execute_date = Carbon::parse($date);


        if ($execute_date->isWeekend()) {
            Log::channel('daily')->notice("calculate:rank-daily-trade-income Finished | Today is not a week day | END TIME: " . Carbon::now());
            $this->warn('Today is not a week day.');
            return CommandAlias::FAILURE;
        }

        $investment_start_at = Strategy::where('name', 'investment_start_at')->firstOr(fn() => new Strategy(['value' => 2]));

        Rank::where('rank', 3)
            ->whereNotNull('activated_at')
            ->chunkById(100, function ($rankThreeUsers) use ($investment_start_at, $date) {
                foreach ($rankThreeUsers as $rankUser) {
                    $this->releaseTradeIncomeByPurchasePackage($rankUser, $investment_start_at, $date, 5);
                }
            });

        Rank::where('rank', 4)
            ->whereNotNull('activated_at')
            ->chunkById(100, function ($rankFourUsers) use ($investment_start_at, $date) {
                foreach ($rankFourUsers as $rankFourUser) {
                    $this->releaseTradeIncomeByPurchasePackage($rankFourUser, $investment_start_at, $date, 6);
                    $this->releaseTradeIncomeByPurchasePackage($rankFourUser, $investment_start_at, $date, 7);
                }
            });

        Log::channel('daily')->notice("calculate:rank-daily-trade-income Finished | Successfully dispatched GenerateUserDailyEarning jobs | END TIME: " . Carbon::now());
        $this->info('Successfully dispatched GenerateUserDailyEarning jobs.');
        return CommandAlias::SUCCESS;
    }

    /**
     * @param User $rankUser
     * @param Strategy $investment_start_at
     * @param string $date
     * @param int $income_level
     * @return void
     */
    private function releaseTradeIncomeByPurchasePackage(User $rankUser, Strategy $investment_start_at, string $date, int $income_level): void
    {
        $rankUserDescendants = User::find($rankUser->id)
            ?->descendants()
            ->where('depth', $income_level)
            ->pluck('id')
            ->toArray();

        PurchasedPackage::with('user')
            ->whereIn('id', $rankUserDescendants)
            ->where('status', 'ACTIVE')
            ->where('is_free_package', 0)
            ->whereRaw("DATE(`created_at`) + INTERVAL {$investment_start_at->value} DAY <= '{$date}'")
            ->chunkById(100, function ($rankThreeLevelFiveDescendantsActivePackages) use ($date, $rankUser, $income_level) {
                foreach ($rankThreeLevelFiveDescendantsActivePackages as $package) {
                    // Set the desired execution time for the job
                    $executionTime = Carbon::parse($date . ' ' . $package->created_at->format('H:i:s'));

                    $this->info("{$executionTime} | Package: {$package->id} | User: {$package->user->username}");


                    if ($executionTime->isWeekend()) {
                        continue;
                    }

                    Log::channel('daily')->notice(
                        "calculate:rank-daily-trade-income jobs dispatching ({$date}). | " .
                        "Package: {$package->id} Purchased Date: {$package->created_at} | " .
                        "User: {$package->user->username}-{$package->user_id}");

                    $trade_income_amount = ($package->invested_amount * 0.1) / 100;
//                    $income_level = 5;
                    dispatch(new RankUsersDailyTradeIncomeJob(
                        $rankUser,
                        $trade_income_amount,
                        $package,
                        $income_level,
                        $date,
                        $executionTime
                    ))->afterCommit();

                }
            });
    }
}
