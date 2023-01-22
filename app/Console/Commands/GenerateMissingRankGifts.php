<?php

namespace App\Console\Commands;

use App\Models\Rank;
use App\Models\RankGift;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateMissingRankGifts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:rank-gifts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update all the rank gifts for current ranks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting...');
        Rank::whereNotNull('activated_at')->chunk(100, function ($ranks) {
            foreach ($ranks as $rank) {
                $rank_gift = DB::transaction(function () use ($rank) {
                    $rank_gift = RankGift::firstOrCreate([
                        'user_id' => $rank->user_id,
                        'rank_id' => $rank->id,
                    ], ['status' => 'pending']);
                    $rank_gift->renewStatus();
                    return $rank_gift;
                });
                $this->info("User:{$rank->user_id} rank:{$rank->rank} gift renewed. total investment: {$rank_gift->total_investment} &  total team investment: {$rank_gift->total_team_investment}");
            }
        });
        $this->info('Finished');
        return CommandAlias::SUCCESS;
    }
}
