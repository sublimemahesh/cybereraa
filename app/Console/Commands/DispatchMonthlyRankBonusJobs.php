<?php

namespace App\Console\Commands;

use App\Jobs\GenerateMonthlyRankBonus;
use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\RankBonusSummery;
use App\Models\Strategy;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DispatchMonthlyRankBonusJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:rank-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the jobs for, Calculate Rank bonuses each month for all active rank users!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        logger()->notice("calculate:rank-bonus started");

        try {

            $strategies = Strategy::whereIn('name', ['rank_bonus', 'rank_bonus_levels', 'rank_package_requirement'])->get();

            $rank_package_requirement = $strategies->where('name', 'rank_package_requirement')->first(null, new Strategy(['value' => '{"1":100,"2":250,"3":500,"4":1000,"5":2500,"6":5000,"7":10000}']));
            $rank_bonus_percentage = $strategies->where('name', 'rank_bonus')->first(null, new Strategy(['value' => '10']));
            $rank_bonus_levels = $strategies->where('name', 'rank_bonus_levels')->first(null, new Strategy(['value' => '3,4,5,6,7']));

            $rank_bonus_percentage = $rank_bonus_percentage->value;
            $rank_bonus_levels = explode(',', $rank_bonus_levels->value);
            $rank_bonus_levels_count = count($rank_bonus_levels);

            $first_of_month = Carbon::now()->subMonth()->firstOfMonth()->format('Y-m-d H:i:s');
            $last_of_month = Carbon::now()->subMonth()->lastOfMonth()->format('Y-m-d H:i:s');


            logger()->info("calculate:rank-bonus Month Start: {$first_of_month} | Month End: {$last_of_month}");

            $total_sale_amount = PurchasedPackage::whereIn('status', ['ACTIVE', 'EXPIRED'])
                ->whereDate('created_at','>=' , $first_of_month)
                ->whereDate('created_at','<=' , $last_of_month)
                //->whereBetween('created_at', [$first_of_month, $last_of_month])
                ->sum('invested_amount');

            logger()->info("calculate:rank-bonus Monthly Total Sale: {$total_sale_amount}");

            $one_rank_bonus_percentage = $rank_bonus_percentage / $rank_bonus_levels_count;

            logger()->info("calculate:rank-bonus Payable percentage for one rank: {$rank_bonus_percentage}/{$rank_bonus_levels_count} = {$one_rank_bonus_percentage}%");

            $one_rank_bonus_amount = ($total_sale_amount * $one_rank_bonus_percentage) / 100;
            $total_bonus_amount = $one_rank_bonus_amount * $rank_bonus_levels_count;

            $rank_bonus_summery = RankBonusSummery::updateOrCreate(
                ['start_date' => $first_of_month, 'end_date' => $last_of_month],
                [
                    'eligible_rank_levels' => json_encode($rank_bonus_levels, JSON_THROW_ON_ERROR),
                    'rank_package_requirements' => $rank_package_requirement->value,
                    'eligible_rank_level_count' => $rank_bonus_levels_count,
                    'total_rank_bonus_percentage' => $rank_bonus_percentage,
                    'monthly_total_sale' => $total_sale_amount,
                    'one_rank_bonus_percentage' => $one_rank_bonus_percentage,
                    'one_rank_bonus_amount' => $one_rank_bonus_amount,
                    'total_bonus_amount' => $total_bonus_amount,
                ]
            );

            $eligible_rankers_count = [];
            $remaining_bonus_amount = 0;

            $rank_package_requirement = json_decode($rank_package_requirement->value, true, 512, JSON_THROW_ON_ERROR);

            foreach ($rank_bonus_levels as $rank_level) {
                logger()->notice("calculate:rank-bonus Rank: {$rank_level} | started. | total amount available: {$one_rank_bonus_amount}");

                $eligible_ranks = Rank::where('rank', $rank_level)
                    ->whereNotNull('activated_at')
                    //->whereBetween('activated_at', [$first_of_month, $last_of_month]) // get previous month
                    ->where('activated_at', '<', $first_of_month) // ignore previous month rank registration
                    ->whereDoesntHave('benefits', static function ($query) {
                        $query->whereMonth('bonus_date', Carbon::now()->subMonth()->format('m'))
                            ->whereYear('bonus_date', Carbon::now()->subMonth()->format('Y'));
                    })
                    ->whereHas('user.activePackages', static function ($query) use ($rank_package_requirement, $rank_level) {
                        $query->where('invested_amount', '>=', $rank_package_requirement[$rank_level]);
                    });
                $eligible_ranks_count = $eligible_ranks->count();

                $eligible_rankers_count[$rank_level] = $eligible_ranks_count;

                if ($eligible_ranks_count <= 0) {
                    $remaining_bonus_amount += $one_rank_bonus_amount;
                    logger()->notice("calculate:rank-bonus Rank: {$rank_level} | No eligible rank users found.");
                    continue;
                }

                logger()->notice("calculate:rank-bonus Rank: {$rank_level} | {$eligible_ranks_count} Eligible rank users found.");

                $earned_amount = $one_rank_bonus_amount / $eligible_ranks->count();

                $eligible_ranks->chunk(50, static function ($ranks) use ($earned_amount) {
                    foreach ($ranks as $rank) {
                        logger()->notice("calculate:rank-bonus jobs dispatching");
                        GenerateMonthlyRankBonus::dispatch($rank, $earned_amount)->afterCommit();
                    }
                });
            }


            $rank_bonus_summery->update([
                'remaining_bonus_amount' => $remaining_bonus_amount,
                'eligible_rankers' => json_encode($eligible_rankers_count, JSON_THROW_ON_ERROR),
            ]);

        } catch (\Exception $e) {
            $this->error('Failed to finish GenerateMonthlyRankBonus Jobs dispatching: ' . $e->getMessage());
            return CommandAlias::FAILURE;
        }
        $this->info('Successfully finished GenerateMonthlyRankBonus Jobs dispatching');
        return CommandAlias::SUCCESS;
    }
}
