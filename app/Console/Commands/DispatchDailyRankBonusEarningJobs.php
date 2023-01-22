<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDailyRankBonusEarning;
use App\Models\RankBenefit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchDailyRankBonusEarningJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:rank-benefit-earning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the jobs for, Calculate the daily Rank Benefits for all users!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger()->notice("calculate:rank-benefit-earning");

        $today = Carbon::today();
        if (!$today->isWeekend()) {
            RankBenefit::with('user', 'rank')
                ->where('status', 'QUALIFIED')
                ->where('type', 'RANK_BONUS')
                ->whereDoesntHave('earnings', static function ($query) {
                    return $query->whereDate('created_at', date('Y-m-d'));
                })->chunk(100, function ($activeBenefits) {
                    foreach ($activeBenefits as $benefit) {
                        $executionTime = Carbon::parse(date('Y-m-d') . ' ' . $benefit->created_at->format('H:i:s'));
                        $this->info($executionTime);
                        if ($executionTime->isWeekend()) {
                            continue;
                        }
                        logger()->notice("calculate:rank-benefit-earning GenerateDailyRankBonusEarning jobs are dispatching...");
                        GenerateDailyRankBonusEarning::dispatch($benefit, $executionTime)->afterCommit();
                    }
                });
            $this->info('Successfully dispatched GenerateDailyRankBonusEarning jobs.');
            return CommandAlias::SUCCESS;
        }
        $this->warn('Today(' . $today . ') is not a week day.');
        return CommandAlias::FAILURE;
    }
}
