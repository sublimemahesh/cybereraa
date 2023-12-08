<?php

namespace App\Console\Commands;

use App\Models\TeamBonus;
use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RefreshSpecialBonuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:special-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the special bonus of users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            User::whereHas('directSales')
                ->whereRelation('roles', 'name', 'user')
                ->orderBy('created_at', 'ASC')
                ->chunk(100, function ($users) {
                    foreach ($users as $user) {
                        $this->info(' user: ' . $user->id . ' | parent_id: ' . $user->super_parent_id);
 
                        if ($user->children()->count() >= 10) {
                            TeamBonus::updateOrCreate([
                                'user_id' => $user->id,
                                'bonus' => '10_DIRECT_SALE',
                                'status' => 'DISQUALIFIED',
                                'type' => 'SPECIAL_BONUS'
                            ]);
                        }
                        if ($user->children()->count() >= 20) {
                            TeamBonus::updateOrCreate([
                                'user_id' => $user->id,
                                'bonus' => '20_DIRECT_SALE',
                                'status' => 'DISQUALIFIED',
                                'type' => 'SPECIAL_BONUS'
                            ]);
                        }
                        if ($user->children()->count() >= 30) {
                            TeamBonus::updateOrCreate([
                                'user_id' => $user->id,
                                'bonus' => '30_DIRECT_SALE',
                                'status' => 'DISQUALIFIED',
                                'type' => 'SPECIAL_BONUS'
                            ]);
                        }
                    }
                });

        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return CommandAlias::FAILURE;
        }
        $this->info('Successfully refreshed the ranks of all users in the database.');
        return CommandAlias::SUCCESS;
    }
}
