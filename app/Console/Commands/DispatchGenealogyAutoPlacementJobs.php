<?php

namespace App\Console\Commands;

use App\Jobs\NewUserGenealogyAutoPlacement;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchGenealogyAutoPlacementJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genealogy:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically place yesterday registered OR newly package purchased active users(Not yet assigned) in the genealogy.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger()->notice("genealogy:assign started...");

        try {
            $users = User::whereNull('position')
                ->whereNotNull('super_parent_id')
                ->whereHas('activePackages')
                //TODO: If joined user purchased package after a one day, may parent user cannot be able to place this user in desired position.
                // if that parent user need time even after the package is purchased check one day after with purchased_package table
                ->whereRaw('`created_at` <= NOW() - INTERVAL 1 DAY')
                ->chunk(100, function ($users) {
                    foreach ($users as $user) {
                        if ($user->position !== null) {
                            logger()->warning("NewUserGenealogyAutoPlacement::class : Position is already assigned");
                            continue;
                        }
                        $executionTime = Carbon::parse($user->created_at)->addDay();
                        $this->info($executionTime);
                        logger()->notice("genealogy:assign jobs dispatching...");
                        NewUserGenealogyAutoPlacement::dispatch($user)->delay($executionTime)->afterCommit();
                    }
                });

            $this->info('Successfully dispatched GenerateUserDailyEarning jobs.');
            return CommandAlias::SUCCESS;

        } catch (Exception $e) {
            logger()->notice("genealogy:assign failed: " . $e->getMessage());
            $this->error($e->getMessage());
            return CommandAlias::FAILURE;
        }
    }
}
