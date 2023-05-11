<?php

namespace App\Console\Commands;

use App\Jobs\CalculateStakingInterestJob;
use App\Models\PurchasedStakingPlan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchStakingInterestOnMaturityDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:staking-interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release the Staking Deposit + Interest on the maturity date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger()?->notice("calculate:staking-interest started: " . Carbon::now());
        // Retrieve all users with purchased packages

        $activePackages = PurchasedStakingPlan::with('user')
            ->where('status', 'ACTIVE')
            ->whereDate('maturity_date', '<=', Carbon::now())
            ->whereDoesntHave('earnings', function ($query) {
                return $query->whereDate('created_at', Carbon::now()->format('Y-m-d'));
            })
            ->chunk(100, function ($activePackages) {
                foreach ($activePackages as $package) {
                    // Set the desired execution time for the job
                    $executionTime = Carbon::parse(Carbon::now()->format('Y-m-d') . ' ' . $package->created_at->format('H:i:s'));

                    $this->info($executionTime);

                    logger()?->notice("calculate:staking-interest jobs dispatching. | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);
                    CalculateStakingInterestJob::dispatch($package, $executionTime)->afterCommit();

                }
            });
        $this->info('Successfully dispatched CalculateStakingInterestJob jobs.');
        return CommandAlias::SUCCESS;


    }
}
