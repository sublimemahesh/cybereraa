<?php

namespace App\Jobs;

use App\Models\PurchasedPackage;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRankOneListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    private array $requirements;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, array $requirements)
    {
        $this->user = $user;
        $this->requirements = $requirements;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \JsonException
     */
    public function handle()
    {
        \Log::channel('daily')->info("UserRankListener JOB Started");

        $user = $this->user;

        $rank = Rank::firstOrCreate([
            'user_id' => $user->id,
            'rank' => 1
        ]);

//        if ($rank->is_active) {
//            return;
//        }

        $investment = $user->purchasedPackages()->sum('invested_amount');

        $directSales = $user->directSales()->pluck('id')->toArray();
        $direct_sales_count = count($directSales);
//        $countUsersInRange1 = User::whereIn('id', $directSales)
//            ->whereHas('purchasedPackages', function ($query) {
//                $query->where('invested_amount', '>=', 5000)
//                    ->where('invested_amount', '<', 10000);
//            })
//            ->count();

        // Count of users who purchased packages with an amount of 10000 or higher
//        $countUsersInRange2 = User::whereIn('id', $directSales)
//            ->whereHas('purchasedPackages', function ($query) {
//                $query->where('invested_amount', '>=', 10000);
//            })
//            ->count();

        $completed_requirements = [
            'investment' => $investment,
            'direct_sales_count' => $direct_sales_count,
            'cumulative_investment_of_direct_sales' => 0,
            'rank_unlocked' => [
                'direct_sales_count' => $direct_sales_count,
                'cumulative_investment_of_direct_sales' => 0
            ],
        ];

        \Log::channel('daily')->info("UserRankListener JOB | Requirements: {$user->username}", $this->requirements);
        \Log::channel('daily')->info("UserRankListener JOB | Achieved Requirements: {$user->username}", $completed_requirements);

        $qualified = false;
        if ($investment >= $this->requirements['r1']['investment']) {
            $cumulative_investment_of_direct_sales = PurchasedPackage::whereIn('user_id', $directSales)->sum('invested_amount');
            $completed_requirements['cumulative_investment_of_direct_sales'] = $cumulative_investment_of_direct_sales;
            $completed_requirements['rank_unlocked']['cumulative_investment_of_direct_sales'] = $cumulative_investment_of_direct_sales;

            if ($cumulative_investment_of_direct_sales >= $this->requirements['r1']['team'][10] && $direct_sales_count >= 10) {
                $completed_requirements['rank_unlocked'] = [
                    'direct_sales_count' => 10,
                    'cumulative_investment_of_direct_sales' => $this->requirements['r1']['team'][10]
                ];
                $rank->update(['activated_at' => Carbon::now()]);
                $qualified = true;
            }

            if ($cumulative_investment_of_direct_sales >= $this->requirements['r1']['team'][5] && $direct_sales_count >= 5) {
                $completed_requirements['rank_unlocked'] = [
                    'direct_sales_count' => 5,
                    'cumulative_investment_of_direct_sales' => $this->requirements['r1']['team'][5]
                ];
                $rank->update(['activated_at' => Carbon::now()]);
                $qualified = true;
            }

//            if ($countUsersInRange1 >= $this->requirements['r1']['team']['5000'] || $countUsersInRange2 >= $this->requirements['r1']['team']['5000']) {
//                $rank->update(['activated_at' => Carbon::now()]);
//            }
        }


        if (!$qualified) {
            $rank->update(['activated_at' => null]);
        }

        $rank->update(compact('completed_requirements'));

        if ($qualified) {
            $rank_one_user = $user;
            for ($i = 1; $i <= 4; $i++) {
                $parent_user = $rank_one_user->sponsor;
                if ($parent_user->id === null) {
                    break;
                }
                UserRankTwoListener::dispatch($parent_user, $this->requirements)->onConnection('sync');
                $rank_one_user = $parent_user;
            }
        }

        \Log::channel('daily')->info("UserRankListener JOB Finished: {$user->username}", $rank->toArray());
    }
}
