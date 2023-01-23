<?php

namespace App\Console\Commands;

use App\Models\User;
use DB;
use Illuminate\Console\Command;

class refreshRanks extends Command
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
    protected $description = 'Refresh the ranks of all users in the database.';

    /**
     * Execute the console command.
     *
     * @return int
     *
     */
    public function handle()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('rank_gifts')->truncate();
            DB::table('ranks')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            User::whereNotNull('parent_id')
                ->whereNotNull('position')
                ->orderBy('created_at', 'DESC')
                ->chunk(100, function ($users) {
                    foreach ($users as $user) {
                        $this->info(' user: ' . $user->id . ' | parent_id: ' . $user->parent_id . ' | position: ' . $user->position);
                        User::upgradeAncestorsRank($user->parent, 1, $user->position);
                    }
                });

        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
        $this->info('Successfully refreshed the ranks of all users in the database.');
        return Command::SUCCESS;
    }
}
