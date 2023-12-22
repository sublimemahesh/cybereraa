<?php

namespace App\Console\Commands;

use App\Jobs\SaleLevelCommissionJob;
use App\Models\PurchasedPackage;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchPendingSaleLavelCommissionJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issue:pending-level-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run pending level commissions for purchased packages.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running pending commissions...');

        // Query pending commission packages
        $pendingPackages = PurchasedPackage::with('user')
            ->whereNull('commission_issued_at')
            ->whereIn('status', ['ACTIVE', 'EXPIRED'])
            ->whereDoesntHave('commissions')
            ->chunk(100, function ($pendingPackages) {
                // Dispatch jobs for each pending package
                foreach ($pendingPackages as $package) {
                    $this->info(' user: ' . $package->user_id . ' | package: ' . $package->id);
                    SaleLevelCommissionJob::dispatch($package->user, $package)
                        ->afterCommit()
                        ->onConnection('sync');
                }
            });
        $this->info('Pending commissions processed.');
        return CommandAlias::SUCCESS;
    }
}
