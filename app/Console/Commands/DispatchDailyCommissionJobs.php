<?php

namespace App\Console\Commands;

use App\Jobs\GenerateUserDailyCommission;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchDailyCommissionJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the jobs for, Calculate the daily earnings for the direct/indirect commission to all users!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger()->notice("calculate:commission started");
        // Retrieve all users with purchased packages
        $today = Carbon::today();
        if (!$today->isWeekend()) {
            $activeCommissions = Commission::with('user', 'purchasedPackage')
                /*->whereRaw('`created_at` + INTERVAL 5 DAY <= NOW()')*/
                ->where('status', 'QUALIFIED')
                ->whereDoesntHave('earnings', static function ($query) {
                    return $query->whereDate('created_at', date('Y-m-d'));
                })->chunk(100, function ($activeCommissions) {
                    foreach ($activeCommissions as $commission) {
                        $executionTime = Carbon::parse(date('Y-m-d') . ' ' . $commission->created_at->format('H:i:s'));
                        $this->info($executionTime);
                        if ($executionTime->isWeekend()) {
                            continue;
                        }
                        logger()->notice("calculate:commission jobs dispatching");
                        GenerateUserDailyCommission::dispatch($commission, $executionTime)->afterCommit();
                    }
                });
            $this->info('Successfully dispatched GenerateUserDailyCommission jobs.');
            return CommandAlias::SUCCESS;
        }
        $this->warn('Today(' . $today . ') is not a week day.');
        return CommandAlias::FAILURE;
    }
}
