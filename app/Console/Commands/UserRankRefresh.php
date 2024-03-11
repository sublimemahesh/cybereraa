<?php

namespace App\Console\Commands;

use App\Events\RankEligibilityCheck;
use App\Jobs\UserRankOneListener;
use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UserRankRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the ranks of all users in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->newLine();
            $progressBar = $this->output->createProgressBar(User::whereRelation('roles', 'name', 'user')->count());
            $progressBar->start();

            User::whereRelation('roles', 'name', 'user')
                ->orderBy('created_at', 'ASC')
                ->chunk(100, function ($users) use ($progressBar) {
                    foreach ($users as $user) {
                        event(new RankEligibilityCheck($user));
                        $progressBar->advance();
                    }
                });
            $progressBar->finish();
            $this->newLine(2);
            $this->info('Successfully refreshed the ranks of all users in the database.');
            return CommandAlias::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return CommandAlias::FAILURE;
        }
    }
}
