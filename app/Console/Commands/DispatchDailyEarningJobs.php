<?php

namespace App\Console\Commands;

use App\Jobs\GenerateUserDailyEarning;
use App\Models\PurchasedPackage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchDailyEarningJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the jobs for, Calculate the daily profit for the purchased active packages to all users!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        logger()->notice("calculate:profit started: " . Carbon::now());
        // Retrieve all users with purchased packages
        $today = Carbon::today();
        if (!$today->isWeekend()) {
            $activePackages = PurchasedPackage::with('user')
                ->where('status', 'active')
                ->where(function (Builder $query) {
                    $query->whereRaw(
                        '(WEEKDAY(`created_at`) IN (1,2,3,4) AND DATE(`created_at`) + INTERVAL 6 DAY <= DATE(NOW())) OR
                            (WEEKDAY(`created_at`) = 5 AND DATE(`created_at`) + INTERVAL 5 DAY <= DATE(NOW())) OR
	                        (WEEKDAY(`created_at`) IN (0,6) AND DATE(`created_at`) + INTERVAL 4 DAY <= DATE(NOW()))'
                    ) // after 5 days from package purchase
                    ->orWhereDate('created_at', '<', '2023-02-01');
                })
                ->where('expired_at', '>=', Carbon::now())
                ->whereDoesntHave('earnings', fn($query) => $query->whereDate('created_at', date('Y-m-d')))
                ->chunk(100, function ($activePackages) {
                    // Loop over each  active packages and calculate their profit
                    foreach ($activePackages as $package) {
                        // Set the desired execution time for the job
                        $executionTime = Carbon::parse(date('Y-m-d') . ' ' . $package->created_at->format('H:i:s'));

                        $this->info($executionTime);

                        if ($executionTime->isWeekend()) {
                            continue;
                        }
                        logger()->notice("calculate:profit jobs dispatching");
                        GenerateUserDailyEarning::dispatch($package, $executionTime)->afterCommit();

                        // TODO: uncomment if need to run exact time they purchased enable this
                        //GenerateUserDailyEarning::dispatch($package, $executionTime)->delay($executionTime)->afterCommit();
                    }
                });
            $this->info('Successfully dispatched GenerateUserDailyEarning jobs.');
            return CommandAlias::SUCCESS;
        }
        $this->warn('Today is not a week day.');
        return CommandAlias::FAILURE;
    }


}
